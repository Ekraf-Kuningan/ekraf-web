<?php

namespace App\Filament\Resources\ArtikelKategoriResource\Pages;

use App\Filament\Resources\ArtikelKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtikelKategori extends CreateRecord
{
    protected static string $resource = ArtikelKategoriResource::class;
    protected static ?string $title = 'Tambah Kategori Artikel';
        protected static ?string $breadcrumb = 'Tambah Kategori Artikel';


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }  
    
}
