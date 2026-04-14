<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (!Auth::attempt($credentials)) {
            session()->flash('error', 'Email atau password salah');
            return;
        }

        request()->session()->regenerate();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.login')
            ->layout('layouts.guest');
    }
}
