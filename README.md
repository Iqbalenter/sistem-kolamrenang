<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🏊‍♀️ Sistem Kolam Renang

Sistem manajemen kolam renang yang dibangun menggunakan Laravel 12 dengan interface admin yang modern dan user-friendly.

## 🚀 Features

### ✨ Admin Panel
- **Dashboard Modern** - Overview lengkap dengan statistik dan chart
- **Sidebar Navigation** - Navigasi yang responsif dan intuitif
- **Tabel Pemesanan Terbaru** - Monitoring booking terbaru secara real-time
- **Booking Mendatang** - Daftar booking yang telah dikonfirmasi
- **Manajemen User** - Kelola semua user yang terdaftar
- **Kelola Booking** - Approve/reject booking dengan mudah
- **Konfirmasi Pembayaran** - Verifikasi bukti pembayaran

### 👥 User Panel
- **Sistem Autentikasi** - Login/Register yang aman
- **Booking Kolam** - Pemesanan kolam dengan validasi
- **Riwayat Booking** - History semua pemesanan
- **Upload Bukti Pembayaran** - Upload dan tracking pembayaran
- **Pilihan Metode Pembayaran** - Multiple payment gateway

## 📋 Requirements

- PHP >= 8.2
- Laravel 12
- MySQL/PostgreSQL
- Node.js & NPM
- Composer

## 🛠️ Installation

1. Clone repository
```bash
git clone <repository-url>
cd sistem-kolamrenang
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kolam_renang
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migration & seeder
```bash
php artisan migrate
php artisan db:seed
```

6. Create symbolic link untuk storage
```bash
php artisan storage:link
```

7. Build assets
```bash
npm run dev
# atau untuk production
npm run build
```

8. Start development server
```bash
php artisan serve
```

## 👤 Default Users

### Admin
- **Email:** admin@admin.com
- **Password:** admin123

### User
- **Email:** user@user.com  
- **Password:** user123

## 🏗️ Project Structure

### Controllers
- `AuthController` - Menangani autentikasi
- `AdminController` - Dashboard dan fitur admin
- `UserController` - Dashboard dan fitur user
- `BookingController` - Manajemen booking dan pembayaran

### Models
- `User` - Model pengguna dengan role-based access
- `Booking` - Model booking dengan relationship dan accessor

### Views
- `admin/` - Semua view untuk admin panel
  - `layouts/app.blade.php` - Layout utama dengan sidebar
  - `dashboard.blade.php` - Dashboard dengan tabel dan statistik
  - `users.blade.php` - Manajemen user
  - `bookings/` - Manajemen booking
- `user/` - Semua view untuk user panel
- `auth/` - Login dan register forms

## 🎨 Design Features

### Admin Dashboard
- **Modern Sidebar Navigation** dengan active state
- **Statistics Cards** dengan gradient dan icons
- **Data Tables** dengan hover effects
- **Filter Tabs** untuk booking management
- **Responsive Design** untuk semua device

### UI Components
- **Tailwind CSS** untuk styling modern
- **Font Awesome Icons** untuk visual consistency
- **Gradient Backgrounds** untuk elemen interaktif
- **Hover Animations** untuk better UX

## 📊 Database Schema

### Users Table
- id, name, email, password, role, timestamps

### Bookings Table  
- id, user_id, nama_pemesan, nomor_telepon
- tanggal_booking, jam_mulai, jam_selesai
- jumlah_orang, jenis_kolam, tarif_per_jam, total_harga
- status, status_pembayaran, bukti_pembayaran
- metode_pembayaran, provider_pembayaran, nomor_tujuan
- catatan, catatan_admin, approved_at, rejected_at
- timestamps

## 🔒 Security Features

- **Role-based Access Control** (Admin/User)
- **Middleware Protection** untuk route security
- **CSRF Protection** untuk form submissions
- **File Upload Validation** untuk bukti pembayaran
- **Input Sanitization** untuk prevent XSS

## 🚀 Advanced Features

### Real-time Updates
- AJAX-based booking approval/rejection
- Instant payment confirmation
- Dynamic table updates

### Payment System
- Multiple payment methods (Bank Transfer, E-Wallet)
- Payment proof upload system
- Payment status tracking

### Booking System
- Date/time validation
- Pool availability checking
- Automatic price calculation
- Booking status workflow

## 📱 Mobile Responsive

Semua halaman telah dioptimasi untuk:
- Mobile phones (320px+)
- Tablets (768px+)  
- Desktops (1024px+)

## 🔧 Development Commands

```bash
# Start development server
php artisan serve

# Watch file changes
npm run dev

# Run tests
php artisan test

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate new migration
php artisan make:migration create_table_name

# Generate new controller
php artisan make:controller ControllerName
```

## 📈 Performance Optimization

- **Eager Loading** untuk relationship queries
- **Pagination** untuk large datasets
- **Image Optimization** untuk upload files
- **Asset Minification** untuk production

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

Project ini menggunakan [MIT License](https://opensource.org/licenses/MIT).

## 📞 Support

Jika ada pertanyaan atau butuh bantuan, silakan buat issue di repository ini.

---

**Dibuat dengan ❤️ menggunakan Laravel 12**
