<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\ServiceMaster;
use App\Models\Car; // model mobil showroom

class ServiceManager extends Component
{
    public $customer_name, $car_name, $plate_number, $service_date;
    public $activeServiceId = null;

    // =====================
    // MULAI SERVICE
    // =====================
    public function startService()
    {
        $this->validate([
            'customer_name' => 'required|string',
            'car_name'      => 'required|string',
            'plate_number'  => 'required|string',
            'service_date'  => 'required|date',
        ]);

        $service = Service::create([
            'customer_name' => $this->customer_name,
            'car_name'      => $this->car_name,
            'plate_number'  => $this->plate_number,
            'service_date'  => $this->service_date,
            'status'        => 'process',
            'total_price'   => 0,
        ]);

        $this->activeServiceId = $service->id;
        $this->resetForm();
        $this->recalculate();
    }

    // =====================
    // TAMBAH ITEM
    // =====================
    public function addItem($masterId)
    {
        if (!$this->activeServiceId) return;

        $master = ServiceMaster::findOrFail($masterId);

        ServiceItem::create([
            'service_id' => $this->activeServiceId,
            'item_name'  => $master->name,
            'price'      => $master->price,
        ]);

        $this->recalculate();
    }

    // =====================
    // HAPUS ITEM
    // =====================
    public function removeItem($itemId)
    {
        ServiceItem::where('id', $itemId)
            ->where('service_id', $this->activeServiceId)
            ->delete();

        $this->recalculate();
    }

    // =====================
    // HITUNG TOTAL
    // =====================
    private function recalculate()
    {
        if(!$this->activeServiceId) return;

        $total = ServiceItem::where('service_id', $this->activeServiceId)->sum('price');
        Service::where('id', $this->activeServiceId)->update(['total_price' => $total]);
    }

    // =====================
    // SELESAI SERVICE
    // =====================
    public function finishService($id)
    {
        Service::where('id', $id)->update(['status' => 'finished']);
        $this->activeServiceId = null;
    }

    // =====================
    // RESET FORM
    // =====================
    private function resetForm()
    {
        $this->customer_name = '';
        $this->car_name = '';
        $this->plate_number = '';
        $this->service_date = '';
    }

    // =====================
    // LIST SHOWROOM MOBIL
    // =====================
    public function getShowroomCarsProperty()
    {
        return Car::all(); // semua mobil showroom
    }

    // =====================
    // RIWAYAT SERVICE
    // =====================
    public function getHistoryServicesProperty()
    {
        return Service::where('status', 'finished')
            ->latest()
            ->with('items')
            ->get();
    }

    // =====================
    // RENDER
    // =====================
    public function render()
    {
        $activeService = $this->activeServiceId
            ? Service::with('items')->find($this->activeServiceId)
            : null;

        $masters = ServiceMaster::all();

        return view('livewire.service-manager', [
            'masters' => $masters,
            'activeService' => $activeService,
        ]);
    }
}
