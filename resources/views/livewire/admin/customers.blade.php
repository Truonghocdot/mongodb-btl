<div>
    <div class="mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, email, phone..." class="w-full md:w-96 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($customers as $customer)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                            <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $customer->address ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ optional($customer->created_at)->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>
