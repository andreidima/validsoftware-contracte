<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => 'Vali Dima',
        //     'email' => 'contact@validsoftware.ro',
        //     'password' => bcrypt('39143914'),
        // ]);

        // $user = \App\User::where('name', 'Vali Dima')->find(1);
        // $user->roles()->sync(\App\Role::where('nume', 'administrator')->get());

        $user = \App\User::create([
            'name' => 'Vali Dima',
            'provider' => 'Site',
            'email' => 'contact@validsoftware.ro',
            'password' => bcrypt('39143914'),
        ]);
        $user->save();
        // $user = \App\User::where('name', 'Vali Dima')->find(1);
        $user->roles()->sync(\App\Role::where('nume', 'administrator')->get());
            
    }
}
