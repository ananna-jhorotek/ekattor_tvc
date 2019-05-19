<?php

use Illuminate\Database\Seeder;

class BreaksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('break_types')->insert([
            [
                'name' => 'Before',
            ],
        	[
                'name' => 'Mid1',
            ],
        	[
                'name' => 'Mid2',
            ],
        	[
                'name' => 'Mid3',
            ]
        ]);
    }
}
