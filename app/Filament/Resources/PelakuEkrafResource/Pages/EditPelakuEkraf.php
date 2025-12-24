<?php

namespace App\Filament\Resources\PelakuEkrafResource\Pages;

use App\Filament\Resources\PelakuEkrafResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPelakuEkraf extends EditRecord
{
    protected static string $resource = PelakuEkrafResource::class;
    protected static ?string $title = 'Edit Pelaku Ekraf';
    protected static ?string $breadcrumb = 'Edit Pelaku Ekraf';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
