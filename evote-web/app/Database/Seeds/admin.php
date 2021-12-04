<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
	public function run()
	{
		//
		$this->db->table('admin')->insert([
			'kode_admin' => 'ADM0001',
			'username_admin' => 'evoteci',
			'email_admin' => 'muhammadeko.if@gmail.com',
			'password_admin' => '243279243130242f587a566a6831354a31473451667832426e4c45704f5851685436456c4f4852796b732e626732342f6c43322f754355424f567171'
		]);
	}
}
