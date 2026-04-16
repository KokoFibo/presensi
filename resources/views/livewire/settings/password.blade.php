<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="w-full p-5">
    @include('partials.settings-heading')

    <x-settings.layout heading="Update password" {{-- subheading="Ensure your account is using a long, random password to stay secure"> --}}
        subheading="Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input wire:model="current_password" id="update_password_current_passwordpassword"
                label="{{ __('Password sekarang') }}" type="password" name="current_password" required
                autocomplete="current-password" />
            <flux:input wire:model="password" id="update_password_password" label="{{ __('Password baru') }}"
                type="password" name="password" required autocomplete="new-password" />
            <flux:input wire:model="password_confirmation" id="update_password_password_confirmation"
                label="{{ __('Konfirmasi Password') }}" type="password" name="password_confirmation" required
                autocomplete="new-password" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
                <div class="flex items-center justify-end">
                    <a href="/presensi">
                        <flux:button variant="primary" class="w-full">{{ __('Kembali') }}</flux:button>
                    </a>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
