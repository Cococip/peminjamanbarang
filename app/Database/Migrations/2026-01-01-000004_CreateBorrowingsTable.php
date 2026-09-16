<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBorrowingsTable extends Migration
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
            'kode_peminjaman' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'barang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'peminjam_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tanggal_pinjam' => [
                'type' => 'DATE',
            ],
            'tanggal_kembali' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Dipinjam', 'Dikembalikan'],
                'default'    => 'Dipinjam',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addUniqueKey('kode_peminjaman');
        $this->forge->addForeignKey('barang_id', 'items', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('peminjam_id', 'borrowers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('borrowings');
    }

    public function down()
    {
        $this->forge->dropForeignKey('borrowings', 'borrowings_barang_id_foreign');
        $this->forge->dropForeignKey('borrowings', 'borrowings_peminjam_id_foreign');
        $this->forge->dropTable('borrowings');
    }
}
