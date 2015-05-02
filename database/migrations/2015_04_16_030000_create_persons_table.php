<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration{
	
	public function up(){
		Schema::create('persons', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->string('name', 255);
			$table->string('last_name', 255);
			$table->string('last_name_born', 255);
			$table->string('middle_name', 255);
			$table->string('first_name', 255);
			$table->string('nick_name', 255);
			$table->date('birthday')->nullable();
			$table->date('deceased_at')->nullable();
			$table->date('first_met_at')->nullable();
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
