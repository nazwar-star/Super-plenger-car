<div class="min-h-screen bg-gradient-to-br from-[#050814] via-[#0b1220] to-[#020617] text-slate-100">

<main class="max-w-7xl mx-auto px-6 py-12">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-12">
        <div>
            <h1 class="text-4xl font-extrabold tracking-tight text-white">Koleksi Plenger</h1>
            <p class="text-slate-400 mt-1">Showroom mobil eksklusif pilihan terbaik Eropa</p>
        </div>
        <div class="flex gap-3 items-center">

            @if($user_role==='admin')
                <span class="px-4 py-2 rounded-xl bg-emerald-600/25 text-emerald-400 text-sm font-semibold backdrop-blur-sm">ADMIN MODE</span>
            @endif
        </div>
    </div>

    {{-- FILTER BRAND --}}
    <div class="flex flex-wrap gap-3 mb-6 items-center">
        <select wire:model.live="brandFilter"
        class="px-4 py-2 rounded-xl bg-gray-900/70 text-sm text-white border border-white/20 backdrop-blur-sm focus:ring-2 focus:ring-emerald-400/40">
            <option value="">Semua Brand</option>
            @foreach($brands as $brand)
                <option value="{{ $brand }}">{{ $brand }}</option>
            @endforeach
        </select>

        <button
            wire:click="$toggle('showSold')"
            class="px-4 py-2 rounded-xl text-sm font-semibold transition
            {{ $showSold
                ? 'bg-red-600/80 hover:bg-red-700/80'
                : 'bg-gray-700/70 hover:bg-gray-600/70'
            }} backdrop-blur-sm">
            Mobil Terjual
        </button>
    </div>

    {{-- FORM TAMBAH / EDIT --}}
    @if($user_role==='admin')
    <form wire:submit.prevent="save" class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-8 mb-16 space-y-8 transition-all duration-300">
        <h2 class="text-2xl font-bold text-white">{{ $isEdit ? '✏️ Edit Mobil' : '➕ Tambah Mobil Baru' }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="form-label">Nama Mobil</label>
                <input wire:model.defer="name" class="input-dark w-full">
            </div>
            <div>
                <label class="form-label">Brand</label>
                <input wire:model.defer="brand" class="input-dark w-full">
            </div>
            <div>
                <label class="form-label">Tahun</label>
                <input wire:model.defer="year" type="number" class="input-dark w-full">
            </div>
            <div>
                <label class="form-label">Harga Rental / Hari</label>
                <input wire:model.defer="rental_price" type="number" class="input-dark w-full">
            </div>
            <div>
                <label class="form-label">Harga Jual</label>
                <input wire:model.defer="sale_price" type="number" class="input-dark w-full">
            </div>
            <div>
                <label class="form-label">Stok</label>
                <input wire:model.defer="stock" type="number" class="input-dark w-full">
            </div>
        </div>

        {{-- FOTO UTAMA --}}
        <div>
            <label class="form-label">Foto Mobil (Utama)</label>
            <input wire:model="photo" type="file" class="input-file-dark w-full">
            @if($photo)
                <img src="{{ $photo->temporaryUrl() }}" class="mt-4 h-48 w-full object-contain rounded-xl bg-black/30 p-3 shadow-lg">
            @elseif($isEdit && $car_id && \App\Models\Car::find($car_id)->photo)
                <img src="{{ asset('storage/' . \App\Models\Car::find($car_id)->photo) }}" class="mt-4 h-48 w-full object-contain rounded-xl bg-black/30 p-3 shadow-lg">
            @endif
        </div>

        {{-- GALLERY --}}
        <div>
            <label class="form-label">Gallery (Bisa Banyak)</label>
            <input wire:model="images" type="file" multiple class="input-file-dark w-full">

            {{-- Existing gallery --}}
            @if($existingImages)
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3 mt-3">
                    @foreach($existingImages as $img)
                        <div class="relative group rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ asset('storage/'.$img['path']) }}" class="h-24 w-full object-cover">
                            <button type="button"
                                    wire:click="removeExistingImage({{ $img['id'] }})"
                                    class="absolute top-1 right-1 bg-red-600 rounded-full p-1 text-white opacity-0 group-hover:opacity-100 transition">
                                &times;
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- New images --}}
            @if($images)
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3 mt-3">
                    @foreach($images as $img)
                        <img src="{{ $img->temporaryUrl() }}" class="h-24 w-full object-cover rounded-xl hover:scale-105 transition-transform shadow-md">
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <label class="form-label">Deskripsi</label>
            <textarea wire:model.defer="description" class="input-dark w-full" rows="4"></textarea>
        </div>
        <div>
            <label class="form-label">Options (1 baris = 1)</label>
            <textarea wire:model.defer="options" class="input-dark w-full" rows="4" placeholder="ABS&#10;Sunroof&#10;Carbon Interior"></textarea>
        </div>
        <div class="max-w-sm">
            <label class="form-label">YouTube ID</label>
            <input wire:model.defer="youtube_url" class="input-dark w-full" placeholder="dQw4w9WgXcQ">
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-8 py-3 rounded-xl bg-emerald-600 text-black font-semibold hover:bg-emerald-700 transition">Simpan Mobil</button>
        </div>
    </form>
    @endif

    {{-- GRID MOBIL --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 pb-24">
        @forelse($cars as $car)
            <div class="bg-gradient-to-b from-[#0b1220]/80 to-[#03050d]/80 border border-white/10 shadow-2xl rounded-3xl overflow-hidden flex flex-col hover:scale-[1.02] transition-transform duration-300">
                <div class="h-56 relative bg-black/30">
                    @if($car->photo)
                        <img src="{{ asset('storage/'.$car->photo) }}" class="w-full h-full object-cover rounded-t-3xl">
                    @else
                        <div class="flex items-center justify-center h-full text-slate-500">No Image</div>
                    @endif

                    {{-- READY / SOLD OUT --}}
                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold {{ $car->stock>0 ? 'bg-emerald-500 text-black' : 'bg-red-600 text-white' }}">
                        {{ $car->stock>0 ? 'Ready' : 'Sold Out' }}
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ $car->name }}</h3>
                        <p class="text-sm text-slate-400">{{ $car->brand }} • {{ $car->year }}</p>
                        <p class="text-emerald-400 font-semibold mt-1">Rp {{ number_format($car->rental_price,0,',','.') }} / Day</p>
                    </div>
                    <div class="mt-4 flex gap-2 justify-end">
                        <a href="{{ url('/car/'.$car->id) }}" class="px-3 py-1 text-sm rounded-lg border border-white/20 hover:bg-white/10 transition">Detail</a>
                        @if($user_role==='admin')
                            <button wire:click="edit({{ $car->id }})" class="px-3 py-1 text-sm rounded-lg bg-blue-600 hover:bg-blue-700 transition">Edit</button>
                            <button wire:click="delete({{ $car->id }})" class="px-3 py-1 text-sm rounded-lg bg-red-600 hover:bg-red-700 transition">Hapus</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-slate-400 col-span-3">Belum ada mobil</p>
        @endforelse
    </div>
</main>

<style>
.form-label { font-size:.75rem; font-weight:600; color:#94a3b8; text-transform:uppercase; margin-bottom:.3rem; display:block; }
.input-dark { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.15); border-radius:1rem; padding:.7rem; color:white; transition:border .2s; }
.input-dark:focus { border-color:#10b981; outline:none; }
.input-file-dark { border:2px dashed rgba(255,255,255,.2); padding:1rem; border-radius:1rem; color:#cbd5f5; backdrop-blur-sm; }
</style>

</div>
