<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
	public function up()
	{

		$this->forge->addField([
			'npm'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '11',
			],
			'nama_user'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '50'
			],
			'email_user'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'password_user' => [
				'type'           => 'BINARY',
				'constraint'     => 60,
			],
			'type' => [
				'type'           => 'BINARY',
				'constraint'     => 1,
				'default'        => NULL,
			],

		]);

		// Membuat primary key
		$this->forge->addKey('npm', TRUE);

		// Membuat tabel admin
		$this->forge->createTable('user', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('user');
	}
}
