<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $borrowings = [
            [
                'kode_peminjaman' => 'PJM-20260101-0001',
                'barang_id'       => 1,
                'peminjam_id'     => 1,
                'jumlah'          => 2,
                'tanggal_pinjam'  => date('Y-m-d', strtotime('-5 days')),
                'tanggal_kembali' => date('Y-m-d', strtotime('+2 days')),
                'status'          => 'Dipinjam',
                'catatan'         => 'Untuk keperluan tugas kelompok',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'kode_peminjaman' => 'PJM-20260101-0002',
                'barang_id'       => 3,
                'peminjam_id'     => 2,
                'jumlah'          => 1,
                'tanggal_pinjam'  => date('Y-m-d', strtotime('-3 days')),
                'tanggal_kembali' => date('Y-m-d', strtotime('+4 days')),
                'status'          => 'Dipinjam',
                'catatan'         => 'Dokumentasi acara kampus',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'kode_peminjaman' => 'PJM-20260101-0003',
                'barang_id'       => 4,
                'peminjam_id'     => 3,
                'jumlah'          => 4,
                'tanggal_pinjam'  => date('Y-m-d', strtotime('-2 days')),
                'tanggal_kembali' => date('Y-m-d', strtotime('+5 days')),
                'status'          => 'Dipinjam',
                'catatan'         => null,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'kode_peminjaman' => 'PJM-20251225-0001',
                'barang_id'       => 2,
                'peminjam_id'     => 4,
                'jumlah'          => 1,
                'tanggal_pinjam'  => date('Y-m-d', strtotime('-10 days')),
                'tanggal_kembali' => date('Y-m-d', strtotime('-5 days')),
                'status'          => 'Dikembalikan',
                'catatan'         => 'Presentasi seminar',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ];

        $this->db->table('borrowings')->insertBatch($borrowings);
    }
}
