<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use App\Models\Testimonial;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTestimonials extends ListRecords
{
    protected static string $resource = TestimonialResource::class;
    protected static ?string $title = 'Daftar Testimoni';
    protected static ?string $navigationLabel = 'Daftar Testimoni';
    protected static ?string $breadcrumb = 'Daftar Testimoni';

    public function getDefaultActiveTab(): string | int | null
    {
        return 'semua';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Testimoni')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua')
                ->badge(Testimonial::count()),
                
            'pending' => Tab::make('Pending')
                ->badge(Testimonial::where('status', 'pending')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending')),
                
            'approved' => Tab::make('Disetujui')
                ->badge(Testimonial::where('status', 'approved')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved')),
                
            'rejected' => Tab::make('Ditolak')
                ->badge(Testimonial::where('status', 'rejected')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected')),
                
            'testimoni' => Tab::make('Testimoni')
                ->badge(Testimonial::where('type', 'testimoni')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'testimoni')),
                
            'saran' => Tab::make('Saran')
                ->badge(Testimonial::whereIn('type', ['saran', 'masukan'])->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('type', ['saran', 'masukan'])),
        ];
    }
}

