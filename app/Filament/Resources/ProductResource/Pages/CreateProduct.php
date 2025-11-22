<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = ProductResource::class;
    protected static ?string $title = 'Tambah Produk';
    protected static ?string $breadcrumb = 'Tambah Produk';
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleProductImageUpload($data);
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
