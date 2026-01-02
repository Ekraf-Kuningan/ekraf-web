<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Testimoni & Saran';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?string $pluralModelLabel = 'Testimoni & Saran';

    protected static ?string $navigationGroup = 'Manajemen Konten';

    protected static ?int $navigationSort = 5;

    public static function canViewAny(): bool
    {
        return true; // Force allow all users to view
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Pengguna')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Pilih pengguna yang memberikan testimoni (opsional)')
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('business_name')
                            ->label('Nama Usaha')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detail Testimoni')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Jenis')
                            ->options([
                                'testimoni' => 'Testimoni',
                                'saran' => 'Saran/Masukan',
                            ])
                            ->required()
                            ->default('testimoni')
                            ->columnSpan(1),

                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '⭐ 1 Bintang',
                                2 => '⭐⭐ 2 Bintang',
                                3 => '⭐⭐⭐ 3 Bintang',
                                4 => '⭐⭐⭐⭐ 4 Bintang',
                                5 => '⭐⭐⭐⭐⭐ 5 Bintang',
                            ])
                            ->required()
                            ->default(5)
                            ->columnSpan(1),

                        Forms\Components\Textarea::make('message')
                            ->label('Pesan')
                            ->required()
                            ->rows(5)
                            ->minLength(10)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status Persetujuan')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Menunggu Persetujuan',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->default('pending')
                            ->helperText('Hanya testimoni yang disetujui yang akan ditampilkan di halaman publik'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable()
                    ->default('Guest')
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('business_name')
                    ->label('Nama Usaha')
                    ->searchable()
                    ->toggleable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable()
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state))
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'testimoni' => 'success',
                        'saran', 'masukan' => 'info',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match($state) {
                        'testimoni' => 'heroicon-o-star',
                        'saran', 'masukan' => 'heroicon-o-light-bulb',
                        default => 'heroicon-o-document-text',
                    })
                    ->formatStateUsing(fn (string $state): string => $state === 'testimoni' ? 'Testimoni' : 'Saran/Masukan'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match($state) {
                        'pending' => 'heroicon-o-clock',
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis')
                    ->options([
                        'testimoni' => 'Testimoni',
                        'saran' => 'Saran/Masukan',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        
                        if ($data['value'] === 'saran') {
                            return $query->whereIn('type', ['saran', 'masukan']);
                        }
                        
                        return $query->where('type', $data['value']);
                    }),

                Tables\Filters\SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        5 => '5 Bintang',
                        4 => '4 Bintang',
                        3 => '3 Bintang',
                        2 => '2 Bintang',
                        1 => '1 Bintang',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Testimonial $record): bool => $record->status !== 'approved')
                        ->action(function (Testimonial $record) {
                            $record->update(['status' => 'approved']);
                            Notification::make()
                                ->success()
                                ->title('Testimoni Disetujui')
                                ->body('Testimoni akan ditampilkan di halaman publik.')
                                ->send();
                        }),
                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn (Testimonial $record): bool => $record->status !== 'rejected')
                        ->action(function (Testimonial $record) {
                            $record->update(['status' => 'rejected']);
                            Notification::make()
                                ->warning()
                                ->title('Testimoni Ditolak')
                                ->body('Testimoni tidak akan ditampilkan di halaman publik.')
                                ->send();
                        }),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Setujui yang Dipilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['status' => 'approved']);
                            Notification::make()
                                ->success()
                                ->title('Testimoni Disetujui')
                                ->body(count($records) . ' testimoni telah disetujui.')
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('reject')
                        ->label('Tolak yang Dipilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['status' => 'rejected']);
                            Notification::make()
                                ->warning()
                                ->title('Testimoni Ditolak')
                                ->body(count($records) . ' testimoni telah ditolak.')
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'view' => Pages\ViewTestimonial::route('/{record}'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}

