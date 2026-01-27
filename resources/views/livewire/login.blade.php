<div class="min-h-screen flex items-center justify-center px-4
            bg-gradient-to-br from-gray-950 via-gray-900 to-black">

    <div class="max-w-md w-full
                bg-white/5 backdrop-blur-xl
                border border-white/10
                rounded-2xl shadow-2xl p-8">

        <h2 class="text-3xl font-extrabold text-center text-white tracking-wide">
            Login Akun
        </h2>

        <p class="text-center text-sm text-gray-400 mt-1 mb-8">
            Masuk untuk melanjutkan ke showroom eksklusif
        </p>

        @if(session()->has('error'))
            <div class="bg-red-500/10 text-red-400 p-3 mb-4 rounded-lg text-sm border border-red-500/20">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="login" class="space-y-5">

            {{-- EMAIL --}}
            <div>
                <label class="text-sm text-gray-400">Email</label>
                <input
                    type="email"
                    wire:model.defer="email"
                    placeholder="email@example.com"
                    autocomplete="off"
                    class="w-full mt-1 px-4 py-3 rounded-lg
                           bg-black/40 text-gray-100
                           border border-white/10
                           focus:outline-none focus:ring-2 focus:ring-emerald-500/40
                           placeholder-gray-500"
                >
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="text-sm text-gray-400">Password</label>
                <input
                    type="password"
                    wire:model.defer="password"
                    placeholder="••••••••"
                    autocomplete="new-password"
                    class="w-full mt-1 px-4 py-3 rounded-lg
                           bg-black/40 text-gray-100
                           border border-white/10
                           focus:outline-none focus:ring-2 focus:ring-emerald-500/40
                           placeholder-gray-500"
                >
            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="w-full mt-2 py-3 rounded-lg
                       bg-emerald-600 hover:bg-emerald-700
                       text-white font-bold tracking-wide
                       shadow-lg shadow-emerald-900/40
                       transition">
                Masuk Showroom
            </button>

        </form>

        <p class="mt-8 text-center text-sm text-gray-400">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="text-emerald-400 font-semibold hover:text-emerald-300 transition">
                Daftar di sini
            </a>
        </p>

    </div>
</div>
