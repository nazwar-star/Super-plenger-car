<div class="max-w-md mx-auto mt-12 p-6 bg-white rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-4 text-center">Login Akun</h2>

    @if(session()->has('error'))
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- FORM WAJIB --}}
    <form wire:submit.prevent="login" class="space-y-4">

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

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full"
        >
            Login
        </button>

    </form>

    <p class="mt-4 text-center text-sm text-gray-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600">Daftar di sini</a>
    </p>
</div>
