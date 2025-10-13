<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('centers')->insert(
				['id'=>1,
				'center_name'	=> 'AIM BLSY',
				'address'=>'Balussery',
				'email'=>'info@aimbalussery.com',
				'mobile'=>'1234567890',
				'status'=>1,
				'added_by'=>1
				]);
    }
}
