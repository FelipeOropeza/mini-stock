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
            <div class="flex items-center gap-6 w-full">
                <a href="{{ url('/painel') }}" class="text-lg font-bold">Painel</a>

                <nav class="hidden md:flex items-center gap-4">
                    <a href="{{ route('products') }}"
                       class="{{ request()->is('products*') ? 'text-blue-600 font-semibold' : 'text-gray-700' }} hover:underline">
                       Produtos
                    </a>
                </nav>

                <!-- Mobile menu -->
                <details class="md:hidden">
                    <summary class="cursor-pointer text-gray-700">Menu</summary>
                    <div class="flex flex-col mt-2">
                        <a href="{{ route('products') }}" class="py-1 text-gray-700 hover:underline">Produtos</a>
                    </div>
                </details>
            </div>

            <div class="flex items-center gap-4">
                <span class="w-32">{{ Auth::user()->name }}</span>

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
