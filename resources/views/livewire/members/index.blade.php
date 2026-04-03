<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Form Section -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-semibold mb-4">{{ $isEditMode ? 'Edit Member' : 'Register Member' }}</h2>
                <div class="space-y-4">
                    <div>
                        <label class="ui-field-label">Name</label>
                        <input type="text" wire:model="name" class="ui-input">
                    </div>
                    <div>
                        <label class="ui-field-label">Email</label>
                        <input type="email" wire:model="email" class="ui-input">
                    </div>
                    <div>
                        <label class="ui-field-label">Phone</label>
                        <input type="text" wire:model="phone" class="ui-input">
                    </div>
                    <div>
                        <label class="ui-field-label">Address</label>
                        <textarea wire:model="address" class="ui-input"></textarea>
                    </div>
                    <div class="pt-4 flex gap-2">
                        @if($isEditMode)
                            <button wire:click="update" class="ui-btn-primary w-full">Update Member</button>
                            <button wire:click="resetFields" class="ui-btn-secondary w-full">Cancel</button>
                        @else
                            <button wire:click="store" class="ui-btn-primary w-full">Register</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- List Section -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <input type="text" wire:model.live="search" placeholder="Search members..." class="ui-search">
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($members as $member)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $member->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $member->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->join_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="/admin/members/{{ $member->id }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View History</a>
                                    <button wire:click="edit('{{ $member->id }}')" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <button wire:click="delete('{{ $member->id }}')" class="text-red-600 hover:text-red-900" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
