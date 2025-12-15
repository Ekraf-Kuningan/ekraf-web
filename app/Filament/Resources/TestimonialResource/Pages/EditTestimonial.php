<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestimonial extends EditRecord
{
    protected static string $resource = TestimonialResource::class;
    protected static ?string $title = 'Edit Testimoni';
    protected static ?string $breadcrumb = 'Edit Testimoni';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
