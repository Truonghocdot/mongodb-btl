<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="mb-4">
        <select wire:model.live="status" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">All statuses</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-semibold text-gray-900">{{ $order->order_code }}</div>
                            <div class="text-gray-500">{{ $order->item_name }} x{{ $order->quantity }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ $order->customer->name ?? 'N/A' }}</div>
                            <div class="text-gray-500">{{ $order->customer->email ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <button wire:click="markStatus('{{ $order->id }}', 'processing')" class="text-indigo-600 hover:text-indigo-900">Processing</button>
                            <button wire:click="markStatus('{{ $order->id }}', 'completed')" class="text-green-600 hover:text-green-800">Complete</button>
                            <button wire:click="markStatus('{{ $order->id }}', 'cancelled')" class="text-red-600 hover:text-red-800">Cancel</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
