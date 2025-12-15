<?php

namespace App\Filament\Resources\KatalogResource\Pages;

use App\Filament\Resources\KatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKatalogs extends ListRecords
{
    protected static string $resource = KatalogResource::class;
    protected static ?string $title = 'Daftar Katalog';
    protected static ?string $navigationLabel = 'Daftar Katalog';
    protected static ?string $breadcrumb = 'Daftar Katalog';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Katalog')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }
}
