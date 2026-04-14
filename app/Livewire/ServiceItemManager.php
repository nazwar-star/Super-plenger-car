<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceItem;

class ServiceItemManager extends Component
{
    use WithFileUploads;

    public $items;
    public $name;
    public $price;
    public $stock;
    public $category;
    public $image;

    public function mount()
    {
        $this->items = ServiceItem::all();
    }

    // Tambah ServiceItem baru
    public function addItem()
    {
        $this->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required|string',
            'image' => 'nullable|image|max:1024',
        ]);

        $imgPath = $this->image ? $this->image->store('service-items','public') : null;

        ServiceItem::create([
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category,
            'image' => $imgPath,
        ]);

        $this->reset(['name','price','stock','category','image']);
        $this->items = ServiceItem::all();
    }

    // Hapus ServiceItem
    public function removeItem($id)
    {
        ServiceItem::find($id)->delete();
        $this->items = ServiceItem::all();
    }

    public function render()
    {
        return view('livewire.service-item-manager');
    }
}

