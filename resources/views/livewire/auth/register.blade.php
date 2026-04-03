<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Customer Registration</h1>
    <p class="text-slate-500 text-sm mb-6">Create your customer account to manage orders.</p>

    <form wire:submit.prevent="register" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="ui-field-label">Full Name</label>
            <input type="text" wire:model.live="name" class="ui-input" autocomplete="name">
            @error('name') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Email</label>
            <input type="email" wire:model.live="email" class="ui-input" autocomplete="email">
            @error('email') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Phone</label>
            <input type="text" wire:model.live="phone" class="ui-input">
            @error('phone') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Address</label>
            <input type="text" wire:model.live="address" class="ui-input" autocomplete="street-address">
            @error('address') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Password</label>
            <input type="password" wire:model.live="password" class="ui-input" autocomplete="new-password">
            @error('password') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Confirm Password</label>
            <input type="password" wire:model.live="password_confirmation" class="ui-input" autocomplete="new-password">
        </div>
        <button type="submit" class="ui-btn-primary w-full mt-2 md:col-span-2" wire:loading.attr="disabled">Register</button>
    </form>

    <p class="text-sm text-slate-500 mt-4">
        Already have an account?
        <a href="/login" class="text-indigo-600 font-medium hover:underline">Login here</a>
    </p>
</div>
