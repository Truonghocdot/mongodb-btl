<div>
    @if(!$isLoggedIn)
        <!-- Login Form -->
        <div class="max-w-md mx-auto bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <div class="text-center mb-8">
                <div class="text-4xl mb-2">🔐</div>
                <h2 class="text-2xl font-bold text-slate-900">Sign in to LibPortal</h2>
                <p class="text-slate-500 text-sm">Enter your registered email and phone number to track your loans.</p>
            </div>

            @if (session()->has('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 mb-6 rounded-r-lg text-sm" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <input type="email" wire:model="email" placeholder="e.g. name@example.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-slate-50">
                    @error('email') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
                    <input type="text" wire:model="phone" placeholder="e.g. 0912345678" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-slate-50">
                    @error('phone') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                </div>
                <button wire:click="login" class="w-full py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Access Portal</button>
            </div>
            
            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400 italic">Not a member yet? Please visit the library to register.</p>
            </div>
        </div>
    @else
        <!-- Member Dashboard -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">Welcome, {{ $member->name }}!</h1>
                <p class="text-slate-500">Here is your current borrowing status.</p>
            </div>
            <button wire:click="logout" class="text-slate-400 hover:text-rose-600 text-sm font-medium transition flex items-center">
                <span class="mr-2">Logout</span> 🚪
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-indigo-600 p-6 rounded-3xl text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest mb-1">Your Library ID</p>
                        <p class="text-2xl font-mono font-bold">{{ substr($member->id, -8) }}</p>
                    </div>
                    <div class="absolute -right-4 -bottom-4 text-7xl opacity-10">📑</div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">Profile Details</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span class="text-slate-400 mr-3 mt-1">📧</span>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Email</p>
                                <p class="text-sm font-medium text-slate-700">{{ $member->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <span class="text-slate-400 mr-3 mt-1">📞</span>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Phone</p>
                                <p class="text-sm font-medium text-slate-700">{{ $member->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan History -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-900">My Borrowing History</h3>
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">{{ count($loans) }} Items</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Book Title</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Borrow Date</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Due Date</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($loans as $loan)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-5">
                                            <p class="text-sm font-bold text-slate-900">{{ $loan->book->title ?? 'Deleted Book' }}</p>
                                            <p class="text-xs text-slate-400">{{ $loan->book->author ?? 'Unknown' }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-slate-600">{{ $loan->borrow_date }}</td>
                                        <td class="px-6 py-5 text-sm {{ $loan->status === 'borrowed' && now()->gt($loan->due_date) ? 'text-rose-600 font-bold' : 'text-slate-600' }}">
                                            {{ $loan->due_date }}
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1 text-[10px] font-bold rounded-full inline-block {{ $loan->status === 'returned' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ strtoupper($loan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <p class="text-slate-400 italic">You haven't borrowed any books yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Reservation History -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mt-8">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-900">My Reservations</h3>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">{{ count($reservations) }} Requests</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Book Title</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Request Date</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($reservations as $res)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-5">
                                            <p class="text-sm font-bold text-slate-900">{{ $res->book->title ?? 'Deleted Book' }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-slate-600">{{ $res->request_date }}</td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1 text-[10px] font-bold rounded-full inline-block 
                                                {{ $res->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($res->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ strtoupper($res->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <p class="text-slate-400 italic">No reservation requests yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
