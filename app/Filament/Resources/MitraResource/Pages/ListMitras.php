<?php

namespace App\Filament\Resources\MitraResource\Pages;

use App\Filament\Resources\MitraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMitras extends ListRecords
{
    protected static string $resource = MitraResource::class;
    protected static ?string $title = 'Daftar Pelaku Ekraf';
    protected static ?string $breadcrumb = 'Daftar Pelaku Ekraf';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pelaku Ekraf')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }
}
