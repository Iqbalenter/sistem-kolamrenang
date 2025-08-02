<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Semua Booking - {{ $user->name }}</title>
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
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #2563eb;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
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
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .summary h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .summary p {
            margin: 5px 0;
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
        <h1>Riwayat Semua Booking</h1>
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

    <!-- Booking Kolam -->
    <div class="section">
        <h2>1. Booking Kolam Renang</h2>
        @if($bookingsKolam->count() > 0)
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
                    @foreach($bookingsKolam as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                            <td>{{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</td>
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
        @else
            <div class="no-data">
                <p>Belum ada riwayat booking kolam</p>
            </div>
        @endif
    </div>

    <!-- Booking Kelas -->
    <div class="section">
        <h2>2. Booking Kelas Renang</h2>
        @if($bookingsKelas->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Booking</th>
                        <th>Tanggal Kelas</th>
                        <th>Jam</th>
                        <th>Peserta</th>
                        <th>Jenis Kelas</th>
                        <th>Instruktur</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingsKelas as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->tanggal_kelas->format('d/m/Y') }}</td>
                            <td>{{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</td>
                            <td>{{ $booking->nama_peserta }}</td>
                            <td>{{ $booking->jenis_kelas_label }}</td>
                            <td>{{ $booking->instruktur }}</td>
                            <td class="total">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            <td class="status-{{ $booking->status }}">{{ $booking->status_label }}</td>
                            <td class="payment-{{ $booking->status_pembayaran }}">{{ $booking->status_pembayaran_label }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>Belum ada riwayat booking kelas</p>
            </div>
        @endif
    </div>

    <!-- Booking Sewa Alat -->
    <div class="section">
        <h2>3. Booking Sewa Alat</h2>
        @if($bookingsSewaAlat->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Booking</th>
                        <th>Tanggal Sewa</th>
                        <th>Jam</th>
                        <th>Penyewa</th>
                        <th>Jenis Alat</th>
                        <th>Jumlah Alat</th>
                        <th>Jenis Jaminan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookingsSewaAlat as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->tanggal_sewa->format('d/m/Y') }}</td>
                            <td>{{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</td>
                            <td>{{ $booking->nama_penyewa }}</td>
                            <td>{{ $booking->jenis_alat_label }}</td>
                            <td>{{ $booking->jumlah_alat }} unit</td>
                            <td>{{ $booking->jenis_jaminan_label }}</td>
                            <td class="total">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            <td class="status-{{ $booking->status }}">{{ $booking->status_label }}</td>
                            <td class="payment-{{ $booking->status_pembayaran }}">{{ $booking->status_pembayaran_label }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>Belum ada riwayat booking sewa alat</p>
            </div>
        @endif
    </div>

    <!-- Summary -->
    <div class="summary">
        <h3>Ringkasan Total</h3>
        <p><strong>Total Booking Kolam:</strong> {{ $bookingsKolam->count() }} booking</p>
        <p><strong>Total Booking Kelas:</strong> {{ $bookingsKelas->count() }} booking</p>
        <p><strong>Total Booking Sewa Alat:</strong> {{ $bookingsSewaAlat->count() }} booking</p>
        <p><strong>Total Semua Booking:</strong> {{ $bookingsKolam->count() + $bookingsKelas->count() + $bookingsSewaAlat->count() }} booking</p>
        <p><strong>Total Transaksi:</strong> Rp {{ number_format($bookingsKolam->sum('total_harga') + $bookingsKelas->sum('total_harga') + $bookingsSewaAlat->sum('total_harga'), 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat otomatis oleh sistem</p>
        <p>© {{ date('Y') }} Sistem Kolam Renang</p>
    </div>
</body>
</html> 