<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelKategoriResource\Pages;
use App\Filament\Resources\ArtikelKategoriResource\RelationManagers;
use App\Filament\Traits\HasRoleBasedAccess;
use App\Models\ArtikelKategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ArtikelKategoriResource extends Resource
{
    use HasRoleBasedAccess;
    
    protected static ?string $model = ArtikelKategori::class;
    protected static ?string $navigationLabel = 'Kategori Artikel';
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $pluralLabel = 'Kategori Artikel';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->maxLength(100),
                    
                Forms\Components\TextInput::make('slug')
                    ->readOnly(),
                    
                Forms\Components\FileUpload::make('icon')
                    ->label('Category Icon')
                    ->image()
                    ->directory('article-categories')
                    ->disk('cloudinary')
                    ->maxSize(1024) // 1MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                    ->nullable()
                    ->helperText('Upload an icon for this article category.'),
                    
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(300)
                    ->nullable()
                    ->columnSpanFull(),
                    
                Forms\Components\ColorPicker::make('color')
                    ->label('Category Color')
                    ->nullable()
                    ->helperText('Choose a color theme for this category.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->label('Icon')
                    ->disk('cloudinary')
                    ->circular()
                    ->size(40)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Color')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListArtikelKategoris::route('/'),
            'create' => Pages\CreateArtikelKategori::route('/create'),
            'edit' => Pages\EditArtikelKategori::route('/{record}/edit'),
        ];
    }
}
