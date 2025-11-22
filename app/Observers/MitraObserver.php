<?php

namespace App\Observers;

use App\Models\Mitra;
use Illuminate\Support\Facades\Log;

class MitraObserver
{
    /**
     * Handle the Mitra "created" event.
     */
    public function created(Mitra $mitra): void
    {
        //
    }

    /**
     * Handle the Mitra "updated" event.
     */
    public function updated(Mitra $mitra): void
    {
        //
    }

    /**
     * Handle the Mitra "deleted" event.
     */
    public function deleted(Mitra $mitra): void
    {
        // Hapus user terkait jika mitra dihapus
        if ($mitra->user) {
            Log::info('Deleting user associated with mitra', [
                'mitra_id' => $mitra->id,
                'user_id' => $mitra->user_id,
                'user_name' => $mitra->user->name
            ]);
            
            // Hapus foto dari Cloudinary jika ada
            if ($mitra->user->cloudinary_id) {
                try {
                    $cloudinaryService = app(\App\Services\CloudinaryService::class);
                    $cloudinaryService->deleteFile($mitra->user->cloudinary_id);
                    Log::info('Deleted user image from Cloudinary', [
                        'cloudinary_id' => $mitra->user->cloudinary_id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to delete user image from Cloudinary: ' . $e->getMessage());
                }
            }
            
            $mitra->user->delete();
        }
    }

    /**
     * Handle the Mitra "restored" event.
     */
    public function restored(Mitra $mitra): void
    {
        //
    }

    /**
     * Handle the Mitra "force deleted" event.
     */
    public function forceDeleted(Mitra $mitra): void
    {
        //
    }
}
