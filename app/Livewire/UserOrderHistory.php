<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CarOrder;
use App\Models\Service;

class UserOrderHistory extends Component
{
    public function render()
    {
        $orders = CarOrder::with('car')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $services = Service::where('customer_name', Auth::user()->name)
        ->latest()
        ->get();


        return view('livewire.user-order-history', [
            'orders' => $orders,
            'services' => $services
        ]);
    }
}
