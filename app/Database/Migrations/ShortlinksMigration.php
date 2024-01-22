<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class ShortlinksMigration extends Migration {

    public function up()
    {
        $this->forge->addField(array(
            'ID' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'slug' => array(
                'type' => 'TINYTEXT',
            ),
            'longUrl' => array(
                'type' => 'TINYTEXT',
            ),
        ));

        $this->forge->addKey('ID', TRUE);
        $this->forge->createTable('shortlinks');
    }

    public function down()
    {
        $this->forge->dropTable('shortlinks');
    }
}