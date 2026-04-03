<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Library Catalog' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <span class="text-2xl">📖</span>
                        <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">LibPortal</span>
                    </a>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="/" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('/') ? 'border-indigo-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-medium">Catalog</a>
                        @if(auth()->check() && auth()->user()->isCustomer())
                            <a href="/customer/loans" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('customer/loans*') ? 'border-indigo-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-medium">My Loans</a>
                            <a href="/customer/orders" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('customer/orders*') ? 'border-indigo-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-medium">My Orders</a>
                        @else
                            <a href="/portal" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('portal*') ? 'border-indigo-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-medium">My Loans</a>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if(auth()->check())
                        <span class="text-sm text-slate-600 hidden md:inline">Hi, {{ auth()->user()->name }}</span>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="bg-slate-200 text-slate-700 px-4 py-2 rounded-full text-sm font-semibold hover:bg-slate-300 transition">Logout</button>
                        </form>
                    @else
                        <a href="/login" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">Login</a>
                        <a href="/register" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-full text-sm font-semibold hover:bg-slate-300 transition">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-500 text-sm">
            <p>&copy; {{ date('Y') }} LibPortal - Smart Library Management System</p>
        </div>
    </footer>
    @livewireScripts
</body>
</html>
