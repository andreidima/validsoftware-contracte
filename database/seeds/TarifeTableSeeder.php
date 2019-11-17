<?php

use Illuminate\Database\Seeder;

class TarifeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tarife')->insert([
            [
                'traseu_id' => '1',
                'tur_retur' => false,
                'adult' => '100',
                'copil' => '80',
                'animal_mic' => '50',
                'animal_mare' => '100',
            ],
            [
                'traseu_id' => '1',
                'tur_retur' => true,
                'adult' => '180',
                'copil' => '160',
                'animal_mic' => '100',
                'animal_mare' => '200',
            ],
            [
                'traseu_id' => '2',
                'tur_retur' => false,
                'adult' => '120',
                'copil' => '80',
                'animal_mic' => '50',
                'animal_mare' => '100',
            ],
            [
                'traseu_id' => '2',
                'tur_retur' => true,
                'adult' => '220',
                'copil' => '160',
                'animal_mic' => '100',
                'animal_mare' => '200',
            ],
        ]);
    }
}
