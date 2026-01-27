<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarManager extends Component
{
    use WithFileUploads;

    public $cars;

    public $name;
    public $brand;
    public $year;
    public $rental_price;
    public $sale_price;
    public $stock;
    public $photo;

    public $user_role = 'guest';

    protected $rules = [
        'name' => 'required|string',
        'brand' => 'required|string',
        'year' => 'required|numeric',
        'rental_price' => 'required|numeric|min:1',
        'sale_price' => 'required|numeric|min:1',
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
        if ($this->user_role !== 'admin') {
            return;
        }

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
        if ($this->user_role !== 'admin') {
            return;
        }

        $car = Car::findOrFail($id);

        if ($car->photo && Storage::disk('public')->exists($car->photo)) {
            Storage::disk('public')->delete($car->photo);
        }

        $car->delete();
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
            'name',
            'brand',
            'year',
            'rental_price',
            'sale_price',
            'stock',
            'photo',
        ]);
    }

    public function render()
    {
        return view('livewire.car-manager', [
            'cars' => Car::latest()->get(),
        ]);
    }
}
