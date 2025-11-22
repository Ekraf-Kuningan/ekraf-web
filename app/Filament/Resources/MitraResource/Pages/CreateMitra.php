<?php

namespace App\Filament\Resources\MitraResource\Pages;

use App\Filament\Resources\MitraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMitra extends CreateRecord
{
    protected static string $resource = MitraResource::class;
    protected static ?string $title = 'Tambah Pelaku Ekraf';
    protected static ?string $breadcrumb = 'Tambah Pelaku Ekraf';

}
