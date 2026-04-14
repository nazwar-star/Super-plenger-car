<div class="min-h-screen bg-[#06080c] text-slate-100 relative overflow-hidden">

    <!-- ===== BACKGROUND MOBIL PREMIUM ===== -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/showroom-car1.jpg') }}"
             class="w-full h-full object-cover object-center scale-105">
    </div>

    <!-- SOFT DARK DEPTH -->
    <div class="absolute inset-0 bg-[#06080c]/85"></div>

    <!-- AMBIENT LIGHT HALUS -->
    <div class="absolute inset-0">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[900px] h-[500px]
            bg-emerald-500/10 blur-[160px] rounded-full"></div>
    </div>

    <!-- WATERMARK BRAND -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <h1 class="text-[180px] font-black tracking-[0.3em]
            text-white/[0.03] select-none">
            PLENGER
        </h1>
    </div>

    <div class="relative z-10">

        <!-- ===== HERO SECTION ===== -->
        <section class="min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto px-10 py-32">

                <p class="text-xs tracking-[0.45em] text-emerald-400 uppercase">
                    Exclusive Showroom Plenger
                </p>

                <h1 class="mt-6 text-6xl md:text-7xl font-extrabold leading-tight">
                    Luxury Without
                    <span class="block text-transparent bg-clip-text
                        bg-gradient-to-r from-emerald-400 to-cyan-400">
                        Compromise
                    </span>
                </h1>

                <p class="mt-8 max-w-xl text-slate-400 text-lg">
                    Koleksi supercar pilihan dengan standar performa tertinggi.
                    Elegan. Presisi. Berkelas.
                </p>

                <div class="mt-12 flex gap-5">
                    <a href="{{ route('stock') }}"
                       class="px-10 py-4 rounded-xl
                              bg-emerald-600 hover:bg-emerald-700
                              text-black font-bold tracking-wide transition">
                        Explore Collection
                    </a>
                </div>
            </div>
        </section>


        <!-- ===== FEATURED COLLECTION ===== -->
        <section class="max-w-7xl mx-auto px-10 pb-32">

            <div class="flex justify-between items-end mb-16">
                <div>
                    <h2 class="text-3xl font-extrabold">
                        Featured Collection
                    </h2>
                    <p class="text-slate-400 mt-2">
                        Pilihan kendaraan paling eksklusif
                    </p>
                </div>

                <a href="{{ route('stock') }}"
                   class="text-sm tracking-widest text-emerald-400 hover:underline">
                    VIEW ALL →
                </a>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">

                @forelse($featuredCars as $car)
                <div class="group relative rounded-2xl
                    bg-white/[0.04] backdrop-blur-xl
                    border border-white/10
                    shadow-[0_10px_40px_rgba(0,0,0,0.6)]
                    overflow-hidden
                    hover:shadow-[0_20px_60px_rgba(0,0,0,0.8)]
                    transition-all duration-300">

                    <!-- IMAGE -->
                    <div class="relative h-[220px] overflow-hidden">
                        @if($car->photo)
                            <img src="{{ asset('storage/'.$car->photo) }}"
                                 class="w-full h-full object-cover
                                        transition duration-700 group-hover:scale-105">
                        @endif

                        <!-- STATUS -->
                        <span class="absolute top-4 left-4 px-3 py-1 text-xs font-bold rounded-full
                            {{ $car->stock > 0 ? 'bg-emerald-500 text-black' : 'bg-red-600 text-white' }}">
                            {{ $car->stock > 0 ? 'AVAILABLE' : 'SOLD OUT' }}
                        </span>

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    </div>

                    <!-- CONTENT -->
                    <div class="px-6 pt-5">
                        <h3 class="text-lg font-extrabold tracking-wide">
                            {{ $car->name }}
                        </h3>

                        <p class="text-xs uppercase tracking-widest text-slate-400 mt-1">
                            {{ $car->brand }} • {{ $car->year }}
                        </p>
                    </div>

                    <!-- FOOTER -->
                    <div class="px-6 pb-6 pt-4 flex items-center justify-between">
                        <div>
                            <p class="text-emerald-400 font-extrabold text-lg">
                                Rp {{ number_format($car->rental_price,0,',','.') }}
                            </p>
                            <p class="text-[10px] tracking-widest text-slate-400 uppercase">
                                Per Day
                            </p>
                        </div>

                        <a href="{{ url('/car/'.$car->id) }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold
                                  border border-white/20
                                  hover:bg-white/10 transition">
                            Detail
                        </a>
                    </div>

                </div>
                @empty
                <p class="text-slate-400">Belum ada mobil tersedia</p>
                @endforelse

            </div>
        </section>

    </div>
</div>
