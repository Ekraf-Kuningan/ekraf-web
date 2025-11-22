<?php

namespace App\Filament\Resources\BusinessCategoryResource\Pages;

use App\Filament\Resources\BusinessCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateBusinessCategory extends CreateRecord
{
    protected static string $resource = BusinessCategoryResource::class;
    protected static ?string $title = 'Tambah Kategori Bisnis';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    public function getTitle(): string|Htmlable
    {
        return static::$title;
    }
    public function getBreadcrumb(): string
    {
        return static::$title;
    }
}
