<?php

use Illuminate\Database\Seeder;

class TimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('times')->insert([
            [
                'name' => 'Happening Time',
                'start_time' => '06:00:00',
                'end_time' => '16:59:59',
            ],
        	[
                'name' => 'Night Time',
                'start_time' => '17:00:00',
                'end_time' => '00:59:59',
            ],
        	[
                'name' => 'NRB Time',
                'start_time' => '01:00:00',
                'end_time' => '05:59:59',
            ]
        ]);
    }
}
