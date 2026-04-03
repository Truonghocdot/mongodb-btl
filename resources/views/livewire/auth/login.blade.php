<div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Login</h1>
    <p class="text-slate-500 text-sm mb-6">Sign in as admin or customer.</p>

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" wire:model="email" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" wire:model="password" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button wire:click="login" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Login</button>
    </div>

    <p class="text-sm text-slate-500 mt-6">
        New customer?
        <a href="/register" class="text-indigo-600 font-medium hover:underline">Create account</a>
    </p>
</div>
