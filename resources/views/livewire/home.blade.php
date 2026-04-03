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
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by title, author, or ISBN..." class="ui-search pl-10">
        </div>
        <div class="md:w-64">
            <select wire:model.live="category_id" class="ui-select h-[44px]">
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
                            <div class="flex items-center gap-3">
                                <button
                                    type="button"
                                    wire:click.prevent="borrow('{{ $book->id }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="borrow"
                                    class="text-sm font-bold text-emerald-600 hover:text-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    Borrow
                                </button>
                                <button
                                    type="button"
                                    wire:click.prevent="reserve('{{ $book->id }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="reserve"
                                    class="text-sm font-bold text-indigo-600 hover:text-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    Reserve
                                </button>
                            </div>
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
