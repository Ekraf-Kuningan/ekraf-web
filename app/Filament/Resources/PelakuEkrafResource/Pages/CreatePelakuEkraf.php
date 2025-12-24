<?php

namespace App\Filament\Resources\PelakuEkrafResource\Pages;

use App\Filament\Resources\PelakuEkrafResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePelakuEkraf extends CreateRecord
{
    protected static string $resource = PelakuEkrafResource::class;
    protected static ?string $title = 'Tambah Pelaku Ekraf';
    protected static ?string $breadcrumb = 'Tambah Pelaku Ekraf'; 
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
