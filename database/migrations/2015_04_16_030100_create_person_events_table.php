<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonEventsTable extends Migration{
	
	public function up(){
		Schema::create('person_events', function(Blueprint $table){
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->integer('person_id')->unsigned()->index();
			$table->dateTime('happened_at')->nullable()->index();
			$table->smallInteger('type')->unsigned()->index()->default(1000);
			$table->string('title', 255);
			$table->text('comment');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
		});
	}
	
	public function down(){
		Schema::drop('person_events');
	}
	
}
