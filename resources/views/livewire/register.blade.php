<div class="max-w-md mx-auto mt-12 p-6 bg-white rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-4 text-center">Daftar Akun Baru</h2>

    @if(session()->has('error'))
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- FORM WAJIB --}}
    <form wire:submit.prevent="register" class="space-y-4">

        <input
            type="text"
            wire:model.defer="name"
            placeholder="Nama"
            class="border rounded p-2 w-full"
        >

        <input
            type="email"
            wire:model.defer="email"
            placeholder="Email"
            class="border rounded p-2 w-full"
        >

        <input
            type="password"
            wire:model.defer="password"
            placeholder="Password"
            class="border rounded p-2 w-full"
        >

        <input
            type="password"
            wire:model.defer="password_confirmation"
            placeholder="Konfirmasi Password"
            class="border rounded p-2 w-full"
        >

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full"
        >
            Daftar
        </button>

    </form>

    <p class="mt-4 text-center text-sm text-gray-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-600">Login di sini</a>
    </p>
</div>
