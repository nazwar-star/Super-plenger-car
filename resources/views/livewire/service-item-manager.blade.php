<div class="p-6">

    <!-- FORM TAMBAH SERVICE ITEM -->
    <div class="mb-6 border p-4 rounded shadow">
        <h2 class="font-bold mb-4">Tambah Produk / Jasa</h2>
        <div class="grid grid-cols-2 gap-4">
            <input wire:model="name" type="text" placeholder="Nama Item" class="border p-2 rounded">
            <input wire:model="price" type="number" placeholder="Harga" class="border p-2 rounded">
            <input wire:model="stock" type="number" placeholder="Stock" class="border p-2 rounded">
            <input wire:model="category" type="text" placeholder="Kategori" class="border p-2 rounded">
            <input wire:model="image" type="file" class="border p-2 rounded col-span-2">
        </div>
        <button wire:click="addItem" class="mt-4 bg-green-500 text-white p-2 rounded">Tambah Item</button>
    </div>

    <!-- GRID SERVICE ITEMS -->
    <div class="grid grid-cols-3 gap-4">
        @foreach($items as $item)
        <div class="border p-4 rounded shadow flex flex-col justify-between">
            @if($item->image)
                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="mb-2 h-32 object-cover rounded">
            @endif
            <h3 class="font-bold">{{ $item->name }}</h3>
            <p>Rp {{ number_format($item->price,0,',','.') }}</p>
            <p>Stock: {{ $item->stock }}</p>
            <p>Kategori: {{ $item->category }}</p>
            <button wire:click="removeItem({{ $item->id }})" class="bg-red-500 text-white p-2 rounded mt-2">
                Hapus
            </button>
        </div>
        @endforeach
    </div>
</div>
