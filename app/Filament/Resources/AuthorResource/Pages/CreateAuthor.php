<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = AuthorResource::class;
    protected static ?string $title = 'Tambah Penulis';
    protected static ?string $breadcrumb = 'Tambah Penulis';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleCloudinaryUpload(
            $data,
            'avatar',
            'cloudinary_id',
            'cloudinary_meta',
            'avatars',
            200,
            200
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
