<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Form Section -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-semibold mb-4">New Loan</h2>
                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label class="ui-field-label">Book</label>
                        <select wire:model.live="book_id" class="ui-input">
                            <option value="">Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                        @error('book_id') <p class="ui-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="ui-field-label">Member</label>
                        <select wire:model.live="member_id" class="ui-input">
                            <option value="">Select Member</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                        @error('member_id') <p class="ui-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="ui-field-label">Due Date</label>
                        <input type="date" wire:model.live="due_date" class="ui-input">
                        @error('due_date') <p class="ui-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="ui-btn-primary w-full" wire:loading.attr="disabled">Create Loan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Section -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book & Member</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loans as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $loan->book->title ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">Borrowed by: {{ $loan->member->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Due: {{ $loan->due_date }}</div>
                                    <div class="text-sm text-gray-500">From: {{ $loan->borrow_date }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $loan->status === 'returned' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    @if($loan->status === 'borrowed')
                                        <button wire:click="markAsReturned('{{ $loan->id }}')" class="text-indigo-600 hover:text-indigo-900">Return</button>
                                    @endif
                                    <button wire:click="delete('{{ $loan->id }}')" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
