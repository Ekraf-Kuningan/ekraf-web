<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KatalogResource\Pages;
use App\Models\Katalog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class KatalogResource extends Resource
{
    protected static ?string $model = Katalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sub_sectors_id')
                    ->relationship('subSektor', 'title')
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required(),

                Forms\Components\TextInput::make('slug')
                    ->readOnly(),

                Forms\Components\FileUpload::make('produk')
                    ->image()
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('no_hp')
                    ->label('No. HP')
                    ->prefix('+62')
                    ->tel(),

                Forms\Components\TextInput::make('instagram')
                    ->prefix('@'),

                Forms\Components\TextInput::make('shopee')
                    ->label('Link Shopee'),

                Forms\Components\TextInput::make('tokopedia')
                    ->label('Link Tokopedia'),

                Forms\Components\TextInput::make('lazada')
                    ->label('Link Lazada'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subSektor.title')
                    ->label('Sub Sektor'),

                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ImageColumn::make('produk'),
                Tables\Columns\TextColumn::make('harga')
                    ->money('IDR', true),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP'),

                Tables\Columns\TextColumn::make('instagram')
                    ->label('IG'),

                Tables\Columns\TextColumn::make('shopee'),
                Tables\Columns\TextColumn::make('tokopedia'),
                Tables\Columns\TextColumn::make('lazada'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sub_sektor_id')
                    ->relationship('subSektor', 'title'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKatalogs::route('/'),
            'create' => Pages\CreateKatalog::route('/create'),
            'edit' => Pages\EditKatalog::route('/{record}/edit'),
        ];
    }
}
