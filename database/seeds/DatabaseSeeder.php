<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            // RolesTableSeeder::class,
            UsersTableSeeder::class,
            // OraseTableSeeder::class,
            // TarifeTableSeeder::class,
        ]);
        // factory('App\User', 20)->create()->each(function($user) {
        //     $user->roles()->attach(App\Role::where('nume', 'demo')->orwhere('nume', 'full')->get()->random(1));
        // });        
        
        // Get all the roles attaching up to 3 random roles to each user
        // $roles = App\Role::where('nume', 'demo')->orwhere('nume', 'full');

        // Populate the pivot table
        // App\User::all()->each(function ($user) use ($roles) { 
        //     $user->roles()->attach(
        //         $roles->random(rand(1, 2))->pluck('id')->toArray()
        //     ); 
        // });

        factory('App\Client', 50)->create();
    }
}
