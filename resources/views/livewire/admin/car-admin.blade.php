<div class="max-w-7xl mx-auto p-8">

    <h1 class="text-3xl font-bold mb-6 text-white">
        Admin • Manajemen Mobil
    </h1>

    {{-- FORM --}}
    <div class="bg-white/5 p-6 rounded-xl mb-10">
        <h2 class="font-semibold mb-4">
            {{ $isEdit ? 'Edit Mobil' : 'Tambah Mobil' }}
        </h2>

        <div class="grid grid-cols-2 gap-4">
            <input wire:model.defer="name" placeholder="Nama" class="input-dark">
            <input wire:model.defer="brand" placeholder="Brand" class="input-dark">
            <input wire:model.defer="year" placeholder="Tahun" class="input-dark">
            <input wire:model.defer="rental_price" placeholder="Harga Rental" class="input-dark">
            <input wire:model.defer="sale_price" placeholder="Harga Jual" class="input-dark">
            <input wire:model.defer="stock" placeholder="Stok" class="input-dark">
            <input wire:model="photo" type="file" class="input-file-dark col-span-2">
        </div>

        <button
            wire:click="{{ $isEdit ? 'update' : 'save' }}"
            class="mt-4 px-6 py-2 bg-emerald-600 rounded">
            {{ $isEdit ? 'Update' : 'Simpan' }}
        </button>
    </div>

    {{-- LIST --}}
    <div class="grid grid-cols-3 gap-6">
        @foreach($cars as $car)
            <div class="bg-white/5 p-4 rounded-xl">
                <h3 class="font-bold">{{ $car->name }}</h3>
                <p class="text-sm text-gray-400">{{ $car->brand }}</p>

                <div class="flex gap-2 mt-4">
                    <button wire:click="edit({{ $car->id }})"
                        class="px-3 py-1 bg-blue-600 rounded">
                        Edit
                    </button>

                    <button wire:click="delete({{ $car->id }})"
                        class="px-3 py-1 bg-red-600 rounded">
                        Hapus
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</div>
