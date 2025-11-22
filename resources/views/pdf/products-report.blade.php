<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk EKRAF Kuningan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #f97316;
        }
        
        .header h1 {
            font-size: 18px;
            color: #f97316;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .header h2 {
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }
        
        .header p {
            font-size: 9px;
            color: #666;
        }
        
        .filter-info {
            background-color: #fff7ed;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #f97316;
            border-radius: 4px;
        }
        
        .filter-info h3 {
            font-size: 11px;
            color: #f97316;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .filter-info p {
            font-size: 9px;
            color: #555;
            margin: 2px 0;
        }
        
        .filter-info strong {
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #f97316;
            color: white;
        }
        
        table thead th {
            padding: 8px 5px;
            font-size: 9px;
            font-weight: bold;
            text-align: left;
            border: 1px solid #f97316;
        }
        
        table tbody td {
            padding: 6px 5px;
            font-size: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table tbody tr:hover {
            background-color: #fff7ed;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }
        
        .status-approved {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-inactive {
            background-color: #f3f4f6;
            color: #4b5563;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
        
        .summary {
            background-color: #f0fdf4;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #bbf7d0;
        }
        
        .summary h3 {
            font-size: 11px;
            color: #166534;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .summary p {
            font-size: 9px;
            color: #166534;
            margin: 2px 0;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #999;
            font-size: 11px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>EKRAF KUNINGAN</h1>
        <h2>LAPORAN DATA PRODUK</h2>
        <p>Ekonomi Kreatif Kabupaten Kuningan - Jawa Barat</p>
    </div>
    
    <!-- Filter Information -->
    <div class="filter-info">
        <h3>Informasi Filter:</h3>
        @if($filters['status'] !== 'all')
            <p><strong>Status:</strong> 
                @switch($filters['status'])
                    @case('pending') Menunggu Verifikasi @break
                    @case('approved') Disetujui @break
                    @case('rejected') Ditolak @break
                    @case('inactive') Tidak Aktif @break
                @endswitch
            </p>
        @else
            <p><strong>Status:</strong> Semua Status</p>
        @endif
        
        @if($filters['sub_sektor_id'] !== 'all')
            <p><strong>Kategori:</strong> {{ \App\Models\SubSektor::find($filters['sub_sektor_id'])?->title ?? '-' }}</p>
        @else
            <p><strong>Kategori:</strong> Semua Kategori</p>
        @endif
        
        @if(!empty($filters['date_from']) || !empty($filters['date_to']))
            <p><strong>Periode:</strong> 
                {{ !empty($filters['date_from']) ? \Carbon\Carbon::parse($filters['date_from'])->format('d/m/Y') : 'Awal' }}
                s/d
                {{ !empty($filters['date_to']) ? \Carbon\Carbon::parse($filters['date_to'])->format('d/m/Y') : 'Sekarang' }}
            </p>
        @endif
        
        <p><strong>Waktu Cetak:</strong> {{ $generatedAt }}</p>
    </div>
    
    <!-- Summary -->
    <div class="summary">
        <h3>Ringkasan:</h3>
        <p><strong>Total Produk:</strong> {{ $products->count() }} produk</p>
        @if($filters['status'] === 'all')
            <p>
                <strong>Disetujui:</strong> {{ $products->where('status', 'approved')->count() }} | 
                <strong>Menunggu:</strong> {{ $products->where('status', 'pending')->count() }} | 
                <strong>Ditolak:</strong> {{ $products->where('status', 'rejected')->count() }} | 
                <strong>Tidak Aktif:</strong> {{ $products->where('status', 'inactive')->count() }}
            </p>
        @endif
    </div>
    
    <!-- Products Table -->
    @if($products->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 20%;">Nama Produk</th>
                    <th style="width: 15%;">Pemilik</th>
                    <th style="width: 12%;">Kategori</th>
                    <th style="width: 12%;">Harga</th>
                    <th style="width: 6%;">Stok</th>
                    <th style="width: 10%;">Telepon</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 12%;">Tgl Upload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>
                            <strong>{{ $product->owner_name }}</strong><br>
                            <small style="color: #666;">{{ $product->user?->name ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $product->subSektor?->title ?? '-' }}
                            @if($product->businessCategory)
                                <br><small style="color: #666;">{{ $product->businessCategory->name }}</small>
                            @endif
                        </td>
                        <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $product->stock }}</td>
                        <td>{{ $product->phone_number }}</td>
                        <td class="text-center">
                            <span class="status-badge status-{{ $product->status }}">
                                @switch($product->status)
                                    @case('approved') Disetujui @break
                                    @case('pending') Menunggu @break
                                    @case('rejected') Ditolak @break
                                    @case('inactive') Tidak Aktif @break
                                    @default {{ $product->status }}
                                @endswitch
                            </span>
                        </td>
                        <td class="text-center">{{ $product->uploaded_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data produk yang sesuai dengan filter yang dipilih.</p>
        </div>
    @endif
    
    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem EKRAF Kuningan</p>
        <p>© {{ date('Y') }} EKRAF Kuningan - Ekonomi Kreatif Kabupaten Kuningan</p>
    </div>
</body>
</html>
