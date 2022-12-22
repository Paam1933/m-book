<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbBooks extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel news
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'judul'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'isi_konten'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '2100'
            ],


        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);

        // Membuat tabel news
        $this->forge->createTable('tb_books', TRUE);
    }

    public function down()
    {
        // menghapus tabel news
        $this->forge->dropTable('tb_books');
    }
}
