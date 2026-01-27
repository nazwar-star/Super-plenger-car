<div class="min-h-screen bg-gradient-to-br from-[#050b17] via-[#0b1220] to-[#020617] text-slate-100">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-[#0b1220]/80 backdrop-blur-xl border-r border-white/10 p-6 flex flex-col sticky top-0 h-screen">

            <div class="mb-10">
                <h2 class="text-xl font-extrabold tracking-wide text-white">
                    Showroom
                </h2>
                <p class="text-xs text-slate-400">
                    Plenger SuperCar
                </p>
            </div>

            <nav class="flex-1 space-y-2 text-sm">
                <a href="#" class="sidebar-link active">Home</a>

                @if($user_role !== 'guest')
                    <a href="{{ route('service.manager') }}" class="sidebar-link">
                        Bengkel
                    </a>
                @endif

                <span class="sidebar-disabled">Stock</span>
                <span class="sidebar-disabled">Contact</span>
                <span class="sidebar-disabled">Masukan</span>
                <span class="sidebar-disabled">User</span>
            </nav>

            <div class="mt-6">
                @if($user_role !== 'guest')
                    <button wire:click="logout"
                        class="w-full px-4 py-2 rounded-xl bg-red-600/80 text-white text-sm font-semibold hover:bg-red-700 transition">
                        Logout
                    </button>
                @else
                    <a href="{{ route('login') }}"
                        class="block text-center px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                        Login
                    </a>
                @endif
            </div>

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto px-10 py-12">

            <div class="mb-14">
                <h1 class="text-3xl font-extrabold text-white">
                    Dashboard Plenger
                </h1>
                <p class="text-slate-400 mt-2">
                    Plenger SuperCar Management System
                </p>
            </div>

            {{-- FORM TAMBAH MOBIL --}}
            @if($user_role === 'admin')
            <form wire:submit.prevent="save"
                class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-xl p-10 mb-16">

                <h2 class="text-2xl font-bold text-white mb-8">
                    Tambah Mobil Baru
                </h2>

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

                    <div class="lg:col-span-3">
                        <label class="form-label">Foto Mobil</label>
                        <input wire:model="photo" type="file" class="input-file-dark w-full">

                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}"
                                 class="mt-4 h-32 rounded-xl object-cover border border-white/10">
                        @endif
                    </div>
                </div>

                <div class="flex justify-end mt-10">
                    <button type="submit"
                        class="px-10 py-3 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700 transition">
                        Simpan Mobil
                    </button>
                </div>
            </form>
            @endif

            {{-- GRID MOBIL --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 pb-20">

                @foreach ($cars as $car)
                <div class="car-card bg-gradient-to-br from-[#0b1220]/90 via-[#020617]/90 to-black/90
                            backdrop-blur-xl rounded-2xl shadow-xl
                            hover:shadow-2xl hover:-translate-y-1
                            transition-all duration-300 overflow-hidden
                            border border-white/10">

                    {{-- IMAGE --}}
                    <div class="relative h-56 overflow-hidden">
                        @if($car->photo)
                            <img src="{{ asset('storage/'.$car->photo) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="h-full flex items-center justify-center text-slate-400 text-sm">
                                No Image
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

                        {{-- STATUS --}}
                        <div class="absolute top-4 right-4 z-10">
                            @if($car->stock > 0)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-600/90 text-white">
                                    ForSale
                                    
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-600/90 text-white">
                                    Sold Out
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="p-6 space-y-2">
                        <h3 class="font-bold text-lg text-white">{{ $car->name }}</h3>

                        <p class="text-sm text-slate-400">
                            {{ $car->brand }} • {{ $car->year }}
                        </p>

                        <p class="text-emerald-400 font-extrabold text-lg tracking-wide">
                            Rp {{ number_format($car->rental_price,0,',','.') }}
                        </p>
                        <p class="text-xs text-slate-400 uppercase tracking-wider">
                            Per Day Rental
                        </p>

                        <div class="flex justify-between items-center pt-4">
                            <a href="{{ url('/car/'.$car->id) }}"
                               class="group px-4 py-2 text-sm rounded-xl
                                      border border-white/20 text-white
                                      hover:bg-white/10 transition
                                      flex items-center gap-2">
                                Detail
                                <span class="group-hover:translate-x-1 transition">→</span>
                            </a>

                            @if($user_role === 'admin')
                                <button wire:click="delete({{ $car->id }})"
                                    class="px-4 py-2 text-sm rounded-xl bg-red-600/80 text-white hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
                @endforeach

            </div>

        </main>
    </div>

    {{-- STYLE --}}
    <style>
        .sidebar-link {
            display:block;
            padding:.6rem .8rem;
            border-radius:.75rem;
            font-weight:500;
            color:#cbd5f5;
        }
        .sidebar-link:hover {
            background:rgba(255,255,255,.05);
            color:white;
        }
        .active {
            background:rgba(255,255,255,.08);
            color:white;
            font-weight:600;
        }
        .sidebar-disabled {
            display:block;
            padding:.6rem .8rem;
            color:#64748b;
            font-size:.75rem;
        }
        .form-label {
            font-size:.7rem;
            font-weight:600;
            color:#94a3b8;
            text-transform:uppercase;
            margin-bottom:.3rem;
            display:block;
        }
        .input-dark {
            background:rgba(255,255,255,.05);
            border:1px solid rgba(255,255,255,.15);
            border-radius:1rem;
            padding:.7rem;
            font-size:.875rem;
            color:white;
        }
        .input-file-dark {
            border:2px dashed rgba(255,255,255,.2);
            padding:1rem;
            border-radius:1rem;
            color:#cbd5f5;
        }

        .car-card {
            position: relative;
        }
        .car-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 1rem;
            background: radial-gradient(
                600px circle at var(--x) var(--y),
                rgba(16,185,129,0.18),
                transparent 40%
            );
            opacity: 0;
            transition: opacity .3s;
            pointer-events: none;
        }
        .car-card:hover::before {
            opacity: 1;
        }
    </style>

</div>
