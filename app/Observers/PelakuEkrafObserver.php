<?php

namespace App\Observers;

use App\Models\PelakuEkraf;
use Illuminate\Support\Facades\Log;

class PelakuEkrafObserver
{
    /**
     * Handle the PelakuEkraf "created" event.
     */
    public function created(PelakuEkraf $pelakuEkraf): void
    {
        //
    }

    /**
     * Handle the PelakuEkraf "updated" event.
     */
    public function updated(PelakuEkraf $pelakuEkraf): void
    {
        //
    }

    /**
     * Handle the PelakuEkraf "deleted" event.
     */
    public function deleted(PelakuEkraf $pelakuEkraf): void
    {
        // Hapus user terkait jika pelaku ekraf dihapus
        if ($pelakuEkraf->user) {
            Log::info('Deleting user associated with pelaku ekraf', [
                'pelaku_ekraf_id' => $pelakuEkraf->id,
                'user_id' => $pelakuEkraf->user_id,
                'user_name' => $pelakuEkraf->user->name
            ]);
            
            // Hapus foto dari Cloudinary jika ada
            if ($pelakuEkraf->user->cloudinary_id) {
                try {
                    $cloudinaryService = app(\App\Services\CloudinaryService::class);
                    $cloudinaryService->deleteFile($pelakuEkraf->user->cloudinary_id);
                    Log::info('Deleted user image from Cloudinary', [
                        'cloudinary_id' => $pelakuEkraf->user->cloudinary_id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to delete user image from Cloudinary: ' . $e->getMessage());
                }
            }
            
            $pelakuEkraf->user->delete();
        }
    }

    /**
     * Handle the PelakuEkraf "restored" event.
     */
    public function restored(PelakuEkraf $pelakuEkraf): void
    {
        //
    }

    /**
     * Handle the PelakuEkraf "force deleted" event.
     */
    public function forceDeleted(PelakuEkraf $pelakuEkraf): void
    {
        //
    }
}
