<?php

namespace App\Filament\Resources\SubSektorResource\Pages;

use App\Filament\Resources\SubSektorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubSektor extends CreateRecord
{
    protected static string $resource = SubSektorResource::class;
    protected static ?string $title = 'Tambah Sub Sektor';
    protected static ?string $breadcrumb = 'Tambah Sub Sektor';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
