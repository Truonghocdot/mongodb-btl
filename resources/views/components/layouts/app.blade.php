<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Library CRM' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 text-gray-900 font-sans antialiased">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-indigo-700 text-white flex-shrink-0">
                <div class="p-6 text-2xl font-bold border-b border-indigo-600">
                    Library CRM
                </div>
                <nav class="mt-6 flex-1 px-4 space-y-2">
                    <a href="/dashboard" class="flex items-center p-3 rounded-lg hover:bg-indigo-600 {{ request()->is('dashboard') ? 'bg-indigo-600' : '' }}">
                        <span class="mr-3">📊</span> Dashboard
                    </a>
                    <a href="/books" class="flex items-center p-3 rounded-lg hover:bg-indigo-600 {{ request()->is('books*') ? 'bg-indigo-600' : '' }}">
                        <span class="mr-3">📚</span> Books
                    </a>
                    <a href="/categories" class="flex items-center p-3 rounded-lg hover:bg-indigo-600 {{ request()->is('categories*') ? 'bg-indigo-600' : '' }}">
                        <span class="mr-3">📁</span> Categories
                    </a>
                    <a href="/members" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->is('members*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-indigo-50 text-gray-600' }} transition">
                    <span class="text-xl">👥</span>
                    <span class="font-medium">Members</span>
                </a>
                <a href="/reservations" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->is('reservations*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-indigo-50 text-gray-600' }} transition">
                    <span class="text-xl">🔔</span>
                    <span class="font-medium">Reservations</span>
                </a>
                <a href="/loans" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->is('loans*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-indigo-50 text-gray-600' }} transition">
                        <span class="mr-3">📑</span> Loans
                    </a>
                <a href="/fines" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->is('fines*') ? 'bg-indigo-600 text-white shadow-md' : 'hover:bg-indigo-50 text-gray-600' }} transition">
                    <span class="text-xl">💸</span>
                    <span class="font-medium">Fines</span>
                </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col overflow-y-auto">
                <header class="bg-white shadow-sm p-4">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-semibold">{{ $title ?? 'Dashboard' }}</h1>
                        <div class="text-gray-500">Welcome, User</div>
                    </div>
                </header>
                <div class="p-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
        @livewireScripts
    </body>
</html>
