<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak - EKRAF Kuningan</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/LogoEkraf.png') }}">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .info-row {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #f97316;
            margin-bottom: 5px;
        }
        .value {
            color: #555;
        }
        .message-box {
            background: white;
            padding: 15px;
            border-left: 4px solid #f97316;
            margin-top: 10px;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pesan Dari Pengunjung</h2>
        <p>Ekonomi Kreatif Kabupaten Kuningan</p>
    </div>
    
    <div class="content">
        <div class="info-row">
            <div class="label">Nama:</div>
            <div class="value">{{ $data['name'] }}</div>
        </div>

        <div class="info-row">
            <div class="label">Email:</div>
            <div class="value">{{ $data['email'] }}</div>
        </div>

        <div class="info-row">
            <div class="label">Nomor Telepon:</div>
            <div class="value">{{ $data['phone'] }}</div>
        </div>

        <div class="info-row">
            <div class="label">Judul:</div>
            <div class="value">{{ $data['subject'] }}</div>
        </div>

        <div class="info-row">
            <div class="label">Pesan:</div>
            <div class="message-box">
                {!! nl2br(e($data['message'])) !!}
            </div>
        </div>

        <div class="info-row">
            <div class="label">Dikirim pada:</div>
            <div class="value">{{ now()->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis dari website EKRAF Kuningan</p>
        <p>Jl. Siliwangi No. 88, Kuningan, Jawa Barat 45511</p>
    </div>
</body>
</html>
