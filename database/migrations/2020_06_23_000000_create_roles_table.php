<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function (Blueprint $table) {
			//$table->tinyIncrements('id');
			//$table->smallIncrements('id');
			//$table->mediumIncrements('id');
			//$table->increments('id');
			//$table->bigIncrements('id');
			$table->smallIncrements('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->timestamp('created_at', 0)->useCurrent();
			$table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('roles');
	}
};