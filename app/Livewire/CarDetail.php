<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use Carbon\Carbon;

class CarDetail extends Component
{
    public Car $car;

    // Rental
    public $start_date;
    public $end_date;
    public $total_days = 0;
    public $total_price = 0;
    public $dp_percent = 30;
    public $dp_amount = 0;

    // Mode
    public $buy_selected = false;
    public $rental_selected = false;
    public $show_payment = false;
    public $payment_method;
    public $qris_url;

    public function mount($id)
    {
        $this->car = Car::findOrFail($id);
    }

    // Hitung rental
    public function updatedStartDate()
    {
        $this->calculateRental();
    }

    public function updatedEndDate()
    {
        $this->calculateRental();
    }

    private function calculateRental()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end   = Carbon::parse($this->end_date);

            if ($end >= $start) {
                $this->total_days = $start->diffInDays($end) + 1;
                $this->total_price = $this->total_days * $this->car->rental_price;
                $this->dp_amount = ($this->total_price * $this->dp_percent) / 100;
                $this->rental_selected = true;
                $this->buy_selected = false;
                $this->show_payment = true;
            } else {
                $this->resetRental();
            }
        } else {
            $this->resetRental();
        }
    }

    private function resetRental()
    {
        $this->total_days = 0;
        $this->total_price = 0;
        $this->dp_amount = 0;
        $this->rental_selected = false;
        $this->show_payment = false;
    }

    public function selectBuy()
    {
        $this->buy_selected = true;
        $this->rental_selected = false;
        $this->show_payment = true;
    }

    public function pay($method)
    {
        $this->payment_method = $method;

        if ($method === 'cash') {
            // Cash: buka lokasi bengkel
            return redirect()->to('https://maps.app.goo.gl/7zp2LEHnAiPqR1ha9');
        } elseif ($method === 'transfer') {
            // Transfer: arahkan ke WA + info bank
            return redirect()->to('https://wa.me/6281234567890?text=Transfer+Bank:+BANK+XYZ+NoRek+123456789+Nama+Johan');
        } elseif ($method === 'qris') {
            // QRIS: tampil gambar QRIS
            $this->qris_url = asset('qris/example.png'); // letakkan file QRIS di public/qris/example.png
        }

        // Update stok
        if($this->rental_selected && $this->car->stock > 0) {
            $this->car->decrement('stock', 1);
        } elseif($this->buy_selected && $this->car->stock > 0) {
            $this->car->decrement('stock', 1);
        }

        if ($this->car->stock == 0) {
            $this->car->update(['status' => 'sold']);
        }
    }

    public function delete()
    {
        $this->car->delete();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.car-detail')->layout('layouts.app');
    }
}
