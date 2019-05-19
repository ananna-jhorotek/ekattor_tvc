<?php

use Illuminate\Database\Seeder;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('days')->insert([
            [
                'name' => 'Sunday',
                'type' => 'Weekday',
            ],
            [
                'name' => 'Monday',
                'type' => 'Weekday',
            ],
            [
                'name' => 'Tuesday',
                'type' => 'Weekday',
            ],
            [
                'name' => 'Wednesday',
                'type' => 'Weekday',
            ],
            [
                'name' => 'Thursday',
                'type' => 'Weekday',
            ],
            [
                'name' => 'Friday',
                'type' => 'Weekend',
            ],
            [
                'name' => 'Saturday',
                'type' => 'Weekend',
            ]
        ]);
    }
}
