    <div class="min-h-screen bg-gradient-to-br from-[#020617] via-[#050b17] to-black text-slate-100"
        x-data="{
        tab: 'desc',
        showGallery: false,
        checkoutOpen: false,
        orderType: 'rental',
        agree: false,
        paymentMethod: 'transfer'
    }">

        <main class="max-w-7xl mx-auto px-6 py-12 space-y-16">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h1 class="text-4xl font-extrabold">{{ $car->name }}</h1>
                    <p class="text-gray-400">{{ $car->brand }} • {{ $car->year }}</p>
                </div>
                <a href="{{ route('home') }}"
                class="bg-gray-800 hover:bg-gray-700 px-5 py-2 rounded-lg">
                    ← Back
                </a>
            </div>

            {{-- IMAGE + INFO --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                {{-- IMAGE SLIDER --}}
                <div class="lg:col-span-2"
                    x-data="{
                        active: 0,
                        images: @js(
                            collect([$car->photo])
                                ->merge($car->images->pluck('image_path'))
                                ->filter()
                                ->values()
                        )
                    }">

                    <div class="relative rounded-xl overflow-hidden border border-white/10 bg-black aspect-[3/2]">

                        <template x-for="(img, i) in images" :key="i">
                            <img x-show="active === i"
                                :src="'/storage/' + img"
                                @click="showGallery = true"
                                class="w-full h-full object-contain cursor-pointer transition"
                                x-transition>
                        </template>

                        <button @click="active = active === 0 ? images.length - 1 : active - 1"
                                class="absolute left-4 top-1/2 -translate-y-1/2
                                    bg-black/60 hover:bg-black px-4 py-2 rounded-full">
                            ‹
                        </button>

                        <button @click="active = active === images.length - 1 ? 0 : active + 1"
                                class="absolute right-4 top-1/2 -translate-y-1/2
                                    bg-black/60 hover:bg-black px-4 py-2 rounded-full">
                            ›
                        </button>
                    </div>
                </div>

                {{-- RIGHT PANEL (SATU KOLOM) --}}
                <div class="sticky top-24 h-fit space-y-6">

                    <div class="bg-white/5 p-6 rounded-xl border border-white/10 space-y-4">

                        {{-- SALE PRICE --}}
                        <div>
                            <p class="text-sm text-gray-400">SALE PRICE</p>
                            <p class="text-3xl font-bold">
                                Rp {{ number_format($car->sale_price,0,',','.') }}
                            </p>
                        </div>

                        {{-- RENTAL PRICE --}}
                        <div>
                            <p class="text-sm text-gray-400">RENTAL / DAY</p>
                            <p class="text-xl font-semibold text-emerald-400">
                                Rp {{ number_format($car->rental_price,0,',','.') }}
                            </p>
                        </div>

                        <hr class="border-white/10">

                        {{-- INFO --}}
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <p class="text-gray-400">Brand</p>
                            <p class="font-semibold">{{ $car->brand }}</p>

                            <p class="text-gray-400">Year</p>
                            <p class="font-semibold">{{ $car->year }}</p>

                            <p class="text-gray-400">Stock</p>
                            <p class="font-semibold">{{ $car->stock }}</p>
                        </div>

                    </div>

                    {{-- ACTION BUTTONS --}}
                
                <button
                @click="checkoutOpen = true"
                :disabled="{{ $car->stock <= 0 ? 'true' : 'false' }}"
                class="w-full py-3 rounded-lg font-semibold text-center block
                    {{ $car->stock > 0 ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-gray-600 cursor-not-allowed' }}">
                {{ $car->stock > 0 ? 'Make an Enquiry' : 'Stok Habis' }}
            </button>
                    <a href="https://wa.me/6285787091311"
                    target="_blank"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 py-3 rounded-lg
                            font-semibold text-center block">
                        WhatsApp
                    </a>

                </div>
            </div>

            {{-- TABS --}}
            <div class="border-t border-white/10 pt-10">

                <div class="flex gap-6 border-b border-white/10">
                    <button @click="tab='desc'" :class="tab==='desc' ? 'border-b-2 text-white' : 'text-gray-400'">
                        Description
                    </button>
                    <button @click="tab='opt'" :class="tab==='opt' ? 'border-b-2 text-white' : 'text-gray-400'">
                        Options
                    </button>
                    <button @click="tab='vid'" :class="tab==='vid' ? 'border-b-2 text-white' : 'text-gray-400'">
                        Video
                    </button>
                </div>

                <div class="mt-8 text-gray-300 leading-relaxed">

                    <div x-show="tab==='desc'">
                        {!! nl2br(e($car->description)) !!}
                    </div>

                    <div x-show="tab==='opt'">
                        @if($car->options->count())
                            <ul class="list-disc pl-6 space-y-1">
                                @foreach($car->options as $opt)
                                    <li>{{ $opt->option }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400">No options available.</p>
                        @endif
                    </div>

                    <div x-show="tab==='vid'">
                        @if($car->youtube_url)
                            @php
                                preg_match('/(youtu\.be\/|v=)([^&]+)/', $car->youtube_url, $m);
                                $videoId = $m[2] ?? null;
                            @endphp

                            @if($videoId)
                                <div class="aspect-video rounded-xl overflow-hidden border border-white/10 mt-4">
                                    <iframe class="w-full h-full"
                                            src="https://www.youtube.com/embed/{{ $videoId }}"
                                            allowfullscreen></iframe>
                                </div>
                            @endif
                        @endif
                    </div>

                </div>
            </div>

            {{-- RELATED CARS --}}
            <div>
                <h2 class="text-2xl font-bold mb-6">Similar Vehicles</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach($relatedCars as $item)
                        <a href="{{ route('car.detail',$item->id) }}"
                        class="bg-white/5 rounded-xl overflow-hidden hover:scale-105 transition">
                            <img src="{{ asset('storage/'.$item->photo) }}"
                                class="h-48 w-full object-cover">
                            <div class="p-4">
                                <p class="font-semibold">{{ $item->name }}</p>
                                <p class="text-sm text-gray-400">{{ $item->year }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </main>

        {{-- GALLERY MODAL --}}
        <div x-show="showGallery"
            x-transition
            class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center">

            <button @click="showGallery=false"
                    class="absolute top-6 right-6 text-3xl">✕</button>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 max-w-6xl">
                @foreach(
                    collect([$car->photo])
                        ->merge($car->images->pluck('image_path'))
                        ->filter()
                    as $img
                )
                    <img src="{{ asset('storage/'.$img) }}"
                        class="rounded-xl object-cover cursor-pointer hover:scale-105 transition"
                        @click="showGallery=false">
                @endforeach
            </div>
        </div>

        {{-- CHECKOUT POPUP --}}
<div
    x-show="checkoutOpen"
    x-transition.opacity
    x-cloak
    
    class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center px-4"
>

    <div
        class="bg-[#020617] w-full max-w-lg rounded-xl shadow-xl max-h-[90vh] overflow-hidden"
        @click.outside="checkoutOpen = false"
    >
        @livewire('checkout-car', ['car' => $car], key('checkout-'.$car->id))
    </div>

</div>



    </div>
