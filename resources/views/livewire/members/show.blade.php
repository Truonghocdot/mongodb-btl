<div>
    <div class="mb-6">
        <a href="/admin/members" class="text-indigo-600 hover:text-indigo-900 flex items-center">
            <span class="mr-2">←</span> Back to Members
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                        {{ substr($member->name, 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $member->name }}</h2>
                    <p class="text-gray-500">Member since {{ $member->join_date }}</p>
                </div>
                <div class="space-y-4 border-t pt-6">
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase">Email</label>
                        <p class="text-gray-900 font-medium">{{ $member->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase">Phone</label>
                        <p class="text-gray-900 font-medium">{{ $member->phone }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase">Address</label>
                        <p class="text-gray-900 font-medium">{{ $member->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900">Borrowing History</h3>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full">
                        {{ $loans->count() }} Total Loans
                    </span>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($loans as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $loan->book->title ?? 'Deleted Book' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->borrow_date }} to {{ $loan->due_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $loan->status === 'returned' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500">No borrowing records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
