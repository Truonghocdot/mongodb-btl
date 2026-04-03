<div>
    <div class="mb-8">
        <a href="/" class="text-indigo-600 hover:text-indigo-900 flex items-center font-medium">
            <span class="mr-2">←</span> Back to Catalog
        </a>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Book Cover & Info -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 sticky top-24">
                <div class="h-80 bg-slate-100 rounded-2xl flex items-center justify-center text-8xl mb-6 shadow-inner">📖</div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-2 leading-tight">{{ $book->title }}</h1>
                <p class="text-xl text-slate-500 mb-6">by {{ $book->author }}</p>
                
                <div class="space-y-4 border-t pt-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Category</span>
                        <span class="text-indigo-600 font-bold">{{ $book->category->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">ISBN</span>
                        <span class="text-slate-700 font-medium">{{ $book->isbn }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Stock</span>
                        <span class="font-bold {{ $book->quantity > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $book->quantity }} units available
                        </span>
                    </div>
                </div>
                
                <div class="mt-8">
                    @if($book->quantity > 0)
                        <button wire:click="$parent.reserve('{{ $book->id }}')" class="ui-btn-primary w-full">Reserve This Book</button>
                    @else
                        <button disabled class="w-full py-4 bg-slate-100 text-slate-400 rounded-xl font-bold cursor-not-allowed uppercase text-xs tracking-widest">Out of Stock</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Summary -->
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-4">Book Description</h2>
                <p class="text-slate-600 leading-relaxed italic">"{{ $book->description ?? 'No description available for this book yet. It remains a mystery of literature until you read it!' }}"</p>
            </div>

            <!-- Review Form -->
            <div class="bg-indigo-50 p-8 rounded-3xl">
                <h3 class="text-xl font-bold text-slate-900 mb-4">Leave a Review</h3>
                <div class="space-y-4">
                    <div>
                        <label class="ui-field-label">Rating</label>
                        <select wire:model="rating" class="ui-select bg-white">
                            <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                            <option value="4">⭐⭐⭐⭐ (Good)</option>
                            <option value="3">⭐⭐⭐ (Average)</option>
                            <option value="2">⭐⭐ (Poor)</option>
                            <option value="1">⭐ (Waste of time)</option>
                        </select>
                    </div>
                    <div>
                        <label class="ui-field-label">Comment</label>
                        <textarea wire:model="comment" rows="4" class="ui-textarea bg-white" placeholder="What did you think about this book?"></textarea>
                        @error('comment') <span class="ui-error">{{ $message }}</span> @enderror
                    </div>
                    <button wire:click="submitReview" class="ui-btn-primary">Submit Review</button>
                </div>
            </div>

            <!-- Reviews List -->
            <div>
                <h3 class="text-xl font-bold text-slate-900 mb-6">Reader Reviews ({{ count($reviews) }})</h3>
                <div class="space-y-6">
                    @forelse($reviews as $rev)
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 font-bold mr-3 italic">{{ substr($rev->member->name ?? '?', 0, 1) }}</div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $rev->member->name ?? 'Anonymous' }}</p>
                                        <div class="text-[10px] text-amber-500">
                                            @for($i=0; $i<$rev->rating; $i++) ⭐ @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400 font-medium">{{ $rev->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $rev->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center py-10 border-2 border-dashed border-slate-200 rounded-3xl">
                            <p class="text-slate-400 italic">No reviews yet. Be the first to share your thoughts!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
