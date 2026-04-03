<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Customer Registration</h1>
    <p class="text-slate-500 text-sm mb-6">Create your customer account to manage orders.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="ui-field-label">Full Name</label>
            <input type="text" wire:model="name" class="ui-input">
            @error('name') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Email</label>
            <input type="email" wire:model="email" class="ui-input">
            @error('email') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Phone</label>
            <input type="text" wire:model="phone" class="ui-input">
            @error('phone') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Address</label>
            <input type="text" wire:model="address" class="ui-input">
            @error('address') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Password</label>
            <input type="password" wire:model="password" class="ui-input">
            @error('password') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" class="ui-input">
        </div>
    </div>

    <button wire:click="register" class="ui-btn-primary w-full mt-6">Register</button>

    <p class="text-sm text-slate-500 mt-4">
        Already have an account?
        <a href="/login" class="text-indigo-600 font-medium hover:underline">Login here</a>
    </p>
</div>
