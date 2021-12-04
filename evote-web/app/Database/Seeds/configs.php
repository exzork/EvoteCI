<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Configs extends Seeder
{
	public function run()
	{
		//
		$this->db->table('configs')->insert([
			'universitas' => 'UPN Veteran Jawa Timur',
		]);
	}
}
