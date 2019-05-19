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
            'name' => 'Sharmeen',
            'email' => 'ananna@jhorotek.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'status' => '1',
        ]);
    }
}
