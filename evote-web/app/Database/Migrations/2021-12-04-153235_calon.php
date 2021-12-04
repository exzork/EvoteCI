<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Calon extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'kode_calon'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '7',
			],
			'panitia'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '7',
			],
			'npm_ketua'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '11'
			],
			'npm_wakil'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '11'
			],
			'foto_calon'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'pesan' => [
				'type'           => 'TEXT',
			],
			'pem' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'        => NULL,
			],
			'jumlah' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'default'        => 0,
			],

		]);

		// Membuat primary key
		$this->forge->addKey('kode_calon', TRUE);
		$this->forge->addForeignKey('npm_ketua', 'user', 'npm', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('npm_wakil', 'user', 'npm', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('panitia', 'panitia', 'kode_panitia', 'CASCADE', 'CASCADE');

		$this->forge->createTable('calon', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('calon');
		//
	}
}
