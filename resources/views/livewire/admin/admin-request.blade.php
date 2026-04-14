<div class="min-h-screen bg-gradient-to-br from-[#050b17] via-[#0b1220] to-[#020617] text-slate-100">

    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold">Request Pengguna</h1>
            <p class="text-sm text-gray-400">
                Daftar permintaan rental & service bengkel
            </p>
        </div>

        {{-- LIST ORDER --}}
        <div class="grid gap-5">
            @forelse ($orders as $order)
                <div class="bg-white/5 border border-white/10 rounded-xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    {{-- INFO --}}
                    <div class="space-y-1">
                        <p class="font-semibold text-lg">{{ $order->car->name }}</p>
                        <p class="text-sm text-gray-400">
                            {{ $order->user->name }} • 
                            {{ ucfirst($order->type) }} • 
                            {{ ucfirst($order->payment_method) }}
                        </p>
                        <p class="text-sm">
                            Harga: <span class="text-emerald-400 font-semibold">
                                Rp {{ number_format($order->price,0,',','.') }}
                            </span>
                        </p>
                    </div>

                    {{-- STATUS --}}
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $order->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                            {{ $order->status === 'approved' ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                            {{ $order->status === 'rejected' ? 'bg-red-500/20 text-red-400' : '' }}
                        ">
                            {{ ucfirst($order->status) }}
                        </span>

                        <a href="{{ route('admin.request.approval', $order->id) }}"
                           class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-sm font-semibold transition">
                            Detail
                        </a>
                    </div>

                </div>
            @empty
                <div class="text-center py-16 text-gray-400">
                    Belum ada request masuk
                </div>
            @endforelse
        </div>

       <h2 class="text-2xl font-bold text-emerald-400 mt-10 mb-6">
    Booking Service Bengkel
</h2>

<div class="mt-6 space-y-4">
    @foreach($services as $service)
        <div class="bg-[#0b1220] border border-gray-800 rounded-2xl p-5 flex justify-between items-start">

            {{-- INFO --}}
            <div>
                <p class="text-white font-semibold">{{ $service->customer_name }}</p>
                <p class="text-gray-400 text-sm">Tanggal: {{ $service->service_date }}</p>
                <p class="text-emerald-400 font-bold mt-2">Rp {{ number_format($service->total_price,0,',','.') }}</p>

                {{-- STATUS --}}
                @php
                    $statusClass = match($service->status) {
                        'pending' => 'bg-yellow-500/20 text-yellow-400',
                        'approved' => 'bg-emerald-500/20 text-emerald-400',
                        'done' => 'bg-blue-500/20 text-blue-400',
                        default => '',
                    };
                @endphp
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                    {{ ucfirst($service->status) }}
                </span>

                {{-- ESTIMASI --}}
                @if($service->estimated_finish)
                    <p class="text-sm text-emerald-400 mt-2">
                        Estimasi selesai: {{ \Carbon\Carbon::parse($service->estimated_finish)->format('d M Y H:i') }}
                    </p>
                @endif
            </div>

            {{-- ACTION --}}
            <div class="flex flex-col gap-2 w-56">
                {{-- INPUT & APPROVE --}}
                @if($service->status === 'pending')
                    <input type="datetime-local"
       wire:model="estimatedFinishService.{{ $service->id }}"
       class="bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm">

<button wire:click="approveService({{ $service->id }})"
        class="px-4 py-2 bg-emerald-600 rounded-lg hover:bg-emerald-700 font-semibold">
    Approve
</button>

                @endif

                {{-- TANDAI SELESAI --}}
                @if($service->status === 'approved')
                    <button wire:click="finishService({{ $service->id }})"
                            class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 font-semibold">
                        Tandai Selesai
                    </button>
                @endif
            </div>

        </div>
    @endforeach
</div>




    </div>
</div>
