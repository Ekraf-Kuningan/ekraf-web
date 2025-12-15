<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;
    protected static ?string $title = 'Daftar Penulis';
    protected static ?string $navigationLabel = 'Daftar Penulis';
    protected static ?string $breadcrumb = 'Daftar Penulis';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Penulis')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
            
        ];
    }
}
