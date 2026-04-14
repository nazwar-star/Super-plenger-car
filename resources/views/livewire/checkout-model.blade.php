<div>
    @if($showModal)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-md rounded-xl p-6 text-gray-800">
                <h2 class="text-xl font-bold mb-4">Checkout Mobil</h2>

                {{-- Render CheckoutCar di sini --}}
                @livewire('checkout-car', ['carId' => $carId])

                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="close" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                </div>
            </div>
        </div>
    @endif
</div>
