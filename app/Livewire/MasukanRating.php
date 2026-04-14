<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Masukan;
use Illuminate\Support\Facades\Auth;

class MasukanRating extends Component
{
    public $nama;
    public $pesan;
    public $rating;

    public $masukans;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'pesan' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ];

    public function mount()
    {
        // auto isi nama dari user login (opsional tapi bagus)
        $this->nama = Auth::user()->name;

        // ambil data masukan
        $this->masukans = Masukan::latest()->get();
    }

    public function submit()
    {
        $this->validate();

        Masukan::create([
            'nama' => $this->nama,
            'email' => Auth::user()->email, // 🔥 auto dari login
            'pesan' => $this->pesan,
            'rating' => $this->rating,
        ]);

        // reset (nama tidak direset biar tetap dari user)
        $this->pesan = '';
        $this->rating = '';

        // refresh data
        $this->masukans = Masukan::latest()->get();

        session()->flash('message', 'Terima kasih! Masukan Anda telah dikirim.');
    }

    public function render()
    {
        return view('livewire.masukan-rating');
    }
}