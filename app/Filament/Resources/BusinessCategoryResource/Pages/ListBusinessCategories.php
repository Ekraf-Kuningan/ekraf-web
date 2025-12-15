<?php

namespace App\Filament\Resources\BusinessCategoryResource\Pages;

use App\Filament\Resources\BusinessCategoryResource;
use Filament\Resources\Pages\ListRecords;

class ListBusinessCategories extends ListRecords
{
    protected static string $resource = BusinessCategoryResource::class;
    protected static ?string $title = 'Daftar Kategori Bisnis';
    protected static ?string $navigationLabel = 'Daftar Kategori Bisnis';
    protected static ?string $breadcrumb = 'Daftar Kategori Bisnis';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->label('Tambah Kategori Bisnis')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }
}
