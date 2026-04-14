<div class="max-w-6xl mx-auto px-6 py-12 text-slate-100">

    <h1 class="text-2xl font-bold mb-8">
        Riwayat Pesanan Saya
    </h1>

    @forelse($orders as $order)
        <div class="bg-white/5 border border-white/10 rounded-xl p-6 mb-6">

            <div class="flex justify-between items-start gap-6">

                {{-- INFO MOBIL --}}
                <div>
                    <h2 class="text-lg font-semibold">
                        {{ $order->car->name }}
                    </h2>
                    <p class="text-sm text-gray-400">
                        {{ $order->car->brand }} • {{ $order->car->year }}
                    </p>

                    <div class="mt-3 space-y-1 text-sm text-gray-300">
                        <p>Tipe:
                            <span class="font-semibold">
                                {{ ucfirst($order->type) }}
                            </span>
                        </p>

                        <p>Pembayaran:
                            <span class="font-semibold">
                                {{ ucfirst($order->payment_method) }}
                            </span>
                        </p>

                        <p>Tanggal:
                            {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="text-right">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                        @elseif($order->status === 'approved') bg-emerald-500/20 text-emerald-400
                        @elseif($order->status === 'rejected') bg-red-500/20 text-red-400
                        @else bg-gray-500/20 text-gray-300
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </span>

                    <p class="mt-4 text-emerald-400 font-bold text-lg">
                        Rp {{ number_format($order->price,0,',','.') }}
                    </p>
                </div>

            </div>

        </div>
    @empty
        <div class="text-center text-gray-400">
            Kamu belum punya riwayat pesanan.
        </div>
    @endforelse
{{-- ================= RIWAYAT SERVICE BENGKEL ================= --}}
<h1 class="text-2xl font-bold mt-12 mb-8">
    Riwayat Service Bengkel
</h1>

@forelse($services as $service)
    <div class="bg-white/5 border border-white/10 rounded-xl p-6 mb-6">

        <div class="flex justify-between items-start gap-6">

            <div>
                <h2 class="text-lg font-semibold">
                    Service Kendaraan
                </h2>

                <div class="mt-3 space-y-1 text-sm text-gray-300">
                    <p>Nama Customer:
                        <span class="font-semibold">
                            {{ $service->customer_name }}
                        </span>
                    </p>

                    <p>Tanggal Service:
                        {{ \Carbon\Carbon::parse($service->service_date)->format('d M Y') }}
                    </p>

                    {{-- Tampilkan Estimasi Selesai --}}
                    @if($service->estimated_finish)
                        <p>Estimasi Selesai:
                            <span class="font-semibold text-emerald-400">
                                {{ \Carbon\Carbon::parse($service->estimated_finish)->format('d M Y H:i') }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>

            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($service->status === 'pending') bg-yellow-500/20 text-yellow-400
                    @elseif($service->status === 'approved') bg-emerald-500/20 text-emerald-400
                    @elseif($service->status === 'done') bg-blue-500/20 text-blue-400
                    @else bg-gray-500/20 text-gray-300
                    @endif
                ">
                    {{ ucfirst($service->status) }}
                </span>

                <p class="mt-4 text-emerald-400 font-bold text-lg">
                    Rp {{ number_format($service->total_price,0,',','.') }}
                </p>
            </div>

        </div>

    </div>
@empty
    <div class="text-center text-gray-400">
        Belum ada riwayat service.
    </div>
@endforelse


</div>
