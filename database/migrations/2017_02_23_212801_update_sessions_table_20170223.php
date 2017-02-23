<?php

/**
 * New columns for Laravel 5.4.
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSessionsTable20170223 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sessions', function (Blueprint $table) {
			$table->integer('user_id')->nullable();
			$table->string('ip_address', 45)->nullable();
			$table->text('user_agent')->nullable();
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sessions', function (Blueprint $table) {
			$table->dropColumn('user_agent');
			$table->dropColumn('ip_address');
			$table->dropColumn('user_id');
		});
	}
}
