<div class="min-h-screen flex items-center justify-center px-4
            bg-gradient-to-br from-gray-950 via-gray-900 to-black">

    <div class="max-w-md w-full
                bg-white/5 backdrop-blur-xl
                border border-white/10
                rounded-2xl shadow-2xl p-8">

        {{-- TITLE --}}
        <h2 class="text-2xl font-bold text-center text-white mb-1">
            Daftar Akun Baru
        </h2>
        <p class="text-center text-sm text-gray-400 mb-6">
            Bergabung dan temukan mobil impian Anda
        </p>

        {{-- ERROR --}}
        @if(session()->has('error'))
            <div class="bg-red-500/10 text-red-400 p-3 mb-4 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- FORM --}}
        <form wire:submit.prevent="register" class="space-y-4">

            <div>
                <label class="text-sm text-gray-400">Nama Lengkap</label>
                <input
                    type="text"
                    wire:model.defer="name"
                    placeholder="Nama Lengkap"
                    autocomplete="off"
                    class="w-full mt-1 px-4 py-3 rounded-lg
                           bg-black/40 border border-white/10
                           text-white placeholder-gray-500
                           focus:outline-none focus:ring-2 focus:ring-gray-600"
                >
            </div>

            <div>
                <label class="text-sm text-gray-400">Email</label>
                <input
                    type="email"
                    wire:model.defer="email"
                    placeholder="email@gmail.com"
                    autocomplete="off"
                    class="w-full mt-1 px-4 py-3 rounded-lg
                           bg-black/40 border border-white/10
                           text-white placeholder-gray-500
                           focus:outline-none focus:ring-2 focus:ring-gray-600"
                >
            </div>

            <div>
                <label class="text-sm text-gray-400">Password</label>
                <input
                    type="password"
                    wire:model.defer="password"
                    placeholder="••••••••"
                    autocomplete="new-password"
                    class="w-full mt-1 px-4 py-3 rounded-lg
                           bg-black/40 border border-white/10
                           text-white placeholder-gray-500
                           focus:outline-none focus:ring-2 focus:ring-gray-600"
                >
            </div>

            <div>
                <label class="text-sm text-gray-400">Konfirmasi Password</label>
                <input
                    type="password"
                    wire:model.defer="password_confirmation"
                    placeholder="••••••••"
                    autocomplete="new-password"
                    class="w-full mt-1 px-4 py-3 rounded-lg
                           bg-black/40 border border-white/10
                           text-white placeholder-gray-500
                           focus:outline-none focus:ring-2 focus:ring-gray-600"
                >
            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="w-full mt-4 py-3 rounded-lg
                       bg-gradient-to-r from-gray-200 to-gray-400
                       text-black font-semibold
                       hover:from-gray-300 hover:to-gray-500
                       transition shadow-lg"
            >
                Daftar Sekarang
            </button>
        </form>

        {{-- FOOTER --}}
        <p class="mt-6 text-center text-sm text-gray-400">
            Sudah punya akun?
            <a href="{{ route('login') }}"
               class="text-gray-200 font-semibold hover:underline">
                Login di sini
            </a>
        </p>
    </div>
</div>
