<div class="space-y-6">
    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h2 class="text-lg font-semibold mb-4">Create New Order</h2>
        <form wire:submit.prevent="createOrder" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="ui-field-label">Item Name</label>
                <input type="text" wire:model.live="item_name" class="ui-input">
                @error('item_name') <p class="ui-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="ui-field-label">Quantity</label>
                <input type="number" min="1" wire:model.live="quantity" class="ui-input">
                @error('quantity') <p class="ui-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="ui-field-label">Total Amount</label>
                <input type="number" min="0" step="0.01" wire:model.live="total_amount" class="ui-input">
                @error('total_amount') <p class="ui-error">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="ui-btn-primary mt-1 md:col-span-3 md:w-fit" wire:loading.attr="disabled">Submit Order</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100">
            <h2 class="text-lg font-semibold">My Orders</h2>
        </div>
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $order->order_code }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $order->item_name }} (x{{ $order->quantity }})</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $order->ordered_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500">No orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
