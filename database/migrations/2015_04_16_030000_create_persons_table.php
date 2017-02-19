<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration{
	
	public function up(){
		Schema::create('persons', function(Blueprint $table){
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->string('name', 255)->index();
			$table->string('last_name', 255)->index();
			$table->string('last_name_born', 255)->index();
			$table->string('middle_name', 255)->index();
			$table->string('first_name', 255)->index();
			$table->string('nick_name', 255)->index();
			$table->string('gender', 1)->nullable()->index();
			$table->dateTime('birthday')->nullable()->index();
			$table->dateTime('deceased_at')->nullable()->index();
			$table->dateTime('first_met_at')->nullable()->index();
			$table->string('facebook_id', 255)->nullable()->index();
			$table->string('facebook_url', 1024)->nullable()->index();
			// $table->string('facebook_url', 1024)->nullable();
			$table->string('blood_type', 2)->nullable()->index();
			$table->string('blood_type_rhd', 1)->nullable()->index();
			$table->smallInteger('default_event_type')->unsigned()->index()->default(1000);
			$table->text('comment');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}
	
	public function down(){
		Schema::drop('persons');
	}
	
}
