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

<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">

            <!-- Logo / Title -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Attendance System</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Masuk ke akun Anda
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
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input wire:model="email" type="email" placeholder="email@example.com"
                        class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center">
                        <label class="text-sm text-gray-600">Password</label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-indigo-500 hover:underline">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <input wire:model="password" type="password" placeholder="••••••••"
                        class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Remember -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="remember" class="rounded">
                    <span class="text-sm text-gray-600">Ingat saya</span>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Masuk
                </button>

            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-6">
            © {{ date('Y') }} Attendance System. All rights reserved.
        </p>

    </div>
</div>
