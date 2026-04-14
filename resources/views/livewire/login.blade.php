<div class="min-h-screen w-full flex items-center justify-center
    bg-[#07090d] relative overflow-hidden text-white">

    <!-- ===== BACKGROUND MOBIL (4K HD AUTO SLIDE) ===== -->
    <div class="absolute inset-0 z-0">
        <img id="bgCar"
             src="{{ asset('images/showroom-car1.jpg') }}"
             class="w-full h-full object-cover object-center
                    scale-105 contrast-110 saturate-110 transition-opacity duration-1000"
             loading="eager"
             decoding="async">
    </div>

    <!-- ===== DEPTH FOCUS CINEMATIC ===== -->
    <div class="absolute inset-0 z-0
        bg-[radial-gradient(circle_at_center,transparent_40%,rgba(0,0,0,0.55))]">
    </div>

    <!-- ===== OVERLAY DEPTH PREMIUM ===== -->
    <div class="absolute inset-0 z-0
        bg-gradient-to-b from-black/40 via-transparent to-black/70">
    </div>

    <!-- ===== AMBIENT LIGHTING ===== -->
    <div class="absolute inset-0">
        <div class="absolute top-[-200px] left-1/2 -translate-x-1/2 w-[900px] h-[500px]
            bg-emerald-500/10 blur-[140px] rounded-full"></div>

        <div class="absolute bottom-[-200px] right-[-200px] w-[600px] h-[600px]
            bg-cyan-400/10 blur-[160px] rounded-full"></div>
    </div>

    <!-- ===== FLOOR REFLECTION ===== -->
    <div class="absolute bottom-0 w-full h-64
        bg-gradient-to-t from-black via-transparent to-transparent opacity-80">
    </div>

    <!-- ===== BACKGROUND BRAND TEXT ===== -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <h1 class="text-[120px] md:text-[180px] font-black tracking-[0.25em]
            text-white/[0.03] select-none text-center leading-none">
            PLENGER CAR
        </h1>
    </div>

    <!-- ===== MAIN LOGIN CARD ===== -->
    <div class="relative w-full max-w-md px-6">

        <div class="absolute -inset-[1px] rounded-3xl
            bg-gradient-to-r from-emerald-500/30 via-cyan-400/20 to-emerald-500/30
            blur-lg opacity-60">
        </div>

        <div class="relative
            bg-white/[0.04]
            backdrop-blur-2xl
            border border-white/10
            shadow-[0_0_60px_rgba(16,185,129,0.15)]
            rounded-3xl p-8">

            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 mb-4">
                    <div class="w-10 h-[2px] bg-emerald-400"></div>
                    <p class="text-xs tracking-[0.4em] text-gray-400">
                        SHOWROOM EXCLUSIVE
                    </p>
                    <div class="w-10 h-[2px] bg-emerald-400"></div>
                </div>

                <h2 class="text-3xl font-semibold tracking-wide">
                    Login Account
                </h2>

                <p class="text-gray-400 text-sm mt-2">
                    Akses sistem showroom premium
                </p>
            </div>

            @if(session()->has('error'))
                <div class="bg-red-500/10 text-red-400 p-3 mb-4 rounded-lg text-sm border border-red-500/20 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="login" class="space-y-5">

                <div>
                    <label class="text-xs tracking-widest text-gray-400">
                        EMAIL ADDRESS
                    </label>

                    <input type="email"
                        wire:model.lazy="email"
                        placeholder="email@example.com"
                        class="w-full mt-2 px-4 py-3 rounded-xl
                            bg-black/40 border border-white/10 text-gray-100
                            focus:outline-none focus:border-emerald-400/50
                            focus:ring-1 focus:ring-emerald-400/40 transition">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs tracking-widest text-gray-400">
                        PASSWORD
                    </label>

                    <input type="password"
                        wire:model.lazy="password"
                        placeholder="••••••••"
                        class="w-full mt-2 px-4 py-3 rounded-xl
                            bg-black/40 border border-white/10 text-gray-100
                            focus:outline-none focus:border-emerald-400/50
                            focus:ring-1 focus:ring-emerald-400/40 transition">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3 rounded-xl
                        bg-gradient-to-r from-emerald-500 to-emerald-600
                        hover:from-emerald-400 hover:to-emerald-500
                        text-black font-semibold tracking-wide
                        shadow-lg shadow-emerald-500/20 transition">

                    <span wire:loading.remove>ENTER SHOWROOM</span>
                    <span wire:loading>PROCESSING...</span>
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-400">
                Tidak punya akun?
                <a href="{{ route('register') }}"
                   class="text-emerald-400 hover:text-emerald-300 font-semibold">
                    Daftar sekarang
                </a>
            </div>

            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <p class="text-xs tracking-[0.3em] text-gray-500">
                    PLENGER CAR INDONESIA
                </p>
            </div>

        </div>
    </div>
</div>

<!-- ===== SCRIPT AUTO SLIDE BACKGROUND ===== -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const images = [
        "{{ asset('images/showroom-car1.jpg') }}",
        "{{ asset('images/showroom-car2.jpg') }}",
        "{{ asset('images/showroom-car3.jpg') }}"
    ];

    let i = 0;
    const el = document.getElementById("bgCar");

    setInterval(() => {
        el.style.opacity = 0;
        setTimeout(() => {
            i = (i + 1) % images.length;
            el.src = images[i];
            el.style.opacity = 1;
        }, 500);
    }, 6000);
});
</script>
