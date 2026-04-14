<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ServiceMaster;

class ServiceMasterManager extends Component
{
    public $service_name, $description, $price, $service_id;
    public $services;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->services = ServiceMaster::all();
    }

    public function render()
    {
        return view('livewire.service-master-manager');
    }

    public function saveService()
    {
        if(auth()->user()->role !== 'admin') return;

        $this->validate();

        ServiceMaster::updateOrCreate(
            ['id' => $this->service_id],
            [
                'service_name' => $this->service_name,
                'description' => $this->description,
                'price' => $this->price,
            ]
        );

        $this->resetForm();
        $this->services = ServiceMaster::all();
    }

    public function editService($id)
    {
        if(auth()->user()->role !== 'admin') return;

        $service = ServiceMaster::findOrFail($id);
        $this->service_id = $service->id;
        $this->service_name = $service->service_name;
        $this->description = $service->description;
        $this->price = $service->price;
    }

    public function deleteService($id)
    {
        if(auth()->user()->role !== 'admin') return;

        ServiceMaster::findOrFail($id)->delete();
        $this->services = ServiceMaster::all();
    }

    public function resetForm()
    {
        $this->reset(['service_name', 'description', 'price', 'service_id']);
    }
}
