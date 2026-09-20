@props([
    'status' => 'pending',
])

@php
    $normalized = strtolower(trim((string)$status));

    $statusConfig = match ($normalized) {
        'selesai', 'completed', 'verified', 'disetujui' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950 dark:text-emerald-300 dark:border-emerald-800',
        ],
        'in_progress', 'sedang dikerjakan', 'proses', 'dikerjakan' => [
            'label' => 'Sedang Dikerjakan',
            'class' => 'bg-cyan-50 text-cyan-800 border border-cyan-200 dark:bg-cyan-950 dark:text-cyan-300 dark:border-cyan-800',
        ],
        'revisi', 'perlu perbaikan' => [
            'label' => 'Perlu Revisi',
            'class' => 'bg-orange-50 text-orange-800 border border-orange-200 dark:bg-orange-950 dark:text-orange-300 dark:border-orange-800',
        ],
        'ditolak', 'rejected' => [
            'label' => 'Ditolak',
            'class' => 'bg-red-50 text-red-800 border border-red-200 dark:bg-red-950 dark:text-red-300 dark:border-red-800',
        ],
        'pending', 'menunggu', 'belum mulai' => [
            'label' => 'Menunggu',
            'class' => 'bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950 dark:text-amber-300 dark:border-amber-800',
        ],
        default => [
            'label' => ucfirst($status),
            'class' => 'bg-gray-100 text-gray-800 border border-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700',
        ],
    };
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $statusConfig['class'] }}">
    {{ $statusConfig['label'] }}
</span>
