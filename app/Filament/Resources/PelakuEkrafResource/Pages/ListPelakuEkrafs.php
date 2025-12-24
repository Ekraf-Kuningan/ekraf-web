<?php

namespace App\Filament\Resources\PelakuEkrafResource\Pages;

use App\Filament\Resources\PelakuEkrafResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPelakuEkrafs extends ListRecords
{
    protected static string $resource = PelakuEkrafResource::class;
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
