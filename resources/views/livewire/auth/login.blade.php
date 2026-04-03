<div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Login</h1>
    <p class="text-slate-500 text-sm mb-6">Sign in as admin or customer.</p>

    <div class="space-y-4">
        <div>
            <label class="ui-field-label">Email</label>
            <input type="email" wire:model="email" class="ui-input">
            @error('email') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Password</label>
            <input type="password" wire:model="password" class="ui-input">
            @error('password') <p class="ui-error">{{ $message }}</p> @enderror
        </div>

        <button wire:click="login" class="ui-btn-primary w-full">Login</button>
    </div>

    <p class="text-sm text-slate-500 mt-6">
        New customer?
        <a href="/register" class="text-indigo-600 font-medium hover:underline">Create account</a>
    </p>
</div>
