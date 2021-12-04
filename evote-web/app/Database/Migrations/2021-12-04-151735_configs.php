<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Configs extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'universitas'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],

		]);

		// Membuat primary key
		$this->forge->addKey('universitas', TRUE);
		// Membuat tabel admin
		$this->forge->createTable('configs', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('configs');
	}
}
