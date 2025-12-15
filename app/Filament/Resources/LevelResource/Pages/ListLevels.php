<?php

namespace App\Filament\Resources\LevelResource\Pages;

use App\Filament\Resources\LevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLevels extends ListRecords
{
    protected static string $resource = LevelResource::class;
    protected static ?string $title = 'Daftar Hak Akses';
    protected static ?string $navigationLabel = 'Daftar Hak Akses';
    protected static ?string $breadcrumb = 'Daftar Hak Akses';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Hak Akses')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }
}
