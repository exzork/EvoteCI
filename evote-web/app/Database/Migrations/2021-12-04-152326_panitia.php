<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Panitia extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'kode_panitia'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '7',
			],
			'npm_panitia'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '11'
			],
			'event'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 7,
			],
			'jabatan' => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],

		]);

		// Membuat primary key
		$this->forge->addKey('kode_panitia', TRUE);
		$this->forge->addForeignKey('event', 'event', 'kode_event', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('npm_panitia', 'user', 'npm', 'CASCADE', 'CASCADE');

		// Membuat tabel panitia
		$this->forge->createTable('panitia', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('panitia');
	}
}
