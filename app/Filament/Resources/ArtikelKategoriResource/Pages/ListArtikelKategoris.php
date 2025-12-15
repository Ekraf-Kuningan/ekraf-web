<?php

namespace App\Filament\Resources\ArtikelKategoriResource\Pages;

use App\Filament\Resources\ArtikelKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtikelKategoris extends ListRecords
{
    protected static string $resource = ArtikelKategoriResource::class;
    protected static ?string $title = 'Daftar Kategori Artikel';
    protected static ?string $navigationLabel = 'Daftar Kategori Artikel';
    protected static ?string $breadcrumb = 'Daftar Kategori Artikel';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Kategori Artikel')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }
}
