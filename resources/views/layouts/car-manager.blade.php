<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Car Manager</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-950 text-gray-100 flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gray-900 border-r border-gray-800">
        <div class="p-6 text-xl font-bold">
            Car Manager
        </div>

        <nav class="px-4 space-y-2">
            <a href="{{ route('car.home') }}" class="block px-4 py-2 rounded hover:bg-gray-800">Home</a>
            <a href="{{ route('car.stock') }}" class="block px-4 py-2 rounded hover:bg-gray-800">Stock</a>
            <a href="{{ route('car.bengkel') }}" class="block px-4 py-2 rounded hover:bg-gray-800">Bengkel</a>
            <a href="{{ route('car.contact') }}" class="block px-4 py-2 rounded hover:bg-gray-800">Contact</a>
        </nav>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</body>
</html>
