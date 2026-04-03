<?php

namespace App\Livewire\Admin;

use App\Models\Fine;
use Livewire\Component;
use Livewire\WithPagination;

class Fines extends Component
{
    use WithPagination;

    public $status = '';

    public function markAsPaid(string $id): void
    {
        $fine = Fine::findOrFail($id);

        if ($fine->status !== 'unpaid') {
            return;
        }

        $fine->update([
            'status' => 'paid',
            'paid_at' => now()->toDateString(),
        ]);

        session()->flash('message', 'Fine marked as paid.');
    }

    public function waive(string $id): void
    {
        $fine = Fine::findOrFail($id);

        if ($fine->status !== 'unpaid') {
            return;
        }

        $fine->update([
            'status' => 'waived',
            'paid_at' => now()->toDateString(),
        ]);

        session()->flash('message', 'Fine waived successfully.');
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $fines = Fine::with(['member', 'loan.book'])
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->orderBy('issued_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.fines', [
            'fines' => $fines,
            'summary' => [
                'total_unpaid' => Fine::where('status', 'unpaid')->sum('amount'),
                'count_unpaid' => Fine::where('status', 'unpaid')->count(),
            ],
        ])->layout('components.layouts.app', ['title' => 'Manage Fines']);
    }
}
