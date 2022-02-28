<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tokens extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'token'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'email'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
			],
			'status'              => [
				'type'           => 'INT',
				'constraint'     => '11',
				'default' => '0'
			],

		]);
		$this->forge->addKey('token', true);
		$this->forge->createTable('tokens');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('tokens');
	}
}
