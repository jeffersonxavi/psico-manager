<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Token CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PsicoManager')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e90ff',
                    }
                }
            }
        }
    </script>

    <!-- Scripts do Vite (CSS e JS do projeto) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos adicionais -->
    @stack('styles')
</head>
<body class="bg-gray-100 antialiased h-screen flex flex-col">

    <div class="flex flex-1 h-full">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-xl flex flex-col p-4 border-r">
            <div class="text-xl font-bold text-gray-800 mb-6">Clínica Ellen Nani</div>
            <nav class="flex-1 space-y-2">
                <a href="{{ route('agenda.index') }}" class="flex items-center p-3 rounded-xl bg-blue-100 text-primary font-semibold transition-colors">
                    Agenda
                </a>
                <a href="{{ route('pacientes.index') }}" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                    Pacientes
                </a>
                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                    Configurações
                </a>
            </nav>
            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center p-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                        Sair
                    </button>
                </form>
            </div>
        </aside>

        <!-- Conteúdo principal -->
        <main class="flex-1 overflow-auto p-6">
            @yield('content')    
        </main>
    </div>

    <!-- Scripts adicionais -->
    @stack('scripts')
</body>
</html>
