<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarManager extends Component
{
    use WithFileUploads;

    public $cars;
    public $brands = [];

    public $car_id;
    public $isEdit = false;

    public $name;
    public $brand;
    public $year;
    public $rental_price;
    public $sale_price;
    public $stock;

    public $photo;
    public $images = [];
    public $existingImages = []; // gallery lama

    public $description;
    public $youtube_url;
    public $options = '';

    public $brandFilter = '';
    public $user_role = 'guest';
    public $showSold = false;
    protected $rules = [
        'name' => 'required|string',
        'brand' => 'required|string',
        'year' => 'required|numeric',
        'rental_price' => 'required|numeric|min:1',
        'sale_price' => 'required|numeric|min:1',
        'stock' => 'required|numeric|min:0',
        'photo' => 'nullable|image|max:2048',
        'images.*' => 'image|max:2048',
        'description' => 'nullable|string',
        'youtube_url' => 'nullable|string',
        'options' => 'nullable|string',
    ];

    public function mount()
    {
        $this->user_role = Auth::check() ? strtolower(Auth::user()->role) : 'guest';
        $this->loadData();
    }

    public function loadData()
{
    $this->brands = Car::select('brand')
        ->distinct()
        ->orderBy('brand')
        ->pluck('brand')
        ->toArray();

    $query = Car::query();

    if ($this->brandFilter) {
        $query->where('brand', $this->brandFilter);
    }

    if ($this->showSold) {
        $query->where('stock', 0);
    }

    $this->cars = $query->latest()->get();
}

public function updatedShowSold()
{
    $this->loadData();
}


    public function updatedBrandFilter()
    {
        $this->loadData();
    }

    public function save()
    {
        if ($this->user_role !== 'admin') return;

        $this->validate();

        $car = $this->isEdit ? Car::findOrFail($this->car_id) : new Car();

        $car->fill([
            'name' => $this->name,
            'brand' => $this->brand,
            'year' => $this->year,
            'rental_price' => $this->rental_price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'description' => $this->description,
            'youtube_url' => $this->youtube_url,
        ]);

        if ($this->photo) {
            if ($this->isEdit && $car->photo) {
                Storage::disk('public')->delete($car->photo);
            }
            $car->photo = $this->photo->store('cars', 'public');
        }

        $car->save();

        // OPTIONS
        CarOption::where('car_id', $car->id)->delete();
        foreach(array_filter(explode("\n", $this->options)) as $opt){
            CarOption::create([
                'car_id' => $car->id,
                'option' => trim($opt),
            ]);
        }

        // GALLERY baru
        foreach($this->images as $img){
            CarImage::create([
                'car_id' => $car->id,
                'image_path' => $img->store('cars/gallery', 'public'),
            ]);
        }

        $this->resetForm();
        $this->loadData();
    }

    public function edit($id)
    {
        if ($this->user_role !== 'admin') return;

        $car = Car::with(['options','images'])->findOrFail($id);

        $this->car_id = $car->id;
        $this->name = $car->name;
        $this->brand = $car->brand;
        $this->year = $car->year;
        $this->rental_price = $car->rental_price;
        $this->sale_price = $car->sale_price;
        $this->stock = $car->stock;
        $this->description = $car->description;
        $this->youtube_url = $car->youtube_url;
        $this->options = $car->options->pluck('option')->implode("\n");

        $this->existingImages = $car->images->map(fn($img) => [
            'id' => $img->id,
            'path' => $img->image_path,
        ])->toArray();

        $this->isEdit = true;
    }

    // Hapus gambar gallery lama
    public function removeExistingImage($id)
    {
        $img = CarImage::find($id);
        if(!$img) return;

        Storage::disk('public')->delete($img->image_path);
        $img->delete();

        $this->existingImages = array_filter($this->existingImages, fn($i) => $i['id'] != $id);
    }

    // HAPUS mobil langsung tanpa konfirmasi
    public function delete($id)
    {
        if ($this->user_role !== 'admin') return;

        $car = Car::with('images')->find($id);
        if(!$car) return;

        if($car->photo) Storage::disk('public')->delete($car->photo);

        foreach($car->images as $img){
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        $car->delete();

        $this->loadData();
    }

    private function resetForm()
    {
        $this->reset([
            'car_id','isEdit',
            'name','brand','year',
            'rental_price','sale_price','stock',
            'description','options','youtube_url',
            'photo','images','existingImages',
        ]);
    }

    public function render()
    {
        return view('livewire.car-manager');
    }
}
