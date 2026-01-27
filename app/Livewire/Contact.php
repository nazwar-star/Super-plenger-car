<?php

namespace App\Livewire;

use Livewire\Component;

class Contact extends Component
{
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name'    => 'required|min:3',
        'email'   => 'required|email',
        'message' => 'required|min:5',
    ];

    public function send()
    {
        $this->validate();

        // sementara tampilkan sukses (nanti bisa kirim WA / email)
        session()->flash('success', 'Pesan berhasil dikirim ke owner');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact')->layout('layouts.app');
    }
}
