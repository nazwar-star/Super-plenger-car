<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class CarManager extends Component
{
    use WithFileUploads;

    public $cars;
    public $name, $brand, $year;
    public $sale_price, $rental_price;
    public $stock;
    public $photo;
    public $user_role = 'guest';

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'year' => 'required|numeric',
        'sale_price' => 'required|numeric|min:1',
        'rental_price' => 'required|numeric|min:1',
        'stock' => 'required|numeric|min:0',
        'photo' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->loadCars();

        if (Auth::check()) {
            $this->user_role = Auth::user()->role;
        }
    }

    public function loadCars()
    {
        $this->cars = Car::latest()->get();
    }

    public function save()
    {
        if ($this->user_role !== 'admin') return;

        $data = $this->validate();

        if ($this->photo) {
            $data['photo'] = $this->photo->store('cars', 'public');
        }

        $data['status'] = 'available';

        Car::create($data);

        $this->resetForm();
        $this->loadCars();
    }

    public function delete($id)
    {
        if ($this->user_role !== 'admin') return;

        Car::findOrFail($id)->delete();
        $this->loadCars();
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    private function resetForm()
    {
        $this->reset([
            'name','brand','year',
            'sale_price','rental_price',
            'stock','photo'
        ]);
    }

    public function render()
    {
        return view('livewire.car-manager')
            ->layout('layouts.app');
    }
}
