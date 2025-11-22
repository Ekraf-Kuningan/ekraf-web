<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MitraResource\Pages;
use App\Filament\Resources\MitraResource\RelationManagers;
use App\Filament\Traits\HasRoleBasedAccess;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Level;
use App\Models\SubSektor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MitraResource extends Resource
{
    use HasRoleBasedAccess;
    
    protected static ?string $model = Mitra::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Pelaku Ekraf';
    protected static ?string $pluralLabel = 'Pelaku Ekraf';
    protected static ?string $modelLabel = 'Pelaku Ekraf';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationGroup = 'Manajemen Bisnis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi User')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable(['name', 'email', 'username'])
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('username')
                                    ->required()
                                    ->unique('users', 'username')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique('users', 'email')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone_number')
                                    ->tel()
                                    ->maxLength(20),
                                Forms\Components\Select::make('gender')
                                    ->options([
                                        'male' => 'Laki-laki',
                                        'female' => 'Perempuan',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->minLength(8),
                            ])
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->email})")
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Informasi Usaha')
                    ->schema([
                        Forms\Components\TextInput::make('business_name')
                            ->label('Nama Usaha')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('business_status')
                            ->label('Status Usaha')
                            ->options([
                                'new' => 'Usaha Baru',
                                'existing' => 'Usaha Lama',
                            ])
                            ->required(),

                        Forms\Components\Select::make('sub_sektor_id')
                            ->label('Sub Sektor')
                            ->relationship('subSektor', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Usaha')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
         ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', function ($q) {
                $q->where('level_id', 3); // Filter hanya mitra (level_id = 3)
            }))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email disalin!')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.phone_number')
                    ->label('No. HP')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('business_name')
                    ->label('Nama Usaha')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\BadgeColumn::make('business_status')
                    ->label('Status Usaha')
                    ->colors([
                        'success' => 'existing',
                        'warning' => 'new',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Usaha Baru',
                        'existing' => 'Usaha Lama',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('subSektor.title')
                    ->label('Sub Sektor')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('business_status')
                    ->label('Status Usaha')
                    ->options([
                        'new' => 'Usaha Baru',
                        'existing' => 'Usaha Lama',
                    ]),

                Tables\Filters\SelectFilter::make('sub_sektor_id')
                    ->label('Sub Sektor')
                    ->relationship('subSektor', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMitras::route('/'),
            'create' => Pages\CreateMitra::route('/create'),
            'edit' => Pages\EditMitra::route('/{record}/edit'),
        ];
    }
     public static function getNavigationBadge(): ?string
    {
        return (string) \App\Models\Mitra::count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}
