@props(['title' => 'Panel Guru', 'subtitle' => null])

<x-dashboard.layout role="guru" :title="$title" :subtitle="$subtitle">
    {{ $slot }}
</x-dashboard.layout>
