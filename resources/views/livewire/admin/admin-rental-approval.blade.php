<div class="min-h-screen bg-gradient-to-br from-[#050b17] via-[#0b1220] to-[#020617] text-slate-100">

    <div class="max-w-5xl mx-auto px-6 py-10">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold">Detail Request</h1>
                <p class="text-sm text-gray-400">
                    Review & persetujuan pesanan
                </p>
            </div>

            <a href="{{ route('admin.request') }}"
               class="text-sm text-emerald-400 hover:underline">
                ← Kembali
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 space-y-6">

            {{-- INFO MOBIL --}}
            <div>
                <h2 class="font-semibold text-lg mb-2">Mobil</h2>
                <div class="grid md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400">Nama</p>
                        <p>{{ $order->car->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Tipe</p>
                        <p>{{ ucfirst($order->type) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Harga</p>
                        <p class="text-emerald-400 font-semibold">
                            Rp {{ number_format($order->price,0,',','.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- INFO USER --}}
            <div>
                <h2 class="font-semibold text-lg mb-2">User</h2>
                <div class="grid md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400">Nama</p>
                        <p>{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Email</p>
                        <p>{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Metode Bayar</p>
                        <p>{{ ucfirst($order->payment_method) }}</p>
                    </div>
                </div>
            </div>

            {{-- FILE --}}
            <div class="grid md:grid-cols-2 gap-6">
                @if($order->ktp_photo)
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Foto KTP</p>
                        <img
                            src="{{ asset('storage/'.$order->ktp_photo) }}"
                            class="rounded-lg border border-white/10 max-h-60 object-contain"
                        >
                    </div>
                @endif

                @if($order->payment_proof)
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Bukti Pembayaran</p>
                        <img
                            src="{{ asset('storage/'.$order->payment_proof) }}"
                            class="rounded-lg border border-white/10 max-h-60 object-contain"
                        >
                    </div>
                @endif
            </div>

            {{-- STATUS --}}
            <div class="flex items-center justify-between pt-4 border-t border-white/10">

                <span class="px-4 py-1 rounded-full text-sm font-semibold
                    {{ $order->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                    {{ $order->status === 'approved' ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                    {{ $order->status === 'rejected' ? 'bg-red-500/20 text-red-400' : '' }}
                ">
                    Status: {{ ucfirst($order->status) }}
                </span>

               @if($order->status === 'pending')
    <div class="space-y-4 w-full">

        {{-- ALASAN REJECT --}}
        <div>
            <label class="text-sm text-gray-400">
                Alasan Penolakan (wajib jika reject)
            </label>

            <textarea
                wire:model.defer="reject_reason"
                rows="3"
                class="w-full mt-1 bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm
                       focus:outline-none focus:ring focus:ring-red-500/30"
                placeholder="Contoh: Bukti pembayaran tidak valid">
            </textarea>

            @error('reject_reason')
                <p class="text-xs text-red-400 mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3 justify-end">
            <button
                wire:click="approve"
                class="px-5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 font-semibold transition">
                Approve
            </button>

            <button
                wire:click="reject"
                class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 font-semibold transition">
                Reject
            </button>
        </div>
    </div>
@endif

            </div>

        </div>
    </div>
    
</div>
