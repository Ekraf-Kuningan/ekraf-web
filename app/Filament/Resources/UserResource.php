<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Traits\HasRoleBasedAccess;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    use HasRoleBasedAccess;
    
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen User';
    protected static ?string $navigationLabel = 'User';
    protected static ?string $pluralLabel = 'User';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Profile Picture')
                            ->image()
                            ->directory('users')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('200')
                            ->imageResizeTargetHeight('200')
                            ->avatar()
                            ->nullable()
                            ->columnSpanFull()
                            ->helperText('Upload avatar user. Gambar akan diupload ke Cloudinary. Ukuran ideal: 200x200px'),
                            
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('username')
                            ->unique(User::class, 'username', ignoreRecord: true)
                            ->maxLength(45)
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->maxLength(255),
                            
                        Forms\Components\Select::make('level_id')
                            ->label('Level User')
                            ->relationship('level', 'name')
                            ->required()
                            ->default(3)
                            ->helperText('Pilih role user: Super Admin, Admin, atau Mitra'),
                            
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female'
                            ])
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->maxLength(20)
                            ->nullable(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Business Information')
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK (Nomor Induk Kependudukan)')
                            ->mask('9999999999999999')
                            ->length(16)
                            ->placeholder('1234567890123456')
                            ->helperText('16 digit NIK sesuai KTP')
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('nib')
                            ->label('NIB (Nomor Izin Berusaha)')
                            ->mask('9999999999999')
                            ->length(13)
                            ->placeholder('1234567890123')
                            ->helperText('13 digit NIB dari OSS')
                            ->nullable(),
                            
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Masukkan alamat lengkap')
                            ->columnSpanFull()
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Profile Picture')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->label('Level')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('mitra.business_name')
                    ->label('Business Name')
                    ->searchable()
                    ->toggleable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),
                Tables\Columns\TextColumn::make('nib')
                    ->label('NIB')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level_id')
                    ->label('Filter by Level')
                    ->relationship('level', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PelakuEkrafRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
