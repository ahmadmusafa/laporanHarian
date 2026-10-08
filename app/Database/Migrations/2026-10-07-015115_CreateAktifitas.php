<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAktifitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_aktifitas' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'uraian_aktifitas' => [
                'type' => 'TEXT',
            ],
            'pembelajaran' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kendala' => [
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

        $this->forge->addKey('id_aktifitas', true);

        $this->forge->createTable('aktifitas');
    }

    public function down()
    {
        $this->forge->dropTable('aktifitas');
    }
}