@props(['title' => 'Panel Admin', 'subtitle' => null])

<x-dashboard.layout role="admin" :title="$title" :subtitle="$subtitle">
    {{ $slot }}
</x-dashboard.layout>
