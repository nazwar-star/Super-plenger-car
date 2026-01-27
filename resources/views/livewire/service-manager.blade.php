<div class="min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-black text-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-10 space-y-10">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold tracking-wide text-orange-400">
                    Bengkel & Service
                </h1>
                <p class="text-gray-400 text-sm">
                    Manajemen service kendaraan
                </p>
            </div>

            <a href="{{ route('showroom') }}"
               class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg text-sm font-semibold transition">
                ← Kembali ke Showroom
            </a>
        </div>

        {{-- FORM MULAI SERVICE --}}
        @if(!$activeService)
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-xl p-6">
                <h2 class="font-semibold mb-4 text-orange-300">Mulai Service Baru</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input wire:model.defer="customer_name"
                           placeholder="Nama Pemilik"
                           class="bg-black/40 border border-white/10 rounded-lg px-4 py-3">

                    <input wire:model.defer="car_name"
                           placeholder="Nama Mobil"
                           class="bg-black/40 border border-white/10 rounded-lg px-4 py-3">

                    <input wire:model.defer="plate_number"
                           placeholder="Plat Nomor"
                           class="bg-black/40 border border-white/10 rounded-lg px-4 py-3">

                    <input type="date" wire:model.defer="service_date"
                           class="bg-black/40 border border-white/10 rounded-lg px-4 py-3">

                    <button wire:click.prevent="startService"
                            class="col-span-full mt-2
                                   bg-gradient-to-r from-orange-500 to-amber-500
                                   hover:from-orange-600 hover:to-amber-600
                                   text-black font-semibold py-3 rounded-lg transition">
                        Mulai Service
                    </button>
                </div>
            </div>
        @endif

        {{-- SERVICE AKTIF --}}
        @if($activeService)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- DAFTAR SERVICE --}}
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-xl p-6">
                    <h2 class="font-semibold mb-4 text-orange-300">Pilih Jenis Service</h2>

                    <table class="w-full text-sm">
                        <thead class="text-gray-400 border-b border-white/10">
                            <tr>
                                <th class="py-2 text-left">Service</th>
                                <th class="py-2">Harga</th>
                                <th class="py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($masters as $m)
                                <tr wire:key="master-{{ $m->id }}" class="border-b border-white/5">
                                    <td class="py-2">{{ $m->name }}</td>
                                    <td class="py-2 text-center">
                                        Rp {{ number_format($m->price,0,',','.') }}
                                    </td>
                                    <td class="py-2 text-right">
                                        <button wire:click.prevent="addItem({{ $m->id }})"
                                                class="bg-sky-600 hover:bg-sky-700 px-3 py-1 rounded text-xs">
                                            Tambah
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-6">
                                        Service belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- NOTA --}}
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-xl p-6">
                    <h2 class="font-semibold mb-4 text-orange-300">Nota Service</h2>

                    @forelse($activeService->items as $item)
                        <div wire:key="item-{{ $item->id }}"
                             class="flex justify-between items-center border-b border-white/10 py-2 text-sm">
                            <span>{{ $item->item_name }}</span>
                            <div class="flex items-center gap-2">
                                <span>Rp {{ number_format($item->price,0,',','.') }}</span>
                                <button wire:click.prevent="removeItem({{ $item->id }})"
                                        class="text-red-400 hover:text-red-500">
                                    ✕
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada service dipilih</p>
                    @endforelse

                    <div class="mt-4 flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-orange-400">
                            Rp {{ number_format($activeService->total_price,0,',','.') }}
                        </span>
                    </div>

                    <button wire:click.prevent="finishService({{ $activeService->id }})"
                            class="w-full mt-6
                                   bg-emerald-600 hover:bg-emerald-700
                                   py-3 rounded-lg font-semibold transition">
                        Selesaikan Service
                    </button>
                </div>
            </div>
        @endif

        {{-- RIWAYAT --}}
        <div>
            <h2 class="text-xl font-bold mb-4">Riwayat Service</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($this->historyServices as $s)
                    <div wire:key="history-{{ $s->id }}"
                         class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4 shadow">
                        <h3 class="font-semibold">{{ $s->car_name }}</h3>
                        <p class="text-sm text-gray-400">{{ $s->customer_name }}</p>
                        <p class="mt-2 font-bold text-orange-400">
                            Rp {{ number_format($s->total_price,0,',','.') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Status: {{ ucfirst($s->status) }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full">Belum ada riwayat service</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
