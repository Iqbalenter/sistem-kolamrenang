<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Booking Kolam - {{ $user->name }}</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
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
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Riwayat Booking Kolam Renang</h1>
        <p>Sistem Kolam Renang</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="user-info">
        <h3>Informasi User</h3>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Status Membership:</strong> {{ $user->membership_status_label }}</p>
        <p><strong>Member sejak:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
    </div>

    @if($bookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Booking</th>
                    <th>Tanggal Booking</th>
                    <th>Jam</th>
                    <th>Pemesan</th>
                    <th>Harga Ticket</th>
                    <th>Jumlah Orang</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>#{{ $booking->id }}</td>
                        <td>{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                        <td>06:00 - 18:00 (Seharian Penuh)</td>
                        <td>{{ $booking->nama_pemesan }}</td>
                        <td>{{ $booking->jenis_kolam_label }}</td>
                        <td>{{ $booking->jumlah_orang }} orang</td>
                        <td class="total">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        <td class="status-{{ $booking->status }}">{{ $booking->status_label }}</td>
                        <td class="payment-{{ $booking->status_pembayaran }}">{{ $booking->status_pembayaran_label }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <p><strong>Total Booking:</strong> {{ $bookings->count() }} booking</p>
            <p><strong>Total Transaksi:</strong> Rp {{ number_format($bookings->sum('total_harga'), 0, ',', '.') }}</p>
        </div>
    @else
        <div class="no-data">
            <p>Belum ada riwayat booking kolam</p>
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat otomatis oleh sistem</p>
        <p>© {{ date('Y') }} Sistem Kolam Renang</p>
    </div>
</body>
</html> 