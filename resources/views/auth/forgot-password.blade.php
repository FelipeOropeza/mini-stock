@section('title', 'Recuperar senha')
@vite(['resources/css/app.css', 'resources/js/app.js'])


<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Esqueci a senha</h2>
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-700 fade-out">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-700 fade-out">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                        class="appearance-none block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $errors->has('email') ? 'border-red-500 bg-red-50 border-fade' : 'border-gray-300' }}" />
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600 fade-out">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline">Voltar ao login</a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Enviar
                    link de recuperação</button>
            </div>
        </form>
    </div>
</div>
