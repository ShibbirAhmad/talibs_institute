<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Admin::create([

             'name' => 'shibbir',
             'email' => 'shibbirahmad@gmail.com',
             'phone' => '01759416979',
             'password' => bcrypt('123456'),
             'status' => 0,
        ]);
    }
}
