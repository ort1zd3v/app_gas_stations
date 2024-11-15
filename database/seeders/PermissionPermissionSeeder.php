<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class PermissionPermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->createPermissions(["dashboard"], ["index"], false);
		/** Users */
		$this->createPermissions(["roles"], ["permissions", "savePermissions", "getAll"]);
		$this->createPermissions(["users"], ["permissions", "savePermissions", "getAll", "getDetailsData"]);

		/** Configuration */
		$this->createPermissions(["config_general"], ['getPartOfPreview']);
		
		/** Templates */
		$this->createPermissions(["templates"], ['updateTheme']);
	}

	/**
	 * [createPermissions Permisos para los modulos de usuarios y roles 
	 * donde se agregan las funciones básicas y función de guardar permisos]
	 */
	public function createPermissions($moduleNames = [], $functionNames = [], $addCrudFunctions = true) {
		$defaultFunctions = ["index","store","create","show","update","destroy","edit", "getbyparam", "getquickmodalcontent"];
		$modules = PermissionModule::where('module_type_id', '2')->whereIn('name', $moduleNames)->get();
		if($addCrudFunctions) {
			$functionNames = array_merge($defaultFunctions, $functionNames);
		}
		$functions = PermissionFunction::whereIn('name', $functionNames)->get();
		
		foreach ($modules as $key => $module) {
			foreach ($functions as $key => $function) {
				PermissionPermission::create(["module_id" => $module->id, "function_id" => $function->id]);
			}
		}
	}
}
