@props(['title' => 'Ruang Siswa', 'subtitle' => null])

<x-dashboard.layout role="siswa" :title="$title" :subtitle="$subtitle">
    {{ $slot }}
</x-dashboard.layout>
