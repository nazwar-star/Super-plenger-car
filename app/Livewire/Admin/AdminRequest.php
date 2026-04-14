<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Service;
use App\Models\CarOrder;
use Carbon\Carbon;

class AdminRequest extends Component
{
    public $estimatedFinishService = [];

    /**
     * Approve service dan simpan estimasi ke database
     */
    public function approveService($id)
{
    $service = Service::findOrFail($id);

    if ($service->status !== 'pending') {
        session()->flash('error', 'Service sudah diproses');
        return;
    }

    $estimated = $this->estimatedFinishService[$id] ?? null;

    if (!$estimated) {
        session()->flash('error','Isi estimasi selesai dulu');
        return;
    }

    // 🔑 Ubah format ke MySQL datetime
    $service->update([
        'status' => 'approved',
        'estimated_finish' => \Carbon\Carbon::parse($estimated)->format('Y-m-d H:i:s')
    ]);

    session()->flash('success','Service berhasil di approve');
}

    /**
     * Tandai service selesai
     */
    public function finishService($id)
    {
        $service = Service::findOrFail($id);

        if ($service->status !== 'approved') return;

        $service->update([
            'status' => 'done'
        ]);

        session()->flash('success','Service selesai');
    }

    public function render()
    {
        return view('livewire.admin.admin-request', [
            'orders' => CarOrder::latest()->get(),
            'services' => Service::latest()->get()
        ]);
    }
}
