<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainmenuMainmenu;
use App\Models\MainmenuViewname;

class MainmenuMainmenuSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$menus = [
			/** dashboard */
			[
				"name" => "dashboard",
				"icon" => '<i class="fas fa-tachometer-alt"></i>',
			],
			/** users */
			[
				"name" => "users",
				"icon" => '<i class="fas fa-user-alt"></i>',
				"children" => [
					["name" => "users", "icon" => '<i class="fas fa-user-alt"></i>'],
					["name" => "roles", "icon" => '<i class="fas fa-user-tag"></i>'],
				]
			],
			/** configuration */
			[
				"name" => "configuration",
				"icon" => '<i class="fas fa-cog"></i>',
				"children" => [
					["name" => "config_general", "icon" => '<i class="fas fa-palette"></i>'],
				]
			],
			
		];
		$this->createMenus($menus);
	}


	public function createMenus($menus)
	{
		foreach ($menus as $key => $value) {
			$this->createMenu($value);
		}
	}

	public $menuPosition = 0;
	public function createMenu($param, $menuPosition = null, $menu_id = null)
	{
		//Set menu position as incremental value
		if($menuPosition == null)
			$this->menuPosition += 10;

		//If the param array doesn't have items then we search the viewname 
		//to link with the menu we will create
		if(!isset($param["children"])) {
			$viewname = MainmenuViewname::where("name", $param["viewname"] ?? $param["name"])->first();
		}
		//Create the menu
		$menu = MainmenuMainmenu::create([
			"name" => $param["name"], 
			"description" => $param["description"] ?? $param["name"], 
			"icon" => $param["icon"] ?? '<i class="fas fa-user"></i>',
			"menu_position" => $menuPosition ?? $this->menuPosition, 
			"mainmenu_status_id" => "1",
			"viewname_id" => !isset($param["children"]) ? $viewname->id : null,
			"mainmenu_id" => $menu_id ?? null,
		]);

		//If the menu have submenus
		$cc = 0;
		foreach ($param["children"] ?? [] as $key => $value) {
			$cc++;
			$cPos = (floatval($this->menuPosition) * 10) + ($cc*10);
			$this->createMenu($value, $cPos, $menu->id);
		}
	}
}
