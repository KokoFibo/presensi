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

<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Attendance System</h1>
                <p class="text-gray-500 text-sm mt-1">
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

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input wire:model="email" type="email"
                        class="mt-1 w-full px-4 py-2.5 border rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Password -->
                <div x-data="{ show: false }">
                    <div class="flex justify-between items-center">
                        <label class="text-sm text-gray-600">Password Baru</label>
                        <button type="button" @click="show = !show" class="text-xs text-indigo-500">
                            <span x-text="show ? 'Sembunyikan' : 'Lihat'"></span>
                        </button>
                    </div>

                    <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="Minimal 8 karakter"
                        class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="text-sm text-gray-600">Konfirmasi Password</label>
                    <input wire:model="password_confirmation" type="password" placeholder="Ulangi password"
                        class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Button -->
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    <span wire:loading.remove>Reset Password</span>
                    <span wire:loading>Menyimpan...</span>
                </button>

            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-6">
            © {{ date('Y') }} Attendance System. All rights reserved.
        </p>

    </div>
</div>
