<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Traits\HasRoleBasedAccess;
use App\Models\Product;
use App\Models\User;
use App\Models\SubSektor;
use App\Models\BusinessCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use App\Exports\ProdukExport;
use Filament\Support\Enums\Size;
use Filament\Tables\Actions\ActionGroup;

class ProductResource extends Resource
{
    use HasRoleBasedAccess;
    
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?int $navigationSort = 8;
    protected static ?string $pluralLabel = 'Produk';
    protected static ?string $navigationGroup = 'Manajemen Bisnis';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('sub_sektor_id')
                    ->label('Sub Sector')
                    ->relationship('subSektor', 'title')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn (Set $set) => $set('business_category_id', null))
                    ->required(),

                Forms\Components\Select::make('business_category_id')
                    ->label('Business Category')
                    ->options(function (Get $get): array {
                        $subSektorId = $get('sub_sektor_id');
                        
                        if (!$subSektorId) {
                            return [];
                        }
                        
                        return \App\Models\BusinessCategory::query()
                            ->where('sub_sector_id', $subSektorId)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->reactive()
                    ->placeholder(fn (Get $get): string => 
                        $get('sub_sektor_id') 
                            ? 'Pilih Business Category' 
                            : 'Pilih Sub Sector terlebih dahulu'
                    )
                    ->helperText('Akan muncul setelah memilih Sub Sector')
                    ->nullable(),

                Forms\Components\TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(50)
                    ->unique(
                        table: Product::class, 
                        column: 'name',
                        ignoreRecord: true
                    )
                    ->rules([
                        function ($livewire) {
                            return function (string $attribute, $value, \Closure $fail) use ($livewire) {
                                // Get current record ID if editing
                                $currentId = $livewire->record->id ?? null;
                                
                                // Check if product name already exists (case-insensitive)
                                $query = Product::whereRaw('LOWER(name) = ?', [strtolower($value)]);
                                
                                // Exclude current record when editing
                                if ($currentId) {
                                    $query->where('id', '!=', $currentId);
                                }
                                
                                if ($query->exists()) {
                                    $fail('Nama produk "' . $value . '" sudah digunakan. Silakan gunakan nama yang berbeda.');
                                }
                            };
                        },
                    ])
                    ->helperText('Nama produk harus unik dan belum pernah digunakan sebelumnya.')
                    ->live(onBlur: true)
                    ->validationMessages([
                        'required' => 'Nama produk wajib diisi.',
                        'max' => 'Nama produk maksimal 50 karakter.',
                        'unique' => 'Nama produk sudah digunakan. Silakan gunakan nama lain.',
                    ]),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(500)
                    ->rows(4),

                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Forms\Components\TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->required()
                    ->default(0),

                Forms\Components\FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(8192)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('500')
                    ->imageResizeTargetHeight('500')
                    ->helperText('Upload gambar produk. Ukuran ideal: 500x500px (1:1). Max: 8MB.'),

                Forms\Components\DateTimePicker::make('uploaded_at')
                    ->label('Uploaded At')
                    ->default(now()),

                Forms\Components\Select::make('status')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'inactive' => 'Tidak Aktif',
                    ])
                    ->default('pending')
                    ->required()
                    ->helperText('Status verifikasi produk oleh admin'),

                Forms\Components\Select::make('katalogs')
                    ->label('Featured in Catalogs')
                    ->multiple()
                    ->relationship('katalogs', 'title')
                    ->searchable()
                    ->preload()
                    ->helperText('Pilih katalog dimana produk ini akan ditampilkan.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Produk')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('ID disalin!')
                    ->copyMessageDuration(1500),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/default-product.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->limit(30)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('subSektor.title')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        'inactive' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Disetujui',
                        'pending' => 'Menunggu',
                        'rejected' => 'Ditolak',
                        'inactive' => 'Tidak Aktif',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('uploaded_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\Filter::make('id')
                    ->form([
                        Forms\Components\TextInput::make('id')
                            ->label('Cari ID Produk')
                            ->placeholder('Contoh: PEK001')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['id'],
                            fn (Builder $query, $id): Builder => $query->where('id', 'like', "%{$id}%")
                        );
                    }),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'inactive' => 'Tidak Aktif',
                    ]),

                Tables\Filters\SelectFilter::make('sub_sektor_id')
                    ->label('Category')
                    ->relationship('subSektor', 'title'),
            ])
            ->actions([

                ActionGroup::make([
                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Produk')
                        ->modalDescription('Apakah Anda yakin ingin menyetujui produk ini?')
                        ->modalSubmitActionLabel('Ya, Setujui')
                        ->action(function (Product $record) {
                            $record->update([
                                'status' => 'approved',
                                'verified_at' => now(),
                                'verified_by' => auth()->id(),
                            ]);
                            
                            Notification::make()
                                ->success()
                                ->title('Produk Disetujui')
                                ->body('Produk "' . $record->name . '" telah disetujui.')
                                ->send();
                        })
                        ->visible(fn (Product $record) => $record->status === 'pending'),

                    // TAMBAH ACTION TOLAK
                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Produk')
                        ->modalDescription('Berikan alasan penolakan produk ini')
                        ->modalSubmitActionLabel('Ya, Tolak')
                        ->form([
                            Forms\Components\Textarea::make('rejection_reason')
                                ->label('Alasan Penolakan')
                                ->required()
                                ->maxLength(500)
                                ->rows(4)
                                ->placeholder('Contoh: Gambar produk tidak jelas, deskripsi tidak lengkap, harga tidak wajar, dll.')
                                ->helperText('Alasan ini akan dilihat oleh pelaku ekraf')
                        ])
                        ->action(function (Product $record, array $data) {
                            $record->update([
                                'status' => 'rejected',
                                'rejection_reason' => $data['rejection_reason'],
                                'verified_at' => now(),
                                'verified_by' => auth()->id(),
                            ]);
                            
                            Notification::make()
                                ->danger()
                                ->title('Produk Ditolak')
                                ->body('Produk "' . $record->name . '" telah ditolak dengan alasan: ' . $data['rejection_reason'])
                                ->send();
                        })
                        ->visible(fn (Product $record) => $record->status === 'pending'),

                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->label('More actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->button()

            ])
            
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // TAMBAH BULK ACTION SETUJUI
                    Tables\Actions\BulkAction::make('approve_bulk')
                        ->label('Setujui Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Produk Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menyetujui semua produk yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Setujui Semua')
                        ->action(function (Collection $records) {
                            $count = 0;
                            $records->each(function (Product $record) use (&$count) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'approved',
                                        'verified_at' => now(),
                                        'verified_by' => auth()->id(),
                                    ]);
                                    $count++;
                                }
                            });
                            
                            Notification::make()
                                ->success()
                                ->title('Produk Disetujui')
                                ->body($count . ' produk telah disetujui.')
                                ->send();
                        }),

                    // TAMBAH BULK ACTION TOLAK
                    Tables\Actions\BulkAction::make('reject_bulk')
                        ->label('Tolak Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Produk Terpilih')
                        ->modalDescription('Berikan alasan penolakan untuk semua produk yang dipilih')
                        ->modalSubmitActionLabel('Ya, Tolak Semua')
                        ->form([
                            Forms\Components\Textarea::make('rejection_reason')
                                ->label('Alasan Penolakan (untuk semua produk yang dipilih)')
                                ->required()
                                ->maxLength(500)
                                ->rows(4)
                                ->placeholder('Contoh: Gambar produk tidak memenuhi standar, kategori tidak sesuai, dll.')
                                ->helperText('Alasan yang sama akan diterapkan ke semua produk yang dipilih')
                        ])
                        ->action(function (Collection $records, array $data) {
                            $count = 0;
                            $records->each(function (Product $record) use (&$count, $data) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'rejected',
                                        'rejection_reason' => $data['rejection_reason'],
                                        'verified_at' => now(),
                                        'verified_by' => auth()->id(),
                                    ]);
                                    $count++;
                                }
                            });
                            
                            Notification::make()
                                ->danger()
                                ->title('Produk Ditolak')
                                ->body($count . ' produk telah ditolak dengan alasan: ' . $data['rejection_reason'])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return (string) \App\Models\Product::count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}