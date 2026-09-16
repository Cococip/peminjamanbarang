<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BorrowerSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $borrowers = [
            [
                'nama'       => 'Budi Santoso',
                'identitas'  => '2021010101',
                'kelas'      => 'TI-3A',
                'no_hp'      => '081234567890',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama'       => 'Siti Rahma',
                'identitas'  => '2021010102',
                'kelas'      => 'TI-3B',
                'no_hp'      => '081234567891',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama'       => 'Andi Wijaya',
                'identitas'  => '2021010103',
                'kelas'      => 'SI-2A',
                'no_hp'      => '081234567892',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama'       => 'Dewi Lestari',
                'identitas'  => '2021010104',
                'kelas'      => 'SI-2B',
                'no_hp'      => '081234567893',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('borrowers')->insertBatch($borrowers);
    }
}
