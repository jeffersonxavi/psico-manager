<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Clínica Ellen Nani')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .brain-icon::before {
            content: "\f21e";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f94d4',
                        'primary-light': '#8ac4f2',
                        'primary-dark': '#3a79b8',
                        'sky-50': '#f5f8ff',
                        'sky-100': '#e6f0ff',
                        danger: '#ef4444'
                    },
                    boxShadow: {
                        sidebar: '0 0 40px -8px rgba(58,121,184,.1)',
                        header: '0 4px 12px -5px rgba(0,0,0,.1)'
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<!-- Marca d'água super suave – canto inferior direito -->
<div class="fixed bottom-4 right-4 z-50 pointer-events-none">
    <a href="https://jeffersonxavi.github.io/portfolio"
        target="_blank"
        class="pointer-events-auto inline-flex items-center gap-2 bg-white/70 backdrop-blur-md text-gray-500 hover:text-primary text-[11px] font-medium px-3 py-1.5 rounded-full shadow-sm border border-gray-200/50 hover:border-primary/30 hover:bg-white/90 hover:shadow-md transition-all duration-500">

        <i class="fas fa-laptop-code text-[10px] opacity-70 group-hover:opacity-100 transition-opacity"></i>
        <span class="opacity-80 group-hover:opacity-100 transition-opacity">
            por <span class="font-semibold text-primary">Jefferson X.</span>
        </span>
    </a>
</div>

<body class="bg-gradient-to-br from-sky-50 via-white to-sky-50 min-h-screen flex">

    <aside class="w-64 bg-sky-100 border-r border-sky-200 shadow-sidebar rounded-r-3xl flex flex-col h-screen sticky top-0">

        <div class="p-8 text-center border-b border-sky-200 bg-white">
            <div class="flex items-center justify-center gap-1">
                <!-- Imagem cérebro -->
                <img
                    src="{{ asset('images/cerebro.png') }}"
                    alt="Cérebro humano"
                    class="w-14 h-14 object-contain"
                >
                <h1 class="text-3xl font-semibold text-primary-dark whitespace-nowrap leading-none">
                    Ellen Nani
                </h1>
            </div>

            <p class="text-xs text-primary-dark/60 mt-2 tracking-widest uppercase">
                Psicologia &amp; Bem-estar
            </p>
        </div>

        <!-- Navegação (Utilizando font-medium e borda lateral limpa) -->
        <nav class="flex-1 px-4 py-8 space-y-2.5">
            <!-- Contraste do título melhorado -->
            <p class="px-3 text-xs font-bold text-primary-dark/60 uppercase tracking-widest mb-4">Gestão Clínica</p>

            <!-- Agenda (Estado ativo limpo: fundo branco, sombra sutil e borda lateral forte) -->
            <a href="{{ route('agenda.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-300 {{ 
                        request()->routeIs('agenda.*') 
                        ? 'bg-white text-primary-dark shadow-item-active border-l-4 border-primary' 
                        : 'text-text-default hover:bg-white/80 hover:text-primary-dark/80' 
                    }}">
                <!-- Ícone com cor mais viva -->
                <i class="fas fa-calendar-alt w-5 h-5 mr-3 {{ request()->routeIs('agenda.*') ? 'text-primary-dark' : 'text-primary-dark/50' }}"></i>
                <span>Agenda</span>
                <!-- Indicador de ativo mais sutil -->
                <span class="ml-auto text-xs {{ request()->routeIs('agenda.*') ? 'opacity-100' : 'opacity-0' }} transition-opacity">
                    <i class="fas fa-dot-circle text-primary text-xs"></i>
                </span>
            </a>

            <!-- Pacientes (Estado ativo limpo: fundo branco, sombra sutil e borda lateral forte) -->
            <a href="{{ route('pacientes.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-300 {{ 
                        request()->routeIs('pacientes.*') 
                        ? 'bg-white text-primary-dark shadow-item-active border-l-4 border-primary' 
                        : 'text-text-default hover:bg-white/80 hover:text-primary-dark/80' 
                    }}">
                <!-- Ícone com cor mais viva -->
                <i class="fas fa-users w-5 h-5 mr-3 {{ request()->routeIs('pacientes.*') ? 'text-primary-dark' : 'text-primary-dark/50' }}"></i>
                <span>Pacientes</span>
                <!-- Indicador de ativo mais sutil -->
                <span class="ml-auto text-xs {{ request()->routeIs('pacientes.*') ? 'opacity-100' : 'opacity-0' }} transition-opacity">
                    <i class="fas fa-dot-circle text-primary text-xs"></i>
                </span>
            </a>
        </nav>
        <div class="mt-auto p-4 border-t border-sky-200 bg-white/70">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-4 py-2.5 text-danger font-medium rounded-xl hover:bg-danger/10 transition">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">

        <header class="h-20 flex items-center justify-between px-8 bg-white/95 backdrop-blur-sm border-b border-sky-200 shadow-header sticky top-0 z-10">
            <div class="text-2xl font-extrabold text-slate-800">
                @yield('pageTitle', 'Sistema')
            </div>

            <div class="flex items-center gap-4">
                <button class="text-slate-500 hover:text-primary p-2 rounded-full hover:bg-sky-100/50">
                    <i class="fas fa-bell"></i>
                </button>

                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary-dark border border-primary-dark/30">
                    <i class="fas fa-user-circle text-xl"></i>
                </div>
            </div>
        </header>

        <div class="p-8">
            @yield('content')
        </div>

    </main>

    @stack('scripts')
</body>

</html>