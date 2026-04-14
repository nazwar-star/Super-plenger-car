<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Showroom Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen">

    <!-- FULL BACKGROUND + CENTER -->
    <div class="min-h-screen w-full
                bg-gradient-to-br from-[#050b17] via-[#0b1220] to-[#020617]
                flex items-center justify-center px-4">

        {{ $slot }}

    </div>

    @livewireScripts
</body>
</html>
