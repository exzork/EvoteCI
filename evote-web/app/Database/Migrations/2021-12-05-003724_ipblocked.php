<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ipblocked extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'ip_address'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'blocked_time'       => [
				'type'           => 'datetime',
			],


		]);

		$this->forge->addKey('ip_address', true);
		$this->forge->createTable('ipblocked');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('ipblocked');
	}
}
