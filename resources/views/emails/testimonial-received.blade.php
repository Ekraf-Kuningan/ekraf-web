<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
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
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .rating {
            color: #f59e0b;
            font-size: 24px;
            margin: 20px 0;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-left: 4px solid #f97316;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .type-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #fef3c7;
            color: #92400e;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Terima Kasih, {{ $testimonial->name }}!</h1>
        <p>{{ ucfirst($testimonial->type) }} Anda Telah Kami Terima</p>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $testimonial->name }}</strong>,</p>
        
        <p>Terima kasih telah meluangkan waktu untuk memberikan <span class="type-badge">{{ ucfirst($testimonial->type) }}</span> kepada EKRAF Kuningan.</p>
        
        @if($testimonial->rating)
        <div class="rating">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $testimonial->rating)
                    ⭐
                @else
                    ☆
                @endif
            @endfor
            <span style="font-size: 16px; color: #6b7280;">({{ $testimonial->rating }}/5)</span>
        </div>
        @endif
        
        <div class="message-box">
            <strong>{{ ucfirst($testimonial->type) }} Anda:</strong>
            <p style="margin-top: 10px;">{{ $testimonial->message }}</p>
        </div>
        
        <p>{{ ucfirst($testimonial->type) }} Anda sangat berarti bagi kami dan akan membantu kami untuk terus meningkatkan layanan kepada seluruh pelaku EKRAF di Kuningan.</p>
        
        @if($testimonial->type === 'testimoni')
        <p>Testimoni Anda akan kami review dan jika disetujui, akan ditampilkan di website kami untuk menginspirasi pelaku EKRAF lainnya.</p>
        @endif
        
        <p>Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami.</p>
        
        <p style="margin-top: 30px;">
            Salam hangat,<br>
            <strong>Tim Ekonomi Kreatif Kabupaten Kuningan</strong>
        </p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        <p>© {{ date('Y') }} EKRAF Kuningan. All rights reserved.</p>
    </div>
</body>
</html>
