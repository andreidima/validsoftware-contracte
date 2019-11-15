<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OraseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orase')->insert([
            [
                'nume' => 'Adjud',
                'tara' => '1',                
            ],
            [
                'nume' => 'Albesti Paleologul',
                'tara' => '1',
            ],
            [
                'nume' => 'Bacau',
                'tara' => '1',
            ],
            [
                'nume' => 'Barlad',
                'tara' => '1',
            ],
            [
                'nume' => 'Braila',
                'tara' => '1',
            ],
            [
                'nume' => 'Brasov',
                'tara' => '1',
            ],
            [
                'nume' => 'Bucuresti',
                'tara' => '1',
            ],
            [
                'nume' => 'Buzau',
                'tara' => '1',
            ],
            [
                'nume' => 'Arluno',
                'tara' => '2',
            ],
            [
                'nume' => 'Asti',
                'tara' => '2',
            ],
            [
                'nume' => 'Barbisano',
                'tara' => '2',
            ],
            [
                'nume' => 'Belluno',
                'tara' => '2',
            ],
            [
                'nume' => 'Bergamo',
                'tara' => '2',
            ],
            [
                'nume' => 'Biella',
                'tara' => '2',
            ],
            [
                'nume' => 'Bolzano',
                'tara' => '2',
            ],
        ]);
        
    }
}
