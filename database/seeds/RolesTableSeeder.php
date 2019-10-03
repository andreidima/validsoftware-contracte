<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            [
                'name' => 'administrator',
                'descriere' => '',                
            ],
            [
                'name' => 'demo',
                'descriere' => '',
            ],
            [
                'name' => 'full',
                'descriere' => '',
            ]
        ]);
        
    }
}
