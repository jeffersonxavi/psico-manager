<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- O token CSRF é vital para submissão de formulários no Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Aplicação Laravel')</title>

    <!-- Tailwind CSS CDN - Necessário para o estilo do seu calendário -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e90ff', // Cor Azul para os destaques
                    }
                }
            }
        }
    </script>

    <!-- Aqui serão injetados os estilos do FullCalendar (@push('styles') no index.blade.php) -->
    @stack('styles')
</head>
<body class="bg-gray-100 antialiased h-screen flex flex-col">
    <!-- BARRA LATERAL (Mockup simples da imagem) -->
    <div class="flex flex-1 h-full">
        <aside class="w-64 bg-white shadow-xl flex flex-col p-4 border-r">
            <div class="text-xl font-bold text-gray-800 mb-6">PsicoManager</div>
            <nav class="flex-1 space-y-2">
                <a href="#" class="flex items-center p-3 rounded-xl bg-blue-100 text-primary font-semibold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Agenda
                </a>
                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-1.666 0-5.333 1.333-5.333 4v2h10.666v-2c0-2.667-3.667-4-5.333-4z" /></svg>
                    Pacientes
                </a>
                <a href="#" class="flex items-center p-3 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.228.093 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Configurações
                </a>
            </nav>
            <div class="mt-auto">
                <a href="#" class="flex items-center p-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Sair
                </a>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL (A agenda será injetada aqui) -->
        <main class="flex-1 overflow-auto">
            @yield('content')
        </main>
    </div>

    <!-- Scripts globais e específicos da página serão injetados aqui (FullCalendar e JS customizado) -->
    @stack('scripts')
</body>
</html>