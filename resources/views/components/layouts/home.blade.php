<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()
</head>

<body class="bg-gray-100">

    @auth
        <nav class="bg-white shadow p-4 flex justify-between">
            <div>
                <h1 class="font-bold">Painel</h1>
            </div>

            <div class="flex items-center gap-4">
                <span>Olá, {{ Auth::user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-500 font-semibold hover:underline">
                        Sair
                    </button>
                </form>
            </div>
        </nav>
    @endauth

    <main class="p-6">
        {{ $slot }}
    </main>

    @livewireScripts()
</body>

</html>
