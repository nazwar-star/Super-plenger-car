<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            // 🔥 cuma buat perkenalan
            'cars' => Car::latest()->take(3)->get(),
        ]);
    }
}
