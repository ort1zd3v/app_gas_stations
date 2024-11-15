<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::create([
			"name" => 'User',
			"paternal_surname" => 'Paternal',
			"maternal_surname" => 'Maternal',
			"email" => 'user@example.com',
			"password" => bcrypt('secret'),
			"role_id" => 1,
			"created_at" => date("Y-m-d H:i:s"),
			"updated_at" => date("Y-m-d H:i:s"),
		]);
		User::create([
			"name" => 'Cristian',
			"paternal_surname" => 'Mendoza',
			"maternal_surname" => 'Resendiz',
			"email" => 'khris.cmd@gmail.com',
			"password" => bcrypt('secret'),
			"role_id" => 1,
			"created_at" => date("Y-m-d H:i:s"),
			"updated_at" => date("Y-m-d H:i:s"),
		]);
	}
}
