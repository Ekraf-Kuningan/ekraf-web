<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProdukExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $status;
    protected $subSektorId;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($status = 'all', $subSektorId = 'all', $dateFrom = null, $dateTo = null)
    {
        $this->status = $status;
        $this->subSektorId = $subSektorId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Product::with(['user', 'subSektor', 'businessCategory']);
        
        // Filter by status
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }
        
        // Filter by sub sektor
        if ($this->subSektorId !== 'all') {
            $query->where('sub_sektor_id', $this->subSektorId);
        }
        
        // Filter by date range
        if ($this->dateFrom) {
            $query->whereDate('uploaded_at', '>=', $this->dateFrom);
        }
        
        if ($this->dateTo) {
            $query->whereDate('uploaded_at', '<=', $this->dateTo);
        }
        
        return $query->orderBy('uploaded_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Nama Pemilik',
            'Kategori',
            'Business Category',
            'Harga',
            'Stok',
            'Nomor Telepon',
            'Status',
            'Tanggal Upload',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->user?->name ?? '-',
            $product->subSektor?->title ?? '-',
            $product->businessCategory?->name ?? '-',
            'Rp ' . number_format($product->price, 0, ',', '.'),
            $product->stock,
            $product->user?->phone_number ?? '-',
            match($product->status) {
                'pending' => 'Menunggu Verifikasi',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'inactive' => 'Tidak Aktif',
                default => $product->status,
            },
            $product->uploaded_at?->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 30,
            'C' => 25,
            'D' => 20,
            'E' => 25,
            'F' => 15,
            'G' => 10,
            'H' => 15,
            'I' => 20,
            'J' => 18,
        ];
    }
}
