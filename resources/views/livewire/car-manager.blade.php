<div class="max-w-7xl mx-auto p-6"> {{-- Root Livewire --}}

    {{-- Header: Bengkel + Logout --}}
    <div class="flex justify-between items-center mb-6">
        @if($user_role !== 'guest')
            <a href="{{ route('service.manager') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow text-sm">
                → Ke Bengkel
            </a>
            <button wire:click="logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
                Logout
            </button>
        @else
            <div class="mb-6 flex justify-end">
                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow text-sm">
                    Login
                </a>
            </div>
        @endif
    </div>

    {{-- Form Tambah Mobil (Admin Only) --}}
    @if($user_role === 'admin')
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Tambah Mobil Baru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <input type="text" wire:model="name" placeholder="Nama Mobil" class="border rounded p-2 text-sm">
            <input type="text" wire:model="brand" placeholder="Brand" class="border rounded p-2 text-sm">
            <input type="number" wire:model="year" placeholder="Tahun" class="border rounded p-2 text-sm">
            <input type="number" wire:model="rental_price" placeholder="Harga Rental / Hari" class="border rounded p-2 text-sm">
            <input type="number" wire:model="sale_price" placeholder="Harga Jual" class="border rounded p-2 text-sm">
            <input type="number" wire:model="stock" placeholder="Stok" class="border rounded p-2 text-sm">
            <input type="file" wire:model="photo" class="border rounded p-2 text-sm">
        </div>
        <button wire:click="save" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
            Simpan Mobil
        </button>
    </div>
    @endif

    {{-- Grid Showroom --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($cars as $car)
            <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition duration-300">

                {{-- Foto & Link ke Detail --}}
                <a href="{{ url('/car/'.$car->id) }}">
                    <div class="h-40 bg-gray-200 overflow-hidden">
                        @if($car->photo)
                            <img src="{{ asset('storage/'.$car->photo) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="h-full flex items-center justify-center text-gray-400 text-sm">No Image</div>
                        @endif
                    </div>
                </a>

                {{-- Info Mobil --}}
                <div class="p-3 text-sm">
                    <h3 class="font-bold">{{ $car->name }}</h3>
                    <p class="text-gray-500">{{ $car->brand }} • {{ $car->year }}</p>
                    <p class="text-blue-600 font-semibold mt-1">Rp {{ number_format($car->rental_price,0,',','.') }}/hari</p>
                    <p class="text-green-600 font-semibold">Rp {{ number_format($car->sale_price,0,',','.') }}</p>
                    <p>Stok: <b>{{ $car->stock }}</b></p>

                    <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full
                        @if($car->status === 'available') bg-green-100 text-green-700
                        @elseif($car->status === 'rented') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst($car->status) }}
                    </span>

                    {{-- Tombol Lihat Detail --}}
                    <a href="{{ url('/car/'.$car->id) }}"
                        class="mt-2 inline-block bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded shadow text-xs">
                        Lihat Detail
                    </a>

                    {{-- Tombol Hapus Admin --}}
                    @if($user_role === 'admin')
                        <button wire:click="delete({{ $car->id }})" class="mt-1 bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs shadow">
                            Hapus
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 mt-2">Belum ada mobil tersedia.</p>
        @endforelse
    </div>

</div> {{-- End Root Livewire --}}
