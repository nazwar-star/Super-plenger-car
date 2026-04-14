<div class="min-h-screen bg-gradient-to-br from-[#020617] via-[#050b17] to-black text-slate-100 p-6">

    {{-- HEADER --}}
    <h1 class="text-3xl font-extrabold mb-1">Bengkel & Service</h1>
    <p class="text-gray-400 mb-8">Pilih item untuk dibeli atau booking jasa service</p>

    {{-- TABS --}}
    <div class="flex gap-4 mb-8">
        <button wire:click="$set('activeTab','bengkel')"
            class="px-4 py-2 rounded-lg font-semibold transition
            {{ $activeTab === 'bengkel' ? 'bg-emerald-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
            Bengkel (Item)
        </button>
        <button wire:click="$set('activeTab','jasa')"
            class="px-4 py-2 rounded-lg font-semibold transition
            {{ $activeTab === 'jasa' ? 'bg-emerald-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
            Jasa Service
        </button>
    </div>

    {{-- ================= BENGKEL ================= --}}
    @if($activeTab === 'bengkel')

        {{-- FORM ADMIN TAMBAH / EDIT --}}
        @if(auth()->user()->role === 'admin')
            <div class="bg-gray-900 p-6 rounded-2xl shadow-xl mb-10 border border-gray-700">
                <h2 class="text-xl font-semibold mb-5 flex items-center gap-2 text-emerald-400">
                    <span class="text-2xl">+</span> Tambah / Edit Item
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <input type="text" wire:model="item_name" placeholder="Nama Item" class="input-dark">
                    <input type="text" wire:model="category" placeholder="Kategori" class="input-dark">
                    <input type="number" wire:model="price" placeholder="Harga" class="input-dark">
                    <input type="number" wire:model="stock" placeholder="Stok" class="input-dark">
                    <input type="file" wire:model="image" class="file-input-dark">
                </div>

                @if($image)
                    <p class="text-sm mt-2 text-gray-300">Preview:</p>
                    <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-xl mb-3">
                @endif

                <div class="flex justify-end mt-5 gap-3">
                    <button wire:click="resetForm" class="btn-gray">Batal</button>
                    <button wire:click="saveItem" class="btn-green">Simpan</button>
                </div>
            </div>
        @endif

        {{-- LIST ITEM --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($serviceItems as $item)
                <div class="bg-[#0b1220] p-5 rounded-2xl shadow-lg hover:shadow-2xl
            transform hover:-translate-y-1 transition-all
            border border-gray-800 relative">


                    {{-- IMAGE --}}
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->item_name }}" class="w-full h-36 object-cover rounded-xl mb-3">
                    @endif

                    {{-- NAMA ITEM & ADMIN BUTTONS --}}
                    <div class="flex justify-between items-start">
                        <h3 class="font-semibold text-lg text-white">{{ $item->item_name }}</h3>
                        @if(auth()->user()->role === 'admin')
                            <div class="flex gap-2">
                                <button wire:click="editItem({{ $item->id }})" class="text-blue-400 hover:text-blue-300 text-sm font-semibold">Edit</button>
                                <button wire:click="deleteItem({{ $item->id }})" class="text-red-500 hover:text-red-400 text-sm font-semibold">Hapus</button>
                            </div>
                        @endif
                    </div>

                    <p class="text-gray-400 text-sm mt-1">{{ $item->category }}</p>
                    <p class="text-emerald-400 font-bold text-lg mt-3">Rp {{ number_format($item->price,0,',','.') }}</p>
                    <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full
                        {{ $item->stock > 5 ? 'bg-emerald-600 text-white' : ($item->stock > 0 ? 'bg-yellow-500 text-black' : 'bg-red-500 text-white') }}">
                        Stok: {{ $item->stock }}
                    </span>

                    {{-- TOMBOL + KERANJANG --}}
                    @if($item->stock > 0 && auth()->user()->role !== 'admin')
                        <button wire:click="addToCart({{ $item->id }})"
                            class="absolute top-3 right-3 bg-emerald-600 p-2 rounded-full hover:bg-emerald-700 transition text-lg">
                            🛒
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- ================= JASA ================= --}}
    @if($activeTab === 'jasa')
        @if(auth()->user()->role === 'admin')
            <div class="bg-gray-900 p-6 rounded-2xl shadow-xl mb-10 border border-gray-700">
                <h2 class="text-xl font-semibold mb-5 flex items-center gap-2 text-emerald-400">
                    <span class="text-2xl">+</span> Tambah / Edit Jasa
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" wire:model="service_name" placeholder="Nama Jasa" class="input-dark">
                    <input type="number" wire:model="service_price" placeholder="Harga" class="input-dark">
                </div>

                <div class="flex justify-end mt-5 gap-3">
                    <button wire:click="resetForm" class="btn-gray">Batal</button>
                    <button wire:click="saveService" class="btn-green">Simpan</button>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($services as $s)
                <div class="bg-[#0b1220] p-5 rounded-2xl shadow-lg hover:shadow-2xl
    transform hover:-translate-y-1 transition-all border border-gray-800 relative">

    <div class="flex justify-between items-start">
        <h3 class="font-semibold text-lg text-white">{{ $s->name }}</h3>

        @if(auth()->user()->role === 'admin')
            <div class="flex gap-2">
                <button wire:click="editService({{ $s->id }})"
                    class="text-blue-400 hover:text-blue-300 text-sm font-semibold">Edit</button>

                <button wire:click="deleteService({{ $s->id }})"
                    class="text-red-500 hover:text-red-400 text-sm font-semibold">Hapus</button>
            </div>
        @endif
    </div>

    <p class="text-emerald-400 font-bold text-lg mt-3">
        Rp {{ number_format($s->price,0,',','.') }}
    </p>

    {{-- tombol tambah ke keranjang --}}
    @if(auth()->user()->role !== 'admin')
        <button wire:click="addServiceToCart({{ $s->id }})"
            class="absolute top-3 right-3 bg-emerald-600 p-2 rounded-full hover:bg-emerald-700 transition text-lg">
            🛠️
        </button>
    @endif
</div>

            @endforeach
        </div>
    @endif

    {{-- ================= FLOATING KERANJANG ================= --}}
    @if(auth()->user()->role !== 'admin')
        <button wire:click="$toggle('showCart')" 
            class="fixed bottom-5 right-5 bg-emerald-600 text-white p-4 rounded-full shadow-lg hover:bg-emerald-700 transition z-50">
            🛒 Keranjang ({{ count($cartData) }})
        </button>
    @endif

    {{-- ================= DRAWER KERANJANG ================= --}}
    @if($showCart)
        <div class="fixed inset-0 bg-black/50 z-40 flex justify-end">
            <div class="bg-gray-900 w-full md:w-1/3 p-6 h-full overflow-auto">
                <h2 class="text-xl font-semibold text-white mb-4">Keranjang</h2>

                @foreach($cartData as $id => $item)
                    <div class="bg-gray-800 p-3 rounded-xl mb-3 flex justify-between">
                        <div>
                            <p class="text-white font-semibold">{{ $item['name'] }}</p>
                            <p class="text-gray-400 text-sm">Rp {{ number_format($item['price'],0,',','.') }}</p>
                            <p class="text-gray-400 text-sm">Qty: {{ $item['qty'] }}</p>
                        </div>
                        <button wire:click="removeFromCart({{ $id }})" class="text-red-500 hover:text-red-400">✖</button>
                    </div>
                @endforeach

                {{-- Pilih metode service --}}
                <div class="mb-4 flex gap-4">
                    <button wire:click="$set('serviceType','bengkel')"
                        class="px-4 py-2 rounded-lg font-semibold transition
                        {{ $serviceType === 'bengkel' ? 'bg-emerald-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                        Service di Bengkel
                    </button>
                    <button wire:click="$set('serviceType','home')"
                        class="px-4 py-2 rounded-lg font-semibold transition
                        {{ $serviceType === 'home' ? 'bg-emerald-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                        Service di Rumah
                    </button>
                </div>

                {{-- Form Service Master --}}
                @if($serviceType && $selectedServiceMaster)
                    @php $master = \App\Models\ServiceMaster::find($selectedServiceMaster); @endphp
                    @if($master)
                        <div class="bg-gray-800 p-4 rounded-xl mb-4">
                            <h3 class="text-lg font-semibold text-white">{{ $master->service_name }}</h3>
                            <p class="text-emerald-400 font-bold mt-2">Rp {{ number_format($master->price,0,',','.') }}</p>

                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <input type="date" wire:model="serviceDate" class="input-dark">
                                <input type="time" wire:model="serviceTime" class="input-dark">
                            </div>
                        </div>
                    @endif
                @endif

                <div class="flex justify-between items-center mt-4">
                    <p class="text-white font-semibold">
                        Total: Rp {{ number_format($this->calculateTotal(),0,',','.') }}
                    </p>
                    <button wire:click="checkoutCart" class="px-5 py-2 bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                        Checkout / Booking
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ================ STYLING ================= --}}
    <style>
        .input-dark {
            @apply w-full p-3 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-emerald-500 focus:border-emerald-500;
        }
        .file-input-dark {
            @apply w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-600;
        }
        .btn-gray {
            @apply px-5 py-2 bg-gray-700 rounded-lg hover:bg-gray-600 transition;
        }
        .btn-green {
            @apply px-5 py-2 bg-emerald-600 rounded-lg hover:bg-emerald-700 transition;
        }
    </style>
</div>
