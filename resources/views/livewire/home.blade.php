<div>
    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-rose-100 border-l-4 border-rose-500 text-rose-700 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Discover Your Next Favorite Book</h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">Browse through our extensive collection of books across various genres. Check availability and start reading today.</p>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4 mb-10">
        <div class="flex-grow relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">🔍</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by title, author, or ISBN..." class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
        </div>
        <div class="md:w-64">
            <select wire:model.live="category_id" class="w-full h-full py-3 px-4 rounded-xl border border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 outline-none appearance-none bg-no-repeat bg-right transition" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2364748b%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22/%3E%3C/svg%3E'); background-size: 12px; padding-right: 40px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($books as $book)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-50 group flex flex-col h-full">
                <!-- Book Cover Placeholder -->
                <a href="/books/{{ $book->id }}" class="h-64 bg-slate-100 flex items-center justify-center relative overflow-hidden">
                    <span class="text-6xl group-hover:scale-110 transition duration-500">📖</span>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $book->quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $book->quantity > 0 ? 'Available' : 'Out of stock' }}
                        </span>
                    </div>
                </a>
                <!-- Content -->
                <div class="p-6 flex flex-col flex-grow">
                    <div class="mb-2">
                        <span class="px-2 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase rounded tracking-wider">
                            {{ $book->category->name ?? 'Mixed' }}
                        </span>
                    </div>
                    <a href="/books/{{ $book->id }}" class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition leading-tight mb-1 inline-block">{{ $book->title }}</a>
                    <p class="text-slate-500 text-sm mb-4">by {{ $book->author }}</p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-medium italic">ISBN: {{ $book->isbn }}</span>
                        @if($book->quantity > 0)
                            <button wire:click="reserve('{{ $book->id }}')" class="text-sm font-bold text-indigo-600 hover:text-indigo-700">Reserve →</button>
                        @else
                            <span class="text-sm font-bold text-slate-300 cursor-not-allowed">Unavailable</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="text-4xl mb-4">🔍</div>
                <h3 class="text-xl font-bold text-slate-900">No books found</h3>
                <p class="text-slate-500">Try adjusting your search or filters.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $books->links() }}
    </div>
</div>
