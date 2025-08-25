<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Booking Kolam #{{ $booking->id }} - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .user-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .user-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .user-info p {
            margin: 5px 0;
        }
        .booking-info {
            margin-bottom: 20px;
        }
        .booking-info h3 {
            color: #2563eb;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 14px;
            margin-top: 5px;
        }
        .status-pending { color: #f59e0b; }
        .status-approved { color: #10b981; }
        .status-rejected { color: #ef4444; }
        .status-completed { color: #3b82f6; }
        .payment-belum_bayar { color: #6b7280; }
        .payment-menunggu_konfirmasi { color: #f59e0b; }
        .payment-lunas { color: #10b981; }
        .payment-ditolak { color: #ef4444; }
        .total {
            font-weight: bold;
            color: #2563eb;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .qr-section {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            border: 2px dashed #ddd;
            border-radius: 10px;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Booking Kolam Renang</h1>
        <p>Sistem Kolam Renang</p>
        <p>Booking ID: #{{ $booking->id }}</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="user-info">
        <h3>Informasi User</h3>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Status Membership:</strong> {{ $user->membership_status_label }}</p>
        <p><strong>Member sejak:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="booking-info">
        <h3>Detail Booking</h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">ID Booking</div>
                <div class="info-value">#{{ $booking->id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Booking</div>
                <div class="info-value">{{ $booking->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Berenang</div>
                <div class="info-value">{{ $booking->tanggal_booking->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Jam Berenang</div>
                <div class="info-value">06:00 - 18:00 (Seharian Penuh)</div>
            </div>
            <div class="info-item">
                <div class="info-label">Nama Pemesan</div>
                <div class="info-value">{{ $booking->nama_pemesan }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">No. Telepon</div>
                <div class="info-value">{{ $booking->nomor_telepon }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Harga Ticket</div>
                <div class="info-value">{{ $booking->jenis_kolam_label }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Jumlah Orang</div>
                <div class="info-value">{{ $booking->jumlah_orang }} orang</div>
            </div>
            <div class="info-item">
                            <div class="info-label">Akses</div>
            <div class="info-value">Seharian Penuh</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tarif Harian</div>
                <div class="info-value">Rp {{ number_format($booking->tarif_harian ?? 50000, 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Status Booking</div>
                <div class="info-value status-{{ $booking->status }}">{{ $booking->status_label }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Status Pembayaran</div>
                <div class="info-value payment-{{ $booking->status_pembayaran }}">{{ $booking->status_pembayaran_label }}</div>
            </div>
        </div>

        <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
            <div style="text-align: center; font-size: 18px; font-weight: bold; color: #2563eb;">
                Total Harga: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
            </div>
        </div>

        @if($booking->catatan)
        <div style="margin-top: 20px;">
            <h4 style="color: #333; margin-bottom: 10px;">Catatan:</h4>
            <div style="padding: 10px; background-color: #f8f9fa; border-radius: 5px; border-left: 4px solid #2563eb;">
                {{ $booking->catatan }}
            </div>
        </div>
        @endif

        @if($booking->catatan_admin)
        <div style="margin-top: 20px;">
            <h4 style="color: #333; margin-bottom: 10px;">Catatan Admin:</h4>
            <div style="padding: 10px; background-color: #fff3cd; border-radius: 5px; border-left: 4px solid #ffc107;">
                {{ $booking->catatan_admin }}
            </div>
        </div>
        @endif
    </div>

    @if($booking->status === 'approved')
    <div class="qr-section">
        <h3 style="margin-bottom: 15px; color: #2563eb;">Tiket Masuk</h3>
        <div class="qr-code">
            <div>
                <div style="font-weight: bold; margin-bottom: 5px;">BOOKING #{{ $booking->id }}</div>
                <div style="font-size: 9px; color: #666;">
                    {{ $booking->tanggal_booking->format('d/m/Y') }}<br>
                    06:00 - 18:00 (Seharian Penuh)<br>
                    {{ $booking->nama_pemesan }}
                </div>
            </div>
        </div>
        <p style="margin-top: 10px; font-size: 10px; color: #666;">
            Tunjukkan tiket ini saat masuk ke kolam renang
        </p>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat otomatis oleh sistem</p>
        <p>© {{ date('Y') }} Sistem Kolam Renang</p>
    </div>
</body>
</html> 