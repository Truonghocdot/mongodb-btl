<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $status = '';

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function markStatus(string $id, string $status)
    {
        if (! in_array($status, ['pending', 'processing', 'completed', 'cancelled'], true)) {
            return;
        }

        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);

        session()->flash('message', 'Order status updated.');
    }

    public function render()
    {
        $orders = Order::with('customer')
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->orderBy('ordered_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.orders', [
            'orders' => $orders,
        ])->layout('components.layouts.app', ['title' => 'Order Management']);
    }
}
