<div class="flex flex-col max-h-[90vh]">

    {{-- HEADER --}}
    <div class="flex justify-between items-center p-6 border-b border-white/10">
        <h2 class="text-xl font-bold">
            Checkout {{ $car->name }}
        </h2>

        <button
            type="button"
            wire:click="$dispatch('close-checkout')"
            class="text-2xl hover:text-red-500">
            ✕
        </button>
    </div>

    {{-- BODY --}}
    <div class="p-6 space-y-6 overflow-y-auto">

        {{-- INFO MOBIL --}}
        <div class="bg-white/5 p-4 rounded">
            <p class="font-semibold">{{ $car->name }}</p>
            <p class="text-sm text-gray-400">
                {{ $car->brand }} • {{ $car->year }}
            </p>
        </div>

        {{-- TYPE --}}
        <div class="flex gap-3">
            <button
                wire:click="$set('type','rental')"
                class="flex-1 py-2 rounded font-semibold
                {{ $type === 'rental' ? 'bg-emerald-600' : 'bg-gray-700' }}">
                Rental
            </button>

            <button
                wire:click="$set('type','buy')"
                class="flex-1 py-2 rounded font-semibold
                {{ $type === 'buy' ? 'bg-emerald-600' : 'bg-gray-700' }}">
                Beli
            </button>
        </div>

        {{-- KTP & RENTAL --}}
        @if($type === 'rental')
            <div class="space-y-2">
                <p class="text-sm text-gray-400">Upload Foto KTP</p>
                <input type="file" wire:model="ktp_photo">
                @error('ktp_photo')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm text-gray-400">Mulai Rental</label>
                    <input type="date" wire:model="rental_start"
                        class="w-full p-2 rounded bg-gray-800">
                </div>

                <div>
                    <label class="text-sm text-gray-400">Selesai Rental</label>
                    <input type="date" wire:model="rental_end"
                        class="w-full p-2 rounded bg-gray-800">
                </div>
            </div>

            @if($rental_days > 0)
                <p class="text-center text-emerald-400 text-sm">
                    {{ $rental_days }} hari ×
                    Rp {{ number_format($car->rental_price,0,',','.') }}
                </p>
            @endif
        @endif

        {{-- METODE PENGAMBILAN --}}
        <div class="space-y-2">
            <p class="text-sm text-gray-400">Metode Pengambilan</p>
            <div class="flex gap-3">
                <button
                    wire:click="$set('delivery_method','ambil_sendiri')"
                    class="flex-1 py-2 rounded
                    {{ $delivery_method === 'ambil_sendiri' ? 'bg-emerald-600' : 'bg-gray-700' }}">
                    Ambil Sendiri
                </button>

                <button
                    wire:click="$set('delivery_method','diantar')"
                    class="flex-1 py-2 rounded
                    {{ $delivery_method === 'diantar' ? 'bg-emerald-600' : 'bg-gray-700' }}">
                    Diantar
                </button>
            </div>
        </div>

        {{-- LOKASI ANTAR --}}
@if($delivery_method === 'diantar')
    <div class="space-y-3">

        {{-- ALAMAT --}}
        <input type="text"
            wire:model="delivery_address"
            placeholder="Alamat pengantaran"
            class="w-full p-2 rounded bg-gray-800">

        {{-- MAP --}}
        <div wire:ignore class="rounded overflow-hidden border border-white/10">
            <div id="map" class="w-full h-[300px]"></div>
        </div>

        <p class="text-xs text-gray-400 text-center">
            Klik peta atau geser pin untuk menentukan lokasi pengantaran
        </p>

        {{-- JARAK --}}
        <input type="number"
            wire:model="distance_km"
            placeholder="Jarak (KM)"
            class="w-full p-2 rounded bg-gray-800">

        <p class="text-sm text-emerald-400">
            Biaya antar: Rp {{ number_format($delivery_fee,0,',','.') }}
        </p>

    </div>
@endif


        {{-- PAYMENT --}}
        <div class="space-y-2">
            <p class="text-sm text-gray-400">Metode Pembayaran</p>

            <div class="flex gap-3">
                <button
                    wire:click="$set('payment_method','transfer')"
                    class="flex-1 py-2 rounded
                    {{ $payment_method === 'transfer' ? 'bg-emerald-600' : 'bg-gray-700' }}">
                    Transfer
                </button>

                <button
                    wire:click="$set('payment_method','cash')"
                    class="flex-1 py-2 rounded
                    {{ $payment_method === 'cash' ? 'bg-emerald-600' : 'bg-gray-700' }}">
                    Cash
                </button>
            </div>
        </div>

        {{-- TRANSFER INFO --}}
        @if($payment_method === 'transfer')
            <div class="bg-white/5 p-4 rounded space-y-3 text-sm">
                <div class="flex justify-between">
                    <span>Bank</span><span>BRI</span>
                </div>
                <div class="flex justify-between">
                    <span>No Rekening</span>
                    <span class="font-bold">1234 5678 9012</span>
                </div>
                <div class="flex justify-between">
                    <span>Atas Nama</span><span>PT RENTAL MOBIL</span>
                </div>

                <div>
                    <p class="text-gray-400 mb-1">Upload Bukti Transfer</p>
                    <input type="file" wire:model="payment_proof">
                </div>
            </div>
        @endif

        {{-- ESTIMASI HARGA --}}
        <div class="text-center font-bold text-emerald-400">
            Total Estimasi:
            Rp {{ number_format($total_price,0,',','.') }}
        </div>

        {{-- SYARAT --}}
        <div class="bg-white/5 p-4 rounded text-sm">
            <ul class="list-disc ml-5 space-y-1 text-gray-300">
                <li>Menunggu persetujuan admin</li>
                <li>Stok diproses setelah approve</li>
            </ul>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" wire:model="agree" class="accent-emerald-600">
            Saya setuju dengan syarat & ketentuan
        </label>
    </div>

    {{-- FOOTER --}}
    <div class="p-6 border-t border-white/10">
        <button
            wire:click="submit"
            wire:loading.attr="disabled"
            class="w-full py-3 rounded font-semibold bg-emerald-600 hover:bg-emerald-700">
            Lanjutkan
        </button>
    </div>

</div>
