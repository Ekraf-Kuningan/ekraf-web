<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use App\Models\SubSektor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;
    protected static ?string $title = 'Daftar Produk';
    protected static ?string $navigationLabel = 'Daftar Produk';
    protected static ?string $breadcrumb = 'Daftar Produk';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Produk')
                ->icon('heroicon-o-plus-circle')
                ->color('warning'),
            
            // Export Excel dengan Filter
            Actions\Action::make('exportExcel')
                ->label('Ekspor ke Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->form([
                    Select::make('status')
                        ->label('Filter Status')
                        ->options([
                            'all' => 'Semua Status',
                            'pending' => 'Menunggu Verifikasi',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            'inactive' => 'Tidak Aktif',
                        ])
                        ->default('all')
                        ->required(),
                    
                    Select::make('sub_sektor_id')
                        ->label('Filter Kategori')
                        ->options(function () {
                            return ['all' => 'Semua Kategori'] + SubSektor::pluck('title', 'id')->toArray();
                        })
                        ->default('all')
                        ->searchable(),
                    
                    DatePicker::make('date_from')
                        ->label('Dari Tanggal')
                        ->maxDate(now()),
                    
                    DatePicker::make('date_to')
                        ->label('Sampai Tanggal')
                        ->maxDate(now())
                        ->afterOrEqual('date_from'),
                ])
                ->action(function (array $data) {
                    return \Maatwebsite\Excel\Facades\Excel::download(
                        new \App\Exports\ProdukExport(
                            $data['status'] ?? 'all',
                            $data['sub_sektor_id'] ?? 'all',
                            $data['date_from'] ?? null,
                            $data['date_to'] ?? null
                        ),
                        'laporan-produk-' . now()->format('Y-m-d') . '.xlsx'
                    );
                }),
            
            // Export PDF dengan Filter
            Actions\Action::make('exportPdf')
                ->label('Ekspor ke PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->form([
                    Select::make('status')
                        ->label('Filter Status')
                        ->options([
                            'all' => 'Semua Status',
                            'pending' => 'Menunggu Verifikasi',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            'inactive' => 'Tidak Aktif',
                        ])
                        ->default('all')
                        ->required(),
                    
                    Select::make('sub_sektor_id')
                        ->label('Filter Kategori')
                        ->options(function () {
                            return ['all' => 'Semua Kategori'] + SubSektor::pluck('title', 'id')->toArray();
                        })
                        ->default('all')
                        ->searchable(),
                    
                    DatePicker::make('date_from')
                        ->label('Dari Tanggal')
                        ->maxDate(now()),
                    
                    DatePicker::make('date_to')
                        ->label('Sampai Tanggal')
                        ->maxDate(now())
                        ->afterOrEqual('date_from'),
                ])
                ->action(function (array $data) {
                    $query = \App\Models\Product::with(['user', 'subSektor', 'businessCategory']);
                    
                    // Filter by status
                    if ($data['status'] !== 'all') {
                        $query->where('status', $data['status']);
                    }
                    
                    // Filter by sub sektor
                    if ($data['sub_sektor_id'] !== 'all') {
                        $query->where('sub_sektor_id', $data['sub_sektor_id']);
                    }
                    
                    // Filter by date range
                    if (!empty($data['date_from'])) {
                        $query->whereDate('uploaded_at', '>=', $data['date_from']);
                    }
                    
                    if (!empty($data['date_to'])) {
                        $query->whereDate('uploaded_at', '<=', $data['date_to']);
                    }
                    
                    $products = $query->orderBy('uploaded_at', 'desc')->get();
                    
                    $pdf = Pdf::loadView('pdf.products-report', [
                        'products' => $products,
                        'filters' => $data,
                        'generatedAt' => now()->format('d F Y H:i:s'),
                    ]);
                    
                    $pdf->setPaper('a4', 'landscape');
                    
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'laporan-produk-' . now()->format('Y-m-d') . '.pdf');
                }),
        ];
    }
}
