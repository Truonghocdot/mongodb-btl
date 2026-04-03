<div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Login</h1>
    <p class="text-slate-500 text-sm mb-6">Sign in as admin or customer.</p>

    @error('auth')
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-3 rounded-r-lg text-sm mb-4">{{ $message }}</div>
    @enderror

    <form wire:submit.prevent="login" class="space-y-4">
        <div>
            <label class="ui-field-label">Email</label>
            <input type="email" wire:model.live="email" class="ui-input" autocomplete="email">
            @error('email') <p class="ui-error">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="ui-field-label">Password</label>
            <input type="password" wire:model.live="password" class="ui-input" autocomplete="current-password">
            @error('password') <p class="ui-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="ui-btn-primary w-full" wire:loading.attr="disabled">Login</button>
    </form>

    <p class="text-sm text-slate-500 mt-6">
        New customer?
        <a href="/register" class="text-indigo-600 font-medium hover:underline">Create account</a>
    </p>
</div>
