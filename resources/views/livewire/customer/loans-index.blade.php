<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">My Borrowed Books</h2>
            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-full">{{ $loans->total() }} records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Borrow Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Return Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($loans as $loan)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-900">{{ $loan->book->title ?? 'Deleted Book' }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->book->author ?? 'Unknown Author' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $loan->borrow_date }}</td>
                            <td class="px-6 py-4 text-sm {{ $loan->status === 'borrowed' && now()->gt($loan->due_date) ? 'text-rose-600 font-semibold' : 'text-slate-600' }}">
                                {{ $loan->due_date }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $loan->return_date ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $loan->status === 'returned' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ strtoupper($loan->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">You have no borrowed books yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $loans->links() }}
        </div>
    </div>
</div>
