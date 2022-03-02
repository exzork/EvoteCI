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
			'password_admin' => password_hash(env("DEFAULT_ADMIN_PASSWORD"),PASSWORD_DEFAULT)
		]);
	}
}
