<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])
                ->save();

            event(new PasswordReset($user));
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PasswordReset) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
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
                Buat password baru
            </p>
        </div>

        <!-- Status -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="resetPassword" class="space-y-5">

            <!-- Email (readonly) -->
            <div class="group">
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700">
                    Email Address
                </label>

                <input wire:model="email" type="email" readonly
                    class="dark:text-gray-900 w-full px-4 py-3 rounded-xl bg-gray-100 border border-gray-200 text-gray-500 cursor-not-allowed">
            </div>

            <!-- Password -->
            <div x-data="{ show: false }" class="group">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-700">
                        Password Baru
                    </label>

                    <button type="button" @click="show = !show"
                        class="text-xs font-medium text-[#8c7851] hover:underline">
                        <span x-text="show ? 'Sembunyikan' : 'Lihat'"></span>
                    </button>
                </div>

                <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="Minimal 8 karakter"
                    class="dark:text-gray-900 w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 outline-none transition-all duration-300 focus:border-[#8c7851] focus:ring-2 focus:ring-[#8c7851]/20">

                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="group">
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700">
                    Konfirmasi Password
                </label>

                <input wire:model="password_confirmation" type="password" placeholder="Ulangi password"
                    class="dark:text-gray-900 w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 outline-none transition-all duration-300 focus:border-[#8c7851] focus:ring-2 focus:ring-[#8c7851]/20">
            </div>

            <!-- Button -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full py-3 px-4 rounded-xl text-white font-bold tracking-wide transition-all duration-300 active:scale-95"
                style="background-color: #1a1c1e;">
                <span wire:loading.remove>RESET PASSWORD</span>
                <span wire:loading>Menyimpan...</span>
            </button>

        </form>

    </div>

    <!-- Footer -->
    <p class="text-center text-[10px] text-gray-400 mt-4">
        © {{ date('Y') }} Attendance System
    </p>

</div>
