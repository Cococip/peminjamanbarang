<?php

if (! function_exists('status_badge')) {
    /**
     * Render badge HTML untuk berbagai jenis status pada aplikasi.
     */
    function status_badge(string $status): string
    {
        $map = [
            'Tersedia'     => 'green',
            'Dipinjam'     => 'orange',
            'Dikembalikan' => 'blue',
            'Baik'         => 'green',
            'Rusak Ringan' => 'orange',
            'Rusak'        => 'red',
        ];

        $color = $map[$status] ?? 'gray';

        return '<span class="badge badge-' . $color . '"><span class="badge-dot"></span>' . esc($status) . '</span>';
    }
}
