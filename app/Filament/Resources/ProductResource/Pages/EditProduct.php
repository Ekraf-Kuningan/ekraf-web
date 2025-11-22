<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditProduct extends EditRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = ProductResource::class;
    protected static ?string $title = 'Edit Produk';
    protected static ?string $breadcrumb = 'Edit Produk';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Tidak perlu kosongkan image field, biarkan Filament handle existing image
        // Filament sudah bisa menampilkan preview tanpa reload file
        return $data;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika image tidak diubah (kosong atau null), pertahankan gambar lama
        if (empty($data['image'])) {
            // Hapus key image dari data agar tidak overwrite dengan null
            unset($data['image']);
            
            // Jika ada cloudinary data, pertahankan juga
            if ($this->record) {
                $data['cloudinary_id'] = $this->record->cloudinary_id;
                $data['cloudinary_meta'] = $this->record->cloudinary_meta;
            }
            
            return $data;
        }
        
        // Jika image diubah, proses upload seperti biasa
        $oldCloudinaryId = $this->record?->cloudinary_id;
        
        return $this->handleProductImageUpload($data, $oldCloudinaryId);
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
