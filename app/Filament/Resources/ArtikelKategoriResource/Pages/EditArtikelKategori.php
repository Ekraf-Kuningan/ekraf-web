<?php

namespace App\Filament\Resources\ArtikelKategoriResource\Pages;

use App\Filament\Resources\ArtikelKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtikelKategori extends EditRecord
{
    protected static string $resource = ArtikelKategoriResource::class;
    protected static ?string $title = 'Edit Kategori Artikel';
    protected static ?string $breadcrumb = 'Edit Kategori Artikel';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
