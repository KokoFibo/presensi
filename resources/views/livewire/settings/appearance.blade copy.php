<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="flex flex-col items-start p-5">
    @include('partials.settings-heading')

    {{-- <x-settings.layout heading="Appearance" subheading="Update your account's appearance settings"> --}}
    <x-settings.layout heading="Tampilan" subheading="Update settingan tampilan akun anda">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">Light</flux:radio>
            <flux:radio value="dark" icon="moon">Dark</flux:radio>
            <flux:radio value="system" icon="computer-desktop">System</flux:radio>
        </flux:radio.group>
        {{-- <div class="flex items-center justify-end"> --}}
        <div class="mt-3">
            <a href="/presensi">
                <flux:button variant="primary" class="w-full">{{ __('Kembali') }}</flux:button>
            </a>
        </div>
    </x-settings.layout>
</div>
