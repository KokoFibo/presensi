<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>


<div class="w-full max-w-md">

    <!-- Card -->
    <div class="relative bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-lg">

        <!-- 🔥 OVERLAY LOADING -->
        <div wire:loading.flex wire:target="sendPasswordResetLink"
            class="absolute inset-0 z-10 items-center justify-center bg-white/70 backdrop-blur-sm rounded-2xl">

            <div class="flex flex-col items-center gap-3">

                <!-- Spinner -->
                <svg class="animate-spin h-6 w-6 text-[#1a1c1e]" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                    </path>
                </svg>

                <span class="text-sm text-gray-600">
                    Mengirim email...
                </span>

            </div>
        </div>

        <!-- Title -->
        <div class="text-center mb-8 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl font-bold mb-2 text-gray-900">
                Attendance System
            </h1>
            <p class="text-gray-500 text-sm">
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

            <!-- Button -->
            <button type="submit" wire:loading.attr="disabled" wire:target="sendPasswordResetLink"
                wire:loading.class="opacity-70 cursor-not-allowed"
                class="w-full py-3 px-4 rounded-xl text-white font-bold tracking-wide transition-all duration-300 active:scale-95 flex items-center justify-center gap-2"
                style="background-color: #1a1c1e;">

                <!-- Normal -->
                <span wire:loading.remove wire:target="sendPasswordResetLink">
                    KIRIM LINK RESET
                </span>

                <!-- Loading -->
                <span wire:loading wire:target="sendPasswordResetLink" class="flex items-center gap-2">

                    <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                        </path>
                    </svg>

                    Mengirim...
                </span>

            </button>

        </form>

        <!-- Back -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Ingat password?
            <a href="{{ route('login') }}" class="font-medium text-[#8c7851] hover:underline">
                Masuk
            </a>
        </p>

    </div>

    <!-- Footer -->
    <p class="text-center text-[10px] text-gray-400 mt-4">
        © {{ date('Y') }} Attendance System
    </p>

</div>
