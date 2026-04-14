<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CarDetail extends Component
{
    public Car $car;

public Collection $relatedCars;

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
    $this->car = Car::with('images')->findOrFail($id);

    // mobil sejenis (brand sama, kecuali mobil ini)
    $this->relatedCars = Car::where('brand', $this->car->brand)
        ->where('id', '!=', $this->car->id)
        ->latest()
        ->take(4)
        ->get();
}



    // Rental date updated
    public function updatedStartDate() { $this->calculateRental(); }
    public function updatedEndDate() { $this->calculateRental(); }

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

    // Beli sekarang
    public function selectBuy()
    {
        $this->buy_selected = true;
        $this->rental_selected = false;
        $this->total_price = $this->car->sale_price;
        $this->dp_amount = ($this->total_price * $this->dp_percent) / 100;
        $this->show_payment = true;
    }

    // Payment method
    public function pay($method)
    {
        $this->payment_method = $method;

        if ($this->car->stock > 0) {
            $this->car->decrement('stock', 1);

            if ($this->car->stock == 0) {
                $this->car->update(['status' => 'sold']);
            }
        }

        if ($method === 'cash') {
            return redirect()->to('https://maps.app.goo.gl/LQ4c8YWrqnGsyfYy9');
        } elseif ($method === 'transfer') {
            return redirect()->to('https://wa.me/6281211530518?text=Transfer+Bank:+BANK+XYZ+NoRek+123456789+Nama+Johan');
        } elseif ($method === 'qris') {
            $this->qris_url = asset('qris/example.png');
        }

        $this->show_payment = true;
    }

    // Delete mobil (opsional)
    public function delete()
    {
        $this->car->delete();
        return redirect('/showroom');
    }

    public function render()
    {
        return view('livewire.car-detail')->layout('layouts.app');
    }
}
