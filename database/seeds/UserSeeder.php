<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::truncate();
        
    	User::create(['name' => 'Ilyas Habiburrahman', 'email' => 'ilyashabiburrahman@gmail.com', 'password' => bcrypt('rahasia'), 'is_admin' => 1]);
        User::create(['name' => 'Rezqi', 'email' => 'rezqi@gmail.com', 'password' => bcrypt('rahasia'), 'is_admin' => 1]);
        User::create(['name' => 'Jeanni', 'email' => 'jeanni@gmail.com', 'password' => bcrypt('rahasia')]);
        User::create(['name' => 'Faisal', 'email' => 'faisal@gmail.com', 'password' => bcrypt('rahasia')]);
        User::create(['name' => 'Administrator', 'email' => 'admin@gmail.com', 'password' => bcrypt('rahasia'), 'is_admin' => 1]);
        User::create(['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('admin123')]);
    }
}
