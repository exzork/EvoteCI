<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rekap extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'kode_rekap'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '10',
			],
			'npm_pemilih'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '11',
			],
			'event'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '7',
			],
			'foto_ktm'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'foto_rekap'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'valid'      => [
				'type'           => 'tinyint',
				'constraint'     => 1,
				'null'           => true,
			],
			'tanggal_pilih DATETIME DEFAULT CURRENT_TIMESTAMP'

		]);

		// Membuat primary key
		$this->forge->addKey('kode_rekap', TRUE);
		$this->forge->addForeignKey('npm_pemilih', 'user', 'npm', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('event', 'event', 'kode_event', 'CASCADE', 'CASCADE');
		$this->forge->createTable('rekap', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('rekap');
	}
}
