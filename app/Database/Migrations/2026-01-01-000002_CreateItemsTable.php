<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'nama_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'kondisi' => [
                'type'       => 'ENUM',
                'constraint' => ['Baik', 'Rusak Ringan', 'Rusak'],
                'default'    => 'Baik',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Tersedia', 'Dipinjam'],
                'default'    => 'Tersedia',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_barang');
        $this->forge->createTable('items');
    }

    public function down()
    {
        $this->forge->dropTable('items');
    }
}
