<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="h-full bg-black text-gray-100">

    <main class="min-h-full">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
