<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
	public function up()
	{

		$this->forge->addField([
			'kode_admin'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '7',
			],
			'username_admin'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '25'
			],
			'email_admin'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'password_admin' => [
				'type'           => 'BINARY',
				'constraint'     => 60,
			],

		]);

		// Membuat primary key
		$this->forge->addKey('kode_admin', TRUE);

		// Membuat tabel admin
		$this->forge->createTable('admin', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('admin');
	}
}
