<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServiceItem;
use App\Models\ServiceMaster;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceManager extends Component
{
    use WithFileUploads;

    // ==================== PROPERTIES ====================
    public $activeTab = 'bengkel';

    // Service Item
    public $item_name, $category, $price, $stock, $item_id, $image;
    public $serviceItems;

    // Service Master / Jasa
    public $service_name, $service_price, $service_id;
    public $services;

    // Keranjang
    public $cartData = [];
    public $showCart = false;
    public $serviceType = null;
    public $selectedServiceMaster;
    public $serviceDate, $serviceTime;

    // ==================== VALIDATION ====================
    protected $rules = [
        'item_name' => 'required|string',
        'category' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:1024',

        'service_name' => 'required|string',
        'service_price' => 'required|numeric|min:0',
    ];

    // ==================== MOUNT ====================
    public function mount()
    {
        $this->serviceItems = ServiceItem::where('stock','>',0)->get();
        $this->services = ServiceMaster::all();
    }

    public function render()
    {
        return view('livewire.service-manager');
    }

    // ==================== SERVICE ITEM METHODS ====================
    public function saveItem()
    {
        if(auth()->user()->role !== 'admin') return;

        $this->validate([
        'item_name' => 'required|string',
        'category' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:1024',
    ]);

        // Upload image jika ada
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('service-items', 'public');
        }

        ServiceItem::updateOrCreate(
            ['id' => $this->item_id],
            [
                'item_name' => $this->item_name,
                'category' => $this->category,
                'price' => $this->price,
                'stock' => $this->stock,
                'image' => $imagePath ?? ($this->item_id ? ServiceItem::find($this->item_id)->image : null)
            ]
        );

        $this->resetForm();
        $this->serviceItems = ServiceItem::where('stock','>',0)->get();

    }

    public function editItem($id)
    {
        $item = ServiceItem::findOrFail($id);
        $this->item_id = $item->id;
        $this->item_name = $item->item_name;
        $this->category = $item->category;
        $this->price = $item->price;
        $this->stock = $item->stock;
        $this->image = null;
    }

    public function deleteItem($id)
    {
        ServiceItem::findOrFail($id)->delete();
        $this->serviceItems = ServiceItem::where('stock','>',0)->get();

    }

    // ==================== SERVICE MASTER METHODS ====================
    public function saveService()
    {
        if(auth()->user()->role !== 'admin') return;
        $this->validate([
            'service_name' => 'required|string',
            'service_price' => 'required|numeric|min:0',
            
        ]);


        ServiceMaster::updateOrCreate(
            ['id' => $this->service_id],
            [
                'name' => $this->service_name,
                'price' => $this->service_price,
            ]
        );

        $this->resetForm();
        $this->services = ServiceMaster::all();
        
    }

    public function editService($id)
    {
        $s = ServiceMaster::findOrFail($id);
        $this->service_id = $s->id;
        $this->service_name = $s->name;
        $this->service_price = $s->price;

    }

    public function deleteService($id)
    {
        ServiceMaster::findOrFail($id)->delete();
        $this->services = ServiceMaster::all();
    }

    // ==================== CART METHODS ====================
    public function addToCart($itemId)
    {
        $item = ServiceItem::findOrFail($itemId);

        if(isset($this->cartData[$itemId])){
            $this->cartData[$itemId]['qty'] += 1;
        } else {
            $this->cartData[$itemId] = [
                'name' => $item->item_name,
                'price' => $item->price,
                'qty' => 1
            ];
        }
    }
    public function addServiceToCart($serviceId)
{
    $service = ServiceMaster::findOrFail($serviceId);

    $key = 'service_'.$serviceId;

    if(isset($this->cartData[$key])){
        $this->cartData[$key]['qty'] += 1;
    } else {
        $this->cartData[$key] = [
            'name' => $service->name,
            'price' => $service->price,
            'qty' => 1,
            'type' => 'service'
        ];
    }
}


    public function removeFromCart($itemId)
    {
        if(isset($this->cartData[$itemId])){
            unset($this->cartData[$itemId]);
        }
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach($this->cartData as $item){
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    public function checkoutCart()
{
    if(empty($this->cartData)) return;

    Service::create([
    'customer_name' => auth()->user()->name,

    // WAJIB karena DB kamu minta
    'car_name' => 'Service Bengkel',
    'plate_number' => '-',

    'service_type' => $this->serviceType,
    'service_master_id' => $this->selectedServiceMaster,

    'service_date' => $this->serviceDate ?? now(),
    'service_time' => $this->serviceTime,

    'total_price' => $this->calculateTotal(),
    'status' => 'pending',
]);


    $this->cartData = [];
    $this->showCart = false;

    session()->flash('success', 'Booking service berhasil, menunggu persetujuan admin.');
}
    // ==================== RESET FORM ====================
    public function resetForm()
    {
        $this->reset([
            'item_name','category','price','stock','item_id','image',
            'service_name','service_price','service_id'
        ]);
    }
}
