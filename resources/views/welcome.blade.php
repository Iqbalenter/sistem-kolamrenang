<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua Paradise - Sistem Booking Kolam Renang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0084ff',
                        secondary: '#00a8ff',
                        accent: '#26c6da',
                        dark: '#1565c0',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'bounce-slow': 'bounce 2s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-lg transition-all duration-300">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center">
                        <i class="fas fa-swimming-pool text-white text-lg lg:text-xl"></i>
                    </div>
                    <span class="ml-3 text-xl lg:text-2xl font-bold text-gray-900">Kuala Mega</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#home" class="nav-link text-gray-700 hover:text-primary transition-colors duration-300 relative group">
                        <span>Beranda</span>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></div>
                    </a>
                    <a href="#pools" class="nav-link text-gray-700 hover:text-primary transition-colors duration-300 relative group">
                        <span>Jenis Kolam</span>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></div>
                    </a>
                    <a href="#fasilitas" class="nav-link text-gray-700 hover:text-primary transition-colors duration-300 relative group">
                        <span>Fasilitas</span>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></div>
                    </a>
                    <a href="#tentang" class="nav-link text-gray-700 hover:text-primary transition-colors duration-300 relative group">
                        <span>Tentang</span>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></div>
                    </a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-primary hover:bg-primary hover:text-white transition-all duration-300 rounded-lg border border-primary">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                            Daftar
                        </a>
                    @else
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                Dashboard User
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-primary hover:bg-primary hover:text-white transition-all duration-300 rounded-lg border border-primary">
                                Logout
                            </button>
                        </form>
                    @endguest
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors" id="mobile-menu-button">
                    <i class="fas fa-bars text-gray-700"></i>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="lg:hidden hidden" id="mobile-menu">
                <div class="py-4 space-y-2">
                    <a href="#home" class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors">Beranda</a>
                    <a href="#pools" class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors">Jenis Kolam</a>
                    <a href="#fasilitas" class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors">Fasilitas</a>
                    <a href="#tentang" class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors">Tentang</a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-primary hover:bg-primary hover:text-white rounded-lg transition-colors border border-primary">Masuk</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg transition-all">Daftar</a>
                    @else
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg transition-all">Dashboard Admin</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg transition-all">Dashboard User</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-primary hover:bg-primary hover:text-white rounded-lg transition-colors border border-primary">
                                Logout
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-secondary/80 to-accent/90"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1657673461323-206b06c9d386?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-black/20"></div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-accent/20 rounded-full animate-bounce-slow"></div>
        <div class="absolute top-1/3 right-1/4 w-16 h-16 bg-primary/30 rounded-full animate-pulse-slow"></div>
        
        <!-- Content -->
        <div class="relative z-10 text-center text-white px-4 max-w-4xl" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                NIKMATI PENGALAMAN<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-white">BERENANG TERBAIK</span>
            </h1>
            <p class="text-lg md:text-xl lg:text-2xl mb-8 opacity-90 max-w-2xl mx-auto">
                Booking kolam renang premium dengan fasilitas lengkap dan air jernih. Ciptakan momen menyenangkan bersama keluarga!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-accent to-primary text-white font-semibold rounded-full hover:shadow-2xl hover:scale-105 transition-all duration-300 text-lg">
                        <i class="fas fa-swimming-pool mr-3"></i>
                        PESAN SEKARANG!
                    </a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-accent to-primary text-white font-semibold rounded-full hover:shadow-2xl hover:scale-105 transition-all duration-300 text-lg">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            DASHBOARD ADMIN
                        </a>
                    @else
                        <a href="{{ route('user.booking.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-accent to-primary text-white font-semibold rounded-full hover:shadow-2xl hover:scale-105 transition-all duration-300 text-lg">
                            <i class="fas fa-swimming-pool mr-3"></i>
                            PESAN SEKARANG!
                        </a>
                    @endif
                @endguest
                <a href="#pools" class="inline-flex items-center px-8 py-4 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-full hover:bg-white/30 transition-all duration-300 text-lg">
                    <i class="fas fa-info-circle mr-3"></i>
                    PELAJARI LEBIH LANJUT
                </a>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-white text-2xl"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fasilitas" class="py-16 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Mengapa Pilih Kami?
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Fasilitas premium dengan pelayanan terbaik untuk pengalaman berenang yang tak terlupakan
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="group bg-white p-6 lg:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4 text-center">Booking Online</h4>
                    <p class="text-gray-600 text-center">Pesan kolam renang kapan saja, dimana saja dengan mudah melalui platform online kami</p>
                </div>
                
                <div class="group bg-white p-6 lg:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4 text-center">Pembayaran Aman</h4>
                    <p class="text-gray-600 text-center">Berbagai metode pembayaran digital yang aman dan terpercaya untuk kemudahan transaksi</p>
                </div>
                
                <div class="group bg-white p-6 lg:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-water text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4 text-center">Air Bersih</h4>
                    <p class="text-gray-600 text-center">Kualitas air yang selalu terjaga dengan sistem filtrasi modern dan perawatan rutin</p>
                </div>
                
                <div class="group bg-white p-6 lg:p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4 text-center">Staff Profesional</h4>
                    <p class="text-gray-600 text-center">Tim profesional yang siap membantu dan menjaga keamanan selama Anda berenang</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pool Types Section -->
    <section id="pools" class="py-16 lg:py-24 bg-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Pilihan Kolam Renang
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Berbagai jenis kolam renang sesuai dengan kebutuhan dan preferensi Anda
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 lg:gap-8">
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1558617320-e695f0d420de?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Kolam Dewasa" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="bg-primary px-3 py-1 rounded-full text-sm font-semibold">Utama</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-2xl font-bold text-gray-900 mb-2">Kolam Utama</h4>
                        <p class="text-gray-600 mb-4">Kolam renang standar untuk orang dewasa dengan kedalaman 1.5-2m. Ideal untuk berenang lap dan olahraga air.</p>
                        <div class="flex items-center justify-between">
                                                            <span class="text-3xl font-bold text-primary">Rp 50.000<span class="text-sm text-gray-500">/hari</span></span>
                            @guest
                                <a href="{{ route('login') }}" class="px-6 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                    Pesan
                                </a>
                            @else
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('user.booking.create') }}" class="px-6 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                        Pesan
                                    </a>
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>
                
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('kolam.png') }}" alt="Kolam Anak" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="bg-accent px-3 py-1 rounded-full text-sm font-semibold">Family</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-2xl font-bold text-gray-900 mb-2">Kolam Anak-anak</h4>
                        <p class="text-gray-600 mb-4">Kolam khusus anak-anak dengan kedalaman 0.5-1m. Dilengkapi dengan permainan air yang menyenangkan.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-primary">Rp 35.000<span class="text-sm text-gray-500">/hari</span></span>
                            @guest
                                <a href="{{ route('login') }}" class="px-6 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                    Pesan
                                </a>
                            @else
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('user.booking.create') }}" class="px-6 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                                        Pesan
                                    </a>
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 lg:py-24 bg-gradient-to-br from-primary to-accent text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-20 h-20 bg-white rounded-full"></div>
            <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white rounded-full"></div>
        </div>
        
        <div class="container mx-auto px-4 lg:px-8 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                    Keunggulan Fasilitas Kami
                </h2>
                <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                    Memberikan pelayanan terbaik dengan standar kualitas tinggi
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="text-center group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-map-marker-alt text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Lokasi Strategis</h4>
                    <p class="opacity-90">Terletak di pusat kota dengan akses mudah dan area parkir luas</p>
                </div>
                
                <div class="text-center group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-dollar-sign text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Harga Terjangkau</h4>
                    <p class="opacity-90">Tarif kompetitif dengan kualitas fasilitas premium</p>
                </div>
                
                <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-shield-alt text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Keamanan Terjamin</h4>
                    <p class="opacity-90">Sistem keamanan 24/7 dan penjaga kolam berpengalaman</p>
                </div>
                
                <div class="text-center group" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-star text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Fasilitas Lengkap</h4>
                    <p class="opacity-90">Ruang ganti, kamar mandi, cafe, dan area istirahat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Kata Mereka
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Testimoni dari pelanggan yang puas dengan layanan kami
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 relative" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute -top-4 -left-4 w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-white text-sm"></i>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-600 italic">
                            "Pelayanan yang sangat memuaskan! Kolam bersih, air jernih, dan staff sangat ramah. Anak-anak saya selalu senang bermain di sini."
                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white font-bold">
                            SM
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Sari Mulyani</div>
                            <div class="text-sm text-gray-600">Ibu Rumah Tangga</div>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute -top-4 -left-4 w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-white text-sm"></i>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-600 italic">
                            "Sistem booking online sangat memudahkan. Tidak perlu antri dan bisa pilih waktu sesuai keinginan. Recommended banget!"
                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white font-bold">
                            RD
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Rudi Dermawan</div>
                            <div class="text-sm text-gray-600">Pegawai Swasta</div>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 relative" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute -top-4 -left-4 w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-white text-sm"></i>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-600 italic">
                            "Fasilitas lengkap dengan harga yang sangat reasonable. Cocok untuk latihan renang rutin dan rekreasi keluarga."
                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white font-bold">
                            LK
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Lisa Kurniawan</div>
                            <div class="text-sm text-gray-600">Mahasiswa</div>
                            <div class="flex text-yellow-400 mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="tentang" class="py-16 lg:py-24 bg-dark text-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center max-w-4xl mx-auto" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                    Siap Untuk Berenang?
                </h2>
                <p class="text-lg md:text-xl mb-8 opacity-90">
                    Bergabunglah dengan ribuan pelanggan yang telah merasakan pengalaman berenang terbaik bersama kami
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-dark font-semibold rounded-lg hover:bg-gray-100 hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-user-plus mr-3"></i>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-dark transition-all duration-300">
                            <i class="fas fa-swimming-pool mr-3"></i>
                            Mulai Booking
                        </a>
                    @else
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-8 py-4 bg-white text-dark font-semibold rounded-lg hover:bg-gray-100 hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('user.booking.create') }}" class="inline-flex items-center px-8 py-4 bg-white text-dark font-semibold rounded-lg hover:bg-gray-100 hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-swimming-pool mr-3"></i>
                                Mulai Booking
                            </a>
                        @endif
                        <a href="{{ route('logout') }}" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-dark transition-all duration-300" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white text-gray-700">
        <div class="container mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-1">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center">
                            <i class="fas fa-swimming-pool text-white"></i>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-900">Kuala Mega</span>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Sistem booking kolam renang terpercaya dengan fasilitas premium dan pelayanan terbaik untuk pengalaman berenang yang tak terlupakan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h6 class="font-bold text-gray-900 mb-4">Menu</h6>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-600 hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="#pools" class="text-gray-600 hover:text-primary transition-colors">Jenis Kolam</a></li>
                        <li><a href="#fasilitas" class="text-gray-600 hover:text-primary transition-colors">Fasilitas</a></li>
                        <li><a href="#tentang" class="text-gray-600 hover:text-primary transition-colors">Tentang</a></li>
                    </ul>
                </div>
                
                <div>
                    <h6 class="font-bold text-gray-900 mb-4">Layanan</h6>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Booking Online</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Private Pool</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Swimming Lesson</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Event & Party</a></li>
                    </ul>
                </div>
                
                <div>
                    <h6 class="font-bold text-gray-900 mb-4">Kontak</h6>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                            <span class="text-gray-600">FQX7+WFV, Jl. Limau Manis 20362 Tg Morawa A Sumatera Utara</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-primary mr-3"></i>
                            <span class="text-gray-600">+62 813-7676-7690</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-primary mr-3"></i>
                            <span class="text-gray-600">Buka: 06:30 - 18:30 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-8 text-center">
                <p class="text-gray-600">&copy; 2025 Kuala Mega. All rights reserved. Made for swimmers.</p>
            </div>
        </div>
    </footer>

    <!-- Floating Action Button -->
    @guest
        <a href="{{ route('login') }}" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300" title="Login Sekarang">
            <i class="fas fa-sign-in-alt text-xl"></i>
        </a>
    @else
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300" title="Dashboard Admin">
                <i class="fas fa-tachometer-alt text-xl"></i>
            </a>
        @else
            <a href="{{ route('user.booking.create') }}" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300" title="Booking Sekarang">
                <i class="fas fa-swimming-pool text-xl"></i>
            </a>
        @endif
    @endguest

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white/98', 'shadow-xl');
                navbar.classList.remove('bg-white/95', 'shadow-lg');
            } else {
                navbar.classList.add('bg-white/95', 'shadow-lg');
                navbar.classList.remove('bg-white/98', 'shadow-xl');
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobile-menu');
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html> 