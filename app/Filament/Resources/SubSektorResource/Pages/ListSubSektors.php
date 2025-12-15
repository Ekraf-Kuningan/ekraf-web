<?php

namespace App\Filament\Resources\SubSektorResource\Pages;

use App\Filament\Resources\SubSektorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubSektors extends ListRecords
{
    protected static string $resource = SubSektorResource::class;
    protected static ?string $title = 'Daftar Sub Sektor';
    protected static ?string $navigationLabel = 'Daftar Sub Sektor';
    protected static ?string $breadcrumb = 'Daftar Sub Sektor';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Sub Sektor')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }
}
