

<x-filament-panels::page>

    <div class="w-full">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Header -->
            <div class="lg:col-span-2">
                <div class="p-6 bg-white rounded-xl shadow flex items-center gap-4">

                    <div class="w-14 h-14 rounded-full bg-primary-500 text-white flex items-center justify-center text-xl font-bold">
                        {{ strtoupper(substr($this->user->name, 0, 1)) }}
                    </div>

                    <div>
                        <h2 class="text-xl font-bold">
                            {{ $this->user->name }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            Akun Pengguna Sistem
                        </p>
                    </div>

                </div>
            </div>

            <!-- Nama -->
            <div class="p-5 bg-white rounded-xl shadow">
                <p class="text-sm text-gray-500 mb-1">
                    Nama Lengkap
                </p>

                <p class="text-lg font-semibold">
                    {{ $this->user->name }}
                </p>
            </div>

            <!-- Email -->
            <div class="p-5 bg-white rounded-xl shadow">
                <p class="text-sm text-gray-500 mb-1">
                    Email
                </p>

                <p class="text-lg font-semibold">
                    {{ $this->user->email }}
                </p>
            </div>

            <!-- Password -->
            <div class="p-5 bg-white rounded-xl shadow">
                <p class="text-sm text-gray-500 mb-1">
                    Password
                </p>

                <div x-data="{ show: false }" class="flex items-center justify-between">
                    <p class="text-lg font-semibold">
                        <span x-show="!show">***************</span>
                    </p>
                </div>
            </div>

            <!-- Status -->
            <div class="p-5 bg-white rounded-xl shadow">
                <p class="text-sm text-gray-500 mb-1">
                    Status
                </p>

                <p class="text-lg font-semibold text-green-600">
                    Aktif
                </p>
            </div>

        </div>

    </div>
    <x-filament-actions::modals />

</x-filament-panels::page>