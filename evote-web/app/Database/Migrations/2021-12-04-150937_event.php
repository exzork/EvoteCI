<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Event extends Migration
{
	public function up()
	{

		$this->forge->addField([
			'kode_event'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '7',
			],
			'admin'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '7',
			],
			'nama_event'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255
			],
			'foto_event'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'deskripsi'      => [
				'type'           => 'TEXT'
			],
			'waktu_mulai' => [
				'type'           => 'datetime',
			],
			'waktu_selesai' => [
				'type'           => 'datetime',
			],

		]);

		// Membuat primary key
		$this->forge->addKey('kode_event', TRUE);
		$this->forge->addForeignKey('admin', 'admin', 'kode_admin', 'CASCADE', 'CASCADE');
		// Membuat tabel admin
		$this->forge->createTable('event', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('event');
	}
}
