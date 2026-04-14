<?php

namespace App\Livewire;

use Livewire\Component;

class CheckoutModal extends Component
{
    public $showModal = false;
    public $carId;

    protected $listeners = ['openCheckoutModal'];

    public function openCheckoutModal($carId)
    {
        $this->carId = $carId;
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.checkout-modal');
    }
}
