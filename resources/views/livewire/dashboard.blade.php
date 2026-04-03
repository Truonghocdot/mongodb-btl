<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 mr-4 text-2xl">📚</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Books</p>
                <p class="text-2xl font-bold">{{ $stats['total_books'] }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 bg-green-100 rounded-lg text-green-600 mr-4 text-2xl">👥</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Members</p>
                <p class="text-2xl font-bold">{{ $stats['total_members'] }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg text-purple-600 mr-4 text-2xl">📑</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Active Loans</p>
                <p class="text-2xl font-bold">{{ $stats['active_loans'] }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 bg-red-100 rounded-lg text-red-600 mr-4 text-2xl">⚠️</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Overdue</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['overdue_loans'] }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 bg-amber-100 rounded-lg text-amber-600 mr-4 text-2xl">💸</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Unpaid Fines</p>
                <p class="text-2xl font-bold text-amber-700">{{ $stats['unpaid_fines'] }}</p>
                <p class="text-xs text-gray-500">VND {{ number_format($stats['unpaid_amount']) }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activities -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Recent Activities</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_activities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $activity->member->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->book->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity->status === 'returned' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No recent activity.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full">
                <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
                <div class="flex flex-col gap-4">
                    <a href="/admin/books" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-center font-medium">Add New Book</a>
                    <a href="/admin/members" class="w-full px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition text-center font-medium">Manage Members</a>
                    <a href="/admin/loans" class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-black transition text-center font-medium">Register New Loan</a>
                </div>
            </div>
        </div>
    </div>
</div>
