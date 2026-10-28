@vite(['resources/css/app.css'])

<x-filament-panels::page>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- Jumlah Kandidat -->
        <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

            </div>
        </div>

        <!-- Jumlah Pemilih -->
        <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Jumlah Pemilih
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $jumlahPemilih }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-green-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

            </div>
        </div>

        <!-- Sudah Voting -->
        <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Sudah Voting
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $sudahVoting }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-purple-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>

            </div>
        </div>

        <!-- Belum Voting -->
        <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Belum Voting
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $belumVoting }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-xl bg-red-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-red-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

            </div>
        </div>

    </div>

</x-filament-panels::page>