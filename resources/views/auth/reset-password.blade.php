<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | Votura</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center relative overflow-hidden px-8 py-8">

  <<div class="bg-white rounded-2xl shadow-2xl ring-1 ring-orange-100 p-8 w-full max-w-md relative z-10">

    <div class="flex items-center gap-3 mb-6">
      <img src="{{ asset('images/VotingMU.png') }}" alt="Votura" class="h-9 w-auto">
    </div>

    <h2 class="text-xl font-semibold text-gray-800">Reset Password</h2>
    <p class="text-sm text-gray-400 mt-1 mb-6">Masukkan password baru Anda.</p>

    @if ($errors->any())
      <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-4">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600 mb-1" for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="nama@email.com"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
        />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600 mb-1" for="password">Password Baru</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Minimal 8 karakter"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
        />
      </div>

      <div class="mb-5">
        <label class="block text-sm font-medium text-gray-600 mb-1" for="password_confirmation">Konfirmasi Password</label>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          placeholder="Ulangi password baru"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
        />
      </div>

      <button type="submit"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2.5 rounded-lg text-sm transition">
        Reset Password
      </button>
    </form>
  </div>
</body>
</html>