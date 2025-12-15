<?php

namespace App\Filament\Resources\ArtikelResource\Pages;

use App\Filament\Resources\ArtikelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtikels extends ListRecords
{
    protected static string $resource = ArtikelResource::class;
    protected static ?string $title = 'Daftar Artikel';
    protected static ?string $navigationLabel = 'Daftar Artikel';
    protected static ?string $breadcrumb = 'Daftar Artikel';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Artikel')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }
}
