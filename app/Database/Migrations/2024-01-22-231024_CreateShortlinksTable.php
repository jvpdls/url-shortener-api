<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class CreateShortlinksTable
 *
 * @package App\Database\Migrations
 */
class CreateShortlinksTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        $this->forge->addField([
            'ID' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'longUrl' => [
                'type' => 'TINYTEXT',
            ],
            'slug' => [
                'type' => 'TINYTEXT',
            ],
        ]);
        $this->forge->addKey('ID', true);
        $this->forge->createTable('shortlinks', true);
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        $this->forge->dropTable('shortlinks');
        $this->forge->dropDatabase('urls', true);
    }
}
