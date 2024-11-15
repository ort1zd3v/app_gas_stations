<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModuleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		PermissionModule::create(["name" => "dashboard", "module_type_id" => 2]);
		
		/** Users */
		$module = PermissionModule::create(["name" => "Users", "module_type_id" => 1]);
		PermissionModule::create(["name" => "users", "module_type_id" => 2, "module_id" => $module->id]);
		PermissionModule::create(["name" => "roles", "module_type_id" => 2, "module_id" => $module->id]);

		/** Configuration */
		$module = PermissionModule::create(["name" => "Configuration", "module_type_id" => 1]);
		PermissionModule::create(["name" => "config_general", "module_type_id" => 2, "module_id" => $module->id]);

		/** Templates */
		$module = PermissionModule::create(["name" => "Templates", "module_type_id" => 1]);
		PermissionModule::create(["name" => "templates", "module_type_id" => 2, "module_id" => $module->id]);
		
		
	}
}
