<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessCategoryResource\Pages;
use App\Filament\Traits\HasRoleBasedAccess;
use App\Models\BusinessCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BusinessCategoryResource extends Resource
{
    use HasRoleBasedAccess;
    
    protected static ?string $model = BusinessCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Bisnis Kategori';
    protected static ?string $navigationGroup = 'Manajemen Bisnis';
    protected static ?string $pluralLabel = 'Bisnis Kategori';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sub_sector_id')
                    ->label('Sub Sector')
                    ->relationship('subSektor', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Pilih Sub Sektor untuk kategori bisnis ini'),
                Forms\Components\TextInput::make('name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(50)
                    ->unique(BusinessCategory::class, 'name', ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subSektor.title')
                    ->label('Sub Sector')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sub_sector_id')
                    ->label('Sub Sector')
                    ->relationship('subSektor', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBusinessCategories::route('/'),
            'create' => Pages\CreateBusinessCategory::route('/create'),
            'edit' => Pages\EditBusinessCategory::route('/{record}/edit'),
        ];
    }
}
