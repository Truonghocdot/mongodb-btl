<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Unpaid Fines</p>
            <p class="text-2xl font-bold text-amber-700">{{ $summary['count_unpaid'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Unpaid Amount</p>
            <p class="text-2xl font-bold text-amber-700">VND {{ number_format($summary['total_unpaid']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
            <select wire:model.live="status" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All statuses</option>
                <option value="unpaid">Unpaid</option>
                <option value="paid">Paid</option>
                <option value="waived">Waived</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($fines as $fine)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $fine->member->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $fine->loan->book->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $fine->reason }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-amber-700">VND {{ number_format($fine->amount) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $fine->status === 'paid' ? 'bg-green-100 text-green-700' : ($fine->status === 'waived' ? 'bg-gray-200 text-gray-700' : 'bg-red-100 text-red-700') }}">
                                {{ strtoupper($fine->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            @if($fine->status === 'unpaid')
                                <button wire:click="markAsPaid('{{ $fine->id }}')" class="text-indigo-600 hover:text-indigo-900 font-medium">Mark paid</button>
                                <button wire:click="waive('{{ $fine->id }}')" class="text-gray-600 hover:text-gray-900 font-medium">Waive</button>
                            @else
                                <span class="text-gray-400">Processed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">No fines found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $fines->links() }}
        </div>
    </div>
</div>
