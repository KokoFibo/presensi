<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Attendance System</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Reset password akun Anda
                </p>
            </div>

            <!-- Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit="sendPasswordResetLink" class="space-y-5">

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input wire:model="email" type="email" placeholder="email@example.com"
                        class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Kirim Link Reset
                </button>

            </form>

        </div>

        <!-- Back to login -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Ingat password?
            <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">
                Masuk
            </a>
        </p>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-2">
            © {{ date('Y') }} Attendance System. All rights reserved.
        </p>

    </div>
</div>
