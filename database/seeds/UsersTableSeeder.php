<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder{
	
	public function run(){
		DB::table('users')->delete();
		
		User::create(array('name' => 'root', 'email' => 'dev@fox21.at', 'password' => Hash::make('password')));
		User::create(array('name' => 'dev1', 'email' => 'dev1@fox21.at', 'password' => Hash::make('password')));
		User::create(array('name' => 'dev2', 'email' => 'dev2@fox21.at', 'password' => Hash::make('password')));
	}
	
}
