<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CarOrder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckoutCar extends Component
{
    use WithFileUploads;

    public $car;

    // ===== BASIC =====
    public $type = 'rental';
    public $payment_method;
    public $delivery_method = 'ambil_sendiri';
    public $agree = false;

    // ===== FILE =====
    public $ktp_photo;
    public $payment_proof;

    // ===== DELIVERY =====
    public $delivery_address;
    public $distance_km = 0;
    public $delivery_fee = 0;

    // ===== RENTAL =====
    public $rental_start;
    public $rental_end;
    public $rental_days = 0;

    // ===== PRICE =====
    public $base_price = 0;
    public $total_price = 0;

    /**
     * Reset field saat ganti type
     */
    public function updatedType()
    {
        if ($this->type === 'buy') {
            $this->ktp_photo = null;
            $this->rental_start = null;
            $this->rental_end = null;
            $this->rental_days = 0;
            $this->base_price = $this->car->sale_price;
        }
    }

    /**
     * Reset bukti transfer
     */
    public function updatedPaymentMethod()
    {
        if ($this->payment_method !== 'transfer') {
            $this->payment_proof = null;
        }
    }

    /**
     * HITUNG OTOMATIS
     */
    public function updated($field)
    {
        // === RENTAL ===
        if ($this->type === 'rental' && $this->rental_start && $this->rental_end) {
            $start = Carbon::parse($this->rental_start);
            $end   = Carbon::parse($this->rental_end);

            if ($end >= $start) {
                $this->rental_days = $start->diffInDays($end) + 1;
                $this->base_price = $this->rental_days * $this->car->rental_price;
            }
        }

        // === BELI ===
        if ($this->type === 'buy') {
            $this->base_price = $this->car->sale_price;
        }

        // === DELIVERY ===
        if ($this->delivery_method === 'diantar' && $this->distance_km > 5) {
            $this->delivery_fee = ($this->distance_km - 5) * 5000;
        } else {
            $this->delivery_fee = 0;
        }

        $this->total_price = $this->base_price + $this->delivery_fee;
    }

    /**
     * SUBMIT ORDER
     */
    public function submit()
    {
        $rules = [
            'type' => 'required|in:rental,buy',
            'payment_method' => 'required|in:transfer,cash',
            'delivery_method' => 'required|in:diantar,ambil_sendiri',
            'agree' => 'accepted',
        ];

        // Rental rules
        if ($this->type === 'rental') {
            $rules['ktp_photo'] = 'required|image|max:2048';
            $rules['rental_start'] = 'required|date';
            $rules['rental_end'] = 'required|date|after_or_equal:rental_start';
        }

        // Delivery rules
        if ($this->delivery_method === 'diantar') {
            $rules['delivery_address'] = 'required|string|min:5';
            $rules['distance_km'] = 'required|numeric|min:1';
        }

        // Transfer rules
        if ($this->payment_method === 'transfer') {
            $rules['payment_proof'] = 'required|image|max:2048';
        }

        $this->validate($rules);

        // Upload file
        $ktpPath = $this->ktp_photo
            ? $this->ktp_photo->store('ktp', 'public')
            : null;

        $paymentPath = $this->payment_proof
            ? $this->payment_proof->store('payments', 'public')
            : null;

        // Save order
        CarOrder::create([
            'user_id' => Auth::id(),
            'car_id' => $this->car->id,
            'type' => $this->type,
            'delivery_method' => $this->delivery_method,
            'delivery_address' => $this->delivery_address,
            'distance_km' => $this->distance_km,
            'delivery_fee' => $this->delivery_fee,
            'payment_method' => $this->payment_method,
            'ktp_photo' => $ktpPath,
            'payment_proof' => $paymentPath,
            'rental_start' => $this->rental_start,
            'rental_end' => $this->rental_end,
            'rental_days' => $this->rental_days,
            'price' => $this->base_price,
            'total_price' => $this->total_price,
            'status' => 'pending',
        ]);

        session()->flash('success', 'Pesanan berhasil dikirim, menunggu persetujuan admin');

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.checkout-car');
    }
}
