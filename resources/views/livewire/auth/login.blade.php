<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>


<div class="w-full max-w-md">

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-lg">

        <!-- Title -->
        <div class="text-center mb-8 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold mb-2 text-gray-900">
                Attendance System
            </h1>
            <p class="text-gray-500 text-sm">
                Silakan masuk ke akun Anda
            </p>
        </div>

        <!-- Status -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="login" class="space-y-5">

            <!-- Email -->
            <div class="group">
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700">
                    Email Address
                </label>

                <input wire:model="email" type="email" placeholder="nama@email.com"
                    class="dark:text-gray-900 w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 outline-none transition-all duration-300 focus:border-[#8c7851] focus:ring-2 focus:ring-[#8c7851]/20">

                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="group">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-700">
                        Password
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-xs font-medium text-[#8c7851] hover:underline">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <input wire:model="password" type="password" placeholder="••••••••"
                    class="dark:text-gray-900 w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 outline-none transition-all duration-300 focus:border-[#8c7851] focus:ring-2 focus:ring-[#8c7851]/20">
            </div>

            <!-- Remember -->
            <div class="flex items-center">
                <input type="checkbox" wire:model="remember"
                    class="w-4 h-4 rounded border-gray-300 text-[#8c7851] focus:ring-[#8c7851]">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full py-3 px-4 rounded-xl text-white font-bold tracking-wide transition-all duration-300 active:scale-95"
                style="background-color: #1a1c1e;">
                MASUK
            </button>

        </form>

    </div>

    <!-- Footer -->
    <p class="text-center text-[10px] text-gray-400 mt-4">
        © {{ date('Y') }} Attendance System
    </p>

</div>
