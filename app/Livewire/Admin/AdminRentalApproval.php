<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\CarOrder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Service;

class AdminRentalApproval extends Component
{
    /**
     * Order yang sedang direview admin
     */
    public CarOrder $order;
    public $estimatedFinish;
    public $serviceBookings;
    public $estimatedFinishService;

    /**
     * Alasan penolakan
     */
    public string $reject_reason = '';

    /**
     * Route Model Binding
     * /admin/request/{order}
     */
    public function mount(CarOrder $order)
    {
        $this->order = $order->load('car');

        // 🔒 Cegah admin membuka order yang sudah diproses
        if ($this->order->status !== 'pending') {
            abort(403, 'Pesanan sudah diproses');
        }
    }

    /**
     * Approve pesanan
     */
    public function approve()
    {
        // 🔒 Cegah double approve
        if ($this->order->status !== 'pending') {
            return;
        }

        // ❗ Cek stok mobil
        if ($this->order->car->stock <= 0) {
            session()->flash('error', 'Stok mobil habis');
            return;
        }

        // 🔻 Kurangi stok mobil
        $this->order->car->decrement('stock', 1);

        // ✅ Update order
        $this->order->update([
            'status'       => 'approved',
            'approved_by'  => Auth::id(),   // SESUAI MODEL CarOrder
            'approved_at'  => Carbon::now(),
        ]);

        session()->flash('success', 'Pesanan berhasil disetujui');

        return redirect()->route('admin.request');
    }
    public function approveService($id)
{
    $service = Service::findOrFail($id);

    if ($service->status !== 'pending') {
        session()->flash('error', 'Service sudah diproses');
        return;
    }

    // Ambil input estimasi sesuai service ID
    $estimated = $this->estimatedFinishService[$id] ?? null;

    if (!$estimated) {
        session()->flash('error', 'Isi estimasi selesai dulu');
        return;
    }

    // Simpan ke database
    $service->update([
        'status' => 'approved',
        'estimated_finish' => $estimated
    ]);

    session()->flash('success', 'Service berhasil di approve');
}

public function finishService($id)
{
    Service::findOrFail($id)->update([
        'status' => 'done'
    ]);
}


    /**
     * Reject pesanan
     */
    public function reject()
    {
        $this->validate([
            'reject_reason' => 'required|min:5',
        ], [
            'reject_reason.required' => 'Alasan penolakan wajib diisi',
            'reject_reason.min'      => 'Alasan minimal 5 karakter',
        ]);

        $this->order->update([
            'status'        => 'rejected',
            'approved_by'   => Auth::id(),
            'reject_reason' => $this->reject_reason,
        ]);

        session()->flash('success', 'Pesanan berhasil ditolak');

        return redirect()->route('admin.request');
    }

    /**
     * Render view
     */
    public function render()
{
    $this->serviceBookings = Service::latest()->get();

    return view('livewire.admin.admin-rental-approval', [
        'serviceBookings' => $this->serviceBookings
    ]);
}

}
