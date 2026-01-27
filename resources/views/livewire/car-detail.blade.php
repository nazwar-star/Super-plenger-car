<div class="min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-black text-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-extrabold tracking-wide">{{ $car->name }}</h1>
                <p class="text-gray-400 mt-1">{{ $car->brand }} • Tahun {{ $car->year }}</p>
            </div>
            <a href="{{ route('showroom') }}" class="bg-gray-800 hover:bg-gray-700 px-5 py-2 rounded-lg shadow font-semibold transition">
                ← Kembali ke Showroom
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- LEFT : IMAGE --}}
            <div class="space-y-4">
                <div class="relative rounded-xl overflow-hidden shadow-2xl border border-white/10 bg-black">
                    <img src="{{ asset('storage/'.$car->photo) }}" class="w-full h-[420px] object-cover hover:scale-105 transition duration-700">
                </div>
            </div>

            {{-- RIGHT : INFO --}}
            <div class="space-y-6">

                {{-- PRICE --}}
                <div class="bg-white/5 backdrop-blur rounded-xl p-5 shadow-lg border border-white/10">
                    <p class="text-2xl font-bold text-green-700">
                        Harga Beli : <span class="text-green-800"> Rp {{ number_format($car->sale_price, 0, ',', '.') }} </span>
                    </p>
                    <p class="text-2xl font-bold text-blue-600">
                        Harga Rental : <span class="text-blue-700"> Rp {{ number_format($car->rental_price, 0, ',', '.') }}/hari </span>
                    </p>
                    <p class="text-gray-400 mt-2"> Stok tersedia: <span class="font-bold">{{ $car->stock }}</span> </p>
                </div>

                {{-- SPEC --}}
                @if($car->mileage || $car->exterior_color)
                    <div class="bg-white/5 backdrop-blur rounded-xl p-5 border border-white/10">
                        <h2 class="text-lg font-semibold mb-3 border-b border-white/10 pb-2">Spesifikasi</h2>
                        <table class="w-full text-gray-300">
                            @if($car->mileage)<tr><td>Mileage</td><td>{{ $car->mileage }}</td></tr>@endif
                            @if($car->exterior_color)<tr><td>Exterior</td><td>{{ $car->exterior_color }}</td></tr>@endif
                            @if($car->interior_color)<tr><td>Interior</td><td>{{ $car->interior_color }}</td></tr>@endif
                            @if($car->trim)<tr><td>Trim</td><td>{{ $car->trim }}</td></tr>@endif
                            @if($car->driver_position)<tr><td>Driver</td><td>{{ $car->driver_position }}</td></tr>@endif
                        </table>
                    </div>
                @endif

                {{-- BUY / RENT --}}
                <div class="bg-white/5 backdrop-blur rounded-xl p-5 border border-white/10 space-y-4">
                    
                    {{-- RENT DATE --}}
                    @if(!$buy_selected)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <input type="date" wire:model.lazy="start_date" class="bg-black/40 border border-white/10 rounded px-3 py-2">
                            <input type="date" wire:model.lazy="end_date" class="bg-black/40 border border-white/10 rounded px-3 py-2">
                        </div>
                    @endif

                    {{-- BUY BUTTON --}}
                    @if(!$buy_selected && !$rental_selected)
                        <button wire:click="selectBuy" class="w-full bg-emerald-600 hover:bg-emerald-700 py-3 rounded-lg font-bold">
                            Beli Sekarang
                        </button>
                    @endif

                    {{-- TOTAL --}}
                    @if($total_price > 0)
                        <div class="text-sm text-gray-300">
                            <p>Total Harga: <b>Rp {{ number_format($total_price,0,',','.') }}</b></p>
                            <p>DP {{ $dp_percent }}%: <b>Rp {{ number_format($dp_amount,0,',','.') }}</b></p>
                        </div>
                    @endif

                    {{-- PAYMENT --}}
                    @if($show_payment)
                        <div class="space-y-3">
                            <p class="font-semibold">Metode Pembayaran</p>
                            <div class="flex gap-3 flex-wrap">

                                <button 
                                    wire:click="pay('cash')" 
                                    class="px-4 py-2 bg-sky-600 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                    @if($car->stock == 0) disabled @endif
                                >
                                    Cash
                                </button>

                                <button 
                                    wire:click="pay('transfer')" 
                                    class="px-4 py-2 bg-yellow-500 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                    @if($car->stock == 0) disabled @endif
                                >
                                    Transfer
                                </button>

                                <button 
                                    wire:click="pay('qris')" 
                                    class="px-4 py-2 bg-gray-700 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                    @if($car->stock == 0) disabled @endif
                                >
                                    QRIS
                                </button>
                            </div>

                            {{-- Tampilkan QRIS jika dipilih --}}
                            @if($qris_url)
                                <img src="{{ $qris_url }}" class="w-48 mt-3 rounded shadow">
                            @endif
                        </div>
                    @endif


                </div>

                {{-- CONTACT --}}
                <div class="flex gap-4">
                    <a href="https://www.instagram.com/sakiyyl?igsh=bHVpZWNoaXQyaDlr" class="flex-1 bg-sky-600 hover:bg-sky-700 py-3 rounded-lg text-center font-semibold"> Call Ceo </a>
                    <a href="https://wa.me/085787091311" target="_blank" class="flex-1 bg-emerald-600 hover:bg-emerald-700 py-3 rounded-lg text-center font-semibold"> WhatsApp </a>
                </div>

            </div>
        </div>
    </div>
</div>
