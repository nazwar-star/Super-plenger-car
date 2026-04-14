<div class="min-h-screen bg-gradient-to-br from-[#050b17] via-[#0b1220] to-[#020617] text-slate-100 p-8">

    <div class="max-w-3xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold tracking-wide">
                ⭐ Masukan & Rating
            </h1>
            <p class="text-slate-400 text-sm mt-2">
                Berikan pengalaman Anda terhadap layanan showroom kami
            </p>
        </div>

        {{-- CARD FORM --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 shadow-xl">

            {{-- NOTIF --}}
            @if (session()->has('message'))
                <div class="mb-4 p-3 bg-green-500/20 text-green-300 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-5">

                {{-- INPUT --}}
                <input type="text" wire:model="nama" placeholder="Nama"
                    class="w-full bg-white/5 border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">

                @error('nama') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror

                <input type="email"
    value="{{ auth()->user()->email }}"
    disabled
    class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-slate-400">

                @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror

                <textarea wire:model="pesan" placeholder="Tulis masukan..."
                    class="w-full bg-white/5 border border-white/10 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-emerald-400"></textarea>

                @error('pesan') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror

                {{-- ⭐ RATING --}}
                <div>
                    <p class="mb-2 text-sm text-slate-400">Rating Anda</p>

                    <div class="flex gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button"
                                wire:click="$set('rating', {{ $i }})"
                                class="text-4xl transition transform hover:scale-125">

                                <span class="{{ $rating >= $i ? 'text-emerald-400 drop-shadow-lg' : 'text-slate-500' }}">
                                    ★
                                </span>

                            </button>
                        @endfor
                    </div>

                    @error('rating') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-600 text-black font-bold py-3 rounded-xl transition shadow-lg">
                    Kirim Masukan
                </button>

            </form>
        </div>

        {{-- LIST MASUKAN --}}
        <div class="mt-10 space-y-4">

            <h2 class="text-xl font-bold mb-4">💬 Review Pengguna</h2>

            @forelse ($masukans as $m)
                <div class="bg-white/5 border border-white/10 rounded-xl p-5 backdrop-blur-md shadow">

                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="font-semibold">{{ $m->nama }}</p>
                            <p class="text-xs text-slate-400">{{ $m->email }}</p>
                        </div>

                        {{-- ⭐ RATING --}}
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $m->rating >= $i ? 'text-emerald-400' : 'text-slate-600' }}">
                                    ★
                                </span>
                            @endfor
                        </div>
                    </div>

                    <p class="text-slate-300 text-sm">{{ $m->pesan }}</p>

                </div>
            @empty
                <p class="text-slate-500">Belum ada masukan.</p>
            @endforelse

        </div>

    </div>

</div>