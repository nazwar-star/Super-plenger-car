<div class="max-w-6xl mx-auto p-6">

    <a href="/" class="text-blue-600 mb-4 inline-block">← Kembali ke Showroom</a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white p-6 rounded-xl shadow">

        {{-- FOTO --}}
        <div class="h-80 bg-gray-200 rounded-lg overflow-hidden">
            @if($car->photo)
                <img src="{{ asset('storage/'.$car->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="h-full flex items-center justify-center text-gray-400">No Image</div>
            @endif

        </div>

        {{-- INFO --}}
        <div>
            <h1 class="text-3xl font-bold">{{ $car->name }}</h1>
            <p class="text-gray-500">{{ $car->brand }} • {{ $car->year }}</p>
            <p class="mt-4 text-xl font-semibold text-blue-600">
                Harga Rental / Hari: Rp {{ number_format($car->rental_price,0,',','.') }}
            </p>
            <p class="mt-2 text-xl font-semibold text-green-700">
                Harga Jual: Rp {{ number_format($car->sale_price,0,',','.') }}
            </p>
            <p class="mt-2 text-gray-700">Stok: <b>{{ $car->stock }}</b></p>

            <span class="inline-block mt-3 px-4 py-1 rounded-full text-sm
                @if($car->status === 'available') bg-green-100 text-green-700
                @elseif($car->status === 'rented') bg-yellow-100 text-yellow-700
                @else bg-red-100 text-red-700
                @endif">
                {{ ucfirst($car->status) }}
            </span>

            {{-- Tombol Beli --}}
            @if(!$rental_selected && $car->status === 'available')
                <button wire:click="selectBuy" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                    Beli Sekarang
                </button>
            @endif

            {{-- Rental --}}
            @if(!$buy_selected)
                <div class="mt-4" @if($rental_selected) style="display:block;" @endif>
                    <h2 class="text-xl font-semibold mb-2">Rental Mobil</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="date" wire:model.live="start_date" class="border rounded p-2">
                        <input type="date" wire:model.live="end_date" class="border rounded p-2">
                    </div>

                    @if($rental_selected)
                        <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                            <p>Lama Sewa: <b>{{ $total_days }} hari</b></p>
                            <p>Total Harga: <b class="text-blue-600">Rp {{ number_format($total_price,0,',','.') }}</b></p>
                            <p>DP ({{ $dp_percent }}%): <b class="text-green-600">Rp {{ number_format($dp_amount,0,',','.') }}</b></p>

                            <h2 class="mt-4 font-semibold">Metode Pembayaran</h2>
                            <div class="flex gap-3 mt-2">
                                <button wire:click="pay('cash')" class="bg-gray-500 text-white px-4 py-2 rounded">Cash</button>
                                <button wire:click="pay('transfer')" class="bg-green-500 text-white px-4 py-2 rounded">Transfer</button>
                                <button wire:click="pay('qris')" class="bg-purple-500 text-white px-4 py-2 rounded">QRIS</button>
                            </div>

                            @if($qris_url)
                                <div class="mt-4">
                                    <img src="{{ $qris_url }}" class="h-48 w-48 object-contain">
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            {{-- Buy --}}
            @if($buy_selected)
                <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold mb-2">Metode Pembayaran</h2>
                    <div class="flex gap-3 mt-2">
                        <button wire:click="pay('cash')" class="bg-gray-500 text-white px-4 py-2 rounded">Cash</button>
                        <button wire:click="pay('transfer')" class="bg-green-500 text-white px-4 py-2 rounded">Transfer</button>
                        <button wire:click="pay('qris')" class="bg-purple-500 text-white px-4 py-2 rounded">QRIS</button>
                    </div>

                    @if($qris_url)
                        <div class="mt-4">
                            <img src="{{ $qris_url }}" class="h-48 w-48 object-contain">
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
