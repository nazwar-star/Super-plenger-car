<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            // 🔥 ambil 6 mobil dari stock
            'featuredCars' => Car::where('stock', '>', 0)
                                ->latest()
                                ->take(6)
                                ->get()
        ])->layout('layouts.app');
    }
}
