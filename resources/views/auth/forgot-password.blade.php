<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password | Votura</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center relative overflow-hidden px-8 py-8">

  <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-orange-100 p-8 w-full max-w-md relative z-10">

    <div class="flex items-center gap-3 mb-6">
      <img src="{{ asset('images/VotingMU.png') }}" alt="Votura" class="h-9 w-auto">
    </div>

    <h2 class="text-xl font-semibold text-gray-800">Lupa Password</h2>
    <p class="text-sm text-gray-400 mt-1 mb-6">Masukkan email Anda, kami akan kirimkan link reset password.</p>

    @if (session('success'))
      <div class="bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg px-4 py-3 mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->has('email'))
      <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-4">
        {{ $errors->first('email') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-5">
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

      <button type="submit"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2.5 rounded-lg text-sm transition">
        Kirim Link Reset
      </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-5">
      Ingat password? <a href="{{ route('login') }}" class="text-orange-500 font-medium hover:underline">Kembali login</a>
    </p>
  </div>
</body>
</html>