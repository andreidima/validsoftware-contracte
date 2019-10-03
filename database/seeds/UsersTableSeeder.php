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
        DB::table('users')->insert([
            'name' => 'Vali Dima',
            'email' => 'contact@validsoftware.ro',
            'password' => bcrypt('39143914'),
        ]);
    }
}
