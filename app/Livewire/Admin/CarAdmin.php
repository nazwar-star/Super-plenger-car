<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Car;

class CarAdmin extends Component
{
    use WithFileUploads;

    public $name, $brand, $year, $rental_price, $sale_price, $stock, $photo;

    public function save()
    {
        $this->validate([
            'name'          => 'required',
            'brand'         => 'required',
            'year'          => 'required|numeric',
            'rental_price'  => 'required|numeric',
            'sale_price'    => 'nullable|numeric',
            'stock'         => 'required|numeric',
            'photo'         => 'nullable|image|max:2048',
        ]);

        $path = $this->photo
            ? $this->photo->store('cars', 'public')
            : null;

        Car::create([
            'name'          => $this->name,
            'brand'         => $this->brand,
            'year'          => $this->year,
            'rental_price'  => $this->rental_price,
            'sale_price'    => $this->sale_price,
            'stock'         => $this->stock,
            'photo'         => $path,
        ]);

        session()->flash('success', 'Mobil berhasil ditambahkan');
        $this->reset();
    }

    public function delete($id)
    {
        Car::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.car-admin', [
            'cars' => Car::latest()->get(),
        ]);
    }
}
