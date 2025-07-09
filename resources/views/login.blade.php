<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        .pool-background {
            background-image: url('{{ asset('kolam1.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        
        .glass-form {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
    </style>
</head>
<body class="pool-background">
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm glass-form rounded-lg p-6">
  <h2 class="text-center text-2xl/9 font-bold tracking-tight text-white">Masuk Ke Akun Anda</h2>
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-500 bg-opacity-30 border border-green-400 text-white rounded">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-500 bg-opacity-30 border border-red-400 text-white rounded">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-500 bg-opacity-30 border border-red-400 text-white rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
        @csrf
      <div>
        <label for="email" class="block text-sm/6 font-medium text-white">Email</label>
        <div class="mt-2">
          <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" required class="block w-full rounded-md bg-white bg-opacity-20 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-400 sm:text-sm/6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
        </div>
        <div class="mt-2">
          <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white bg-opacity-20 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-400 sm:text-sm/6">
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Masuk</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-white">
      Belum Memiliki Akun?
      <a href="{{ route('register') }}" class="font-semibold text-blue-300 hover:text-blue-200">Daftar</a>
    </p>
  </div>
</div>
</body>
</html>