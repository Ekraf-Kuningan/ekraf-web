<?php

namespace App\Filament\Resources\SubSektorResource\Pages;

use App\Filament\Resources\SubSektorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubSektor extends EditRecord
{
    protected static string $resource = SubSektorResource::class;
    protected static ?string $title = 'Edit Sub Sektor';
    protected static ?string $breadcrumb = 'Edit Sub Sektor';

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
