<div>
    <h1 class="text-2xl font-bold mb-6">Admin Mobil</h1>

    <form wire:submit.prevent="save" class="mb-10">
        <input wire:model="name" placeholder="Nama Mobil">
        <input wire:model="brand" placeholder="Brand">
        <input wire:model="year" type="number" placeholder="Tahun">
        <input wire:model="rental_price" type="number" placeholder="Harga Rental">
        <input wire:model="stock" type="number" placeholder="Stock">
        <input wire:model="photo" type="file">

        <button type="submit">Simpan</button>
    </form>

    <hr>

    @foreach ($cars as $car)
        <div class="flex justify-between">
            <span>{{ $car->name }}</span>
            <button wire:click="delete({{ $car->id }})">Hapus</button>
        </div>
    @endforeach
</div>
