<x-app-layout>
    <x-slot name="header">{{ __('Profile') }}</x-slot>

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
        @livewire('profile.update-profile-information-form')

        <x-jet-section-border />
    @endif

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        @livewire('profile.update-password-form')
    @endif

    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <x-jet-section-border />

        @livewire('profile.two-factor-authentication-form')
    @endif

    <x-jet-section-border />

    @livewire('profile.logout-other-browser-sessions-form')

    <x-jet-section-border />

    @livewire('profile.delete-user-form')
</x-app-layout>
