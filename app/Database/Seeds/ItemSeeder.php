<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $items = [
            [
                'kode_barang' => 'BRG-001',
                'nama_barang' => 'Laptop ASUS',
                'jumlah'      => 5,
                'kondisi'     => 'Baik',
                'status'      => 'Tersedia',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kode_barang' => 'BRG-002',
                'nama_barang' => 'Proyektor Epson',
                'jumlah'      => 3,
                'kondisi'     => 'Baik',
                'status'      => 'Tersedia',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kode_barang' => 'BRG-003',
                'nama_barang' => 'Kamera DSLR Canon',
                'jumlah'      => 2,
                'kondisi'     => 'Baik',
                'status'      => 'Tersedia',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kode_barang' => 'BRG-004',
                'nama_barang' => 'Tripod Kamera',
                'jumlah'      => 4,
                'kondisi'     => 'Rusak Ringan',
                'status'      => 'Dipinjam',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kode_barang' => 'BRG-005',
                'nama_barang' => 'Mikrofon Wireless',
                'jumlah'      => 6,
                'kondisi'     => 'Baik',
                'status'      => 'Tersedia',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'kode_barang' => 'BRG-006',
                'nama_barang' => 'Speaker Portable',
                'jumlah'      => 3,
                'kondisi'     => 'Baik',
                'status'      => 'Tersedia',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db->table('items')->insertBatch($items);
    }
}
