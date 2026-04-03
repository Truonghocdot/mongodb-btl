<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Customer Registration</h1>
    <p class="text-slate-500 text-sm mb-6">Create your customer account to manage orders.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
            <input type="text" wire:model="name" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" wire:model="email" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
            <input type="text" wire:model="phone" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
            <input type="text" wire:model="address" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('address') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" wire:model="password" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>
    </div>

    <button wire:click="register" class="w-full mt-6 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Register</button>

    <p class="text-sm text-slate-500 mt-4">
        Already have an account?
        <a href="/login" class="text-indigo-600 font-medium hover:underline">Login here</a>
    </p>
</div>
