<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Car;

class CarAdmin extends Component
{
    use WithFileUploads;

    public $cars;

    // form
    public $car_id;
    public $name, $brand, $year;
    public $rental_price, $sale_price, $stock;
    public $photo;

    public $isEdit = false;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'year' => 'required|numeric',
        'rental_price' => 'required|numeric',
        'sale_price' => 'required|numeric',
        'stock' => 'required|numeric',
    ];

    public function mount()
    {
        $this->loadCars();
    }

    public function loadCars()
    {
        $this->cars = Car::latest()->get();
    }

    // ==================
    // TAMBAH MOBIL
    // ==================
    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->photo) {
            $path = $this->photo->store('cars', 'public');
        }

        Car::create([
            'name' => $this->name,
            'brand' => $this->brand,
            'year' => $this->year,
            'rental_price' => $this->rental_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'photo' => $path,
        ]);

        $this->resetForm();
        $this->loadCars();
    }

    // ==================
    // EDIT
    // ==================
    public function edit($id)
    {
        $car = Car::findOrFail($id);

        $this->car_id = $car->id;
        $this->name = $car->name;
        $this->brand = $car->brand;
        $this->year = $car->year;
        $this->rental_price = $car->rental_price;
        $this->sale_price = $car->sale_price;
        $this->stock = $car->stock;

        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        $car = Car::findOrFail($this->car_id);

        if ($this->photo) {
            $car->photo = $this->photo->store('cars', 'public');
        }

        $car->update([
            'name' => $this->name,
            'brand' => $this->brand,
            'year' => $this->year,
            'rental_price' => $this->rental_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
        ]);

        $this->resetForm();
        $this->loadCars();
    }

    // ==================
    // HAPUS
    // ==================
    public function delete($id)
    {
        Car::findOrFail($id)->delete();
        $this->loadCars();
    }

    private function resetForm()
    {
        $this->reset([
            'car_id', 'name', 'brand', 'year',
            'rental_price', 'sale_price', 'stock',
            'photo', 'isEdit'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.car-admin')
            ->layout('layouts.app');
    }
}
