<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersIndex extends Component
{
    use WithPagination;

    public $item_name = '';
    public $quantity = 1;
    public $total_amount = '';

    public function createOrder()
    {
        $validated = $this->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
        ]);

        Order::create([
            'customer_id' => (string) Auth::id(),
            'order_code' => 'ORD-'.strtoupper(substr((string) str()->uuid(), 0, 8)),
            'item_name' => $validated['item_name'],
            'quantity' => (int) $validated['quantity'],
            'total_amount' => (float) $validated['total_amount'],
            'status' => 'pending',
            'ordered_at' => now()->toDateString(),
        ]);

        $this->reset(['item_name', 'quantity', 'total_amount']);
        $this->quantity = 1;

        session()->flash('message', 'Order created successfully.');
    }

    public function render()
    {
        return view('livewire.customer.orders-index', [
            'orders' => Order::where('customer_id', (string) Auth::id())
                ->orderBy('ordered_at', 'desc')
                ->paginate(10),
        ])->layout('components.layouts.user', ['title' => 'My Orders']);
    }
}
