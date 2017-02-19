<?php

use Illuminate\Database\Seeder;
use App\PersonEvent;

class PersonEventsTableSeeder extends Seeder{
	
	public function run(){
		DB::table('person_events')->delete();
		
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-01 15:30', 'type' => 1000, 'title' => 'c1', 'comment' => 'comment1']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-02 16:30', 'type' => 2000, 'title' => 'c1', 'comment' => 'comment2']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-02 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment3']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-03 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment3']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-03 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment3']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-03 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment3']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-03 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment3']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-03 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment3']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 1, 'happened_at' => '2001-01-03 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment3']);
		
		PersonEvent::create(['user_id' => 1, 'person_id' => 2, 'happened_at' => '2001-01-03 15:30', 'type' => 1000, 'title' => 'c1', 'comment' => 'comment4']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 2, 'happened_at' => '2001-01-04 16:30', 'type' => 2000, 'title' => 'c1', 'comment' => 'comment5']);
		PersonEvent::create(['user_id' => 1, 'person_id' => 2, 'happened_at' => '2001-01-05 16:30', 'type' => 3000, 'title' => 'c1', 'comment' => 'comment6']);
		
		PersonEvent::create(['user_id' => 2, 'person_id' => 3, 'happened_at' => '2001-01-01 15:30', 'type' => 1000, 'title' => 'c1', 'comment' => 'comment1']);
	}
	
}
