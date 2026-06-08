<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-10">
        <div class="w-full max-w-md">
            {{-- Branding --}}
            <div class="text-center mb-6">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-600 shadow-lg shadow-emerald-600/30">
                    <span class="text-2xl">🛠️</span>
                </div>
                <h1 class="mt-4 text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang</h1>
                <p class="mt-1 text-sm text-slate-500">Masuk untuk mengelola tiket Helpdesk TI</p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 ring-1 ring-slate-100 p-6 sm:p-8">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-800 font-semibold" />
                        <x-text-input id="email" class="block mt-1.5 w-full rounded-xl border-slate-300 text-slate-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-800 font-semibold" />

                        <x-text-input id="password" class="block mt-1.5 w-full rounded-xl border-slate-300 text-slate-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                            <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-emerald-600 hover:text-emerald-800 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/25 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:scale-[0.99] transition">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center text-xs text-slate-400 mt-6">Helpdesk TI &middot; Sistem Pelaporan Kendala</p>
        </div>
    </div>
</x-guest-layout>
