<x-app-layout>
    <x-slot name="header">{{ __('Dashboard') }}</x-slot>

    <livewire:dashboard.widget/>

    @push('scripts')
        <script src="{{ asset('js/custom-chart.js') }}"></script>
    @endpush
</x-app-layout>
