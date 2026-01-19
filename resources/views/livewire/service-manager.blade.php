<div class="max-w-7xl mx-auto p-6">

    <a href="/" class="text-blue-600 mb-4 inline-block">← Kembali ke Showroom</a>

    <h1 class="text-3xl font-bold text-orange-600 mb-6">Bengkel / Service</h1>

    {{-- FORM MULAI SERVICE --}}
    @if(!$activeService)
        <div class="bg-white p-6 rounded-xl shadow mb-8 grid grid-cols-2 gap-4">
            <input wire:model="customer_name" placeholder="Pemilik" class="border p-2 rounded">
            <input wire:model="car_name" placeholder="Mobil" class="border p-2 rounded">
            <input wire:model="plate_number" placeholder="Plat" class="border p-2 rounded">
            <input type="date" wire:model="service_date" class="border p-2 rounded">

            <button wire:click.prevent="startService" class="col-span-2 bg-orange-600 text-white py-2 rounded">
                Mulai Service
            </button>
        </div>
    @endif

    {{-- SERVICE AKTIF --}}
    @if($activeService)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            {{-- PILIH SERVICE --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold mb-4">Pilih Service</h2>
                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">Service</th>
                            <th class="border p-2">Harga</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($masters as $m)
                            <tr wire:key="master-{{ $m->id }}">
                                <td class="border p-2">{{ $m->name }}</td>
                                <td class="border p-2">Rp {{ number_format($m->price,0,',','.') }}</td>
                                <td class="border p-2 text-center">
                                    <button wire:click.prevent="addItem({{ $m->id }})" class="bg-blue-600 text-white px-3 py-1 rounded">Tambah</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-400 p-4">Service belum tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- NOTA --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold mb-4">Nota Service</h2>
                @forelse($activeService->items as $item)
                    <div wire:key="item-{{ $item->id }}" class="flex justify-between border-b py-1">
                        <span>{{ $item->item_name }}</span>
                        <div>
                            Rp {{ number_format($item->price,0,',','.') }}
                            <button wire:click.prevent="removeItem({{ $item->id }})" class="ml-2 text-red-600">✕</button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400">Belum ada service</p>
                @endforelse

                <p class="mt-4 font-bold">Total: Rp {{ number_format($activeService->total_price,0,',','.') }}</p>

                <button wire:click.prevent="finishService({{ $activeService->id }})" class="mt-4 bg-green-600 text-white px-6 py-2 rounded">
                    Selesaikan
                </button>
            </div>
        </div>
    @endif

    {{-- RIWAYAT SERVICE --}}
    <h2 class="text-xl font-bold mt-10 mb-4">List mobil di service</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($this->historyServices as $s)
            <div wire:key="history-{{ $s->id }}" class="bg-gray-50 p-4 rounded-xl shadow">
                <h3 class="font-bold">{{ $s->car_name }}</h3>
                <p class="text-sm text-gray-500">{{ $s->customer_name }}</p>
                <p class="text-orange-600 font-semibold mt-2">Rp {{ number_format($s->total_price,0,',','.') }}</p>
                <p class="text-xs text-gray-400">Status: {{ ucfirst($s->status) }}</p>
            </div>
        @empty
            <p class="text-gray-400 col-span-3">Belum ada service</p>
        @endforelse
    </div>

</div>
