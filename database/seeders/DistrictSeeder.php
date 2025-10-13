<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class DistrictSeeder extends Seeder
{
   
   /**
     * Run the database seeds.
     *
     * @return void
     */
	 
    public function run()
    {
        DB::table('districts')->insert([
			['id'=>1, 'district'=>'Thirunananthapuram', 'status'=>1],
			['id'=>2, 'district'=>'Kollam', 'status'=>1],
			['id'=>3, 'district'=>'Pathanamthitta', 'status'=>1],
			['id'=>4, 'district'=>'Idukki', 'status'=>1],
			['id'=>5, 'district'=>'Kottayam', 'status'=>1],
			['id'=>6, 'district'=>'Alappuzha', 'status'=>1],
			['id'=>7, 'district'=>'Ernakulam', 'status'=>1],
			['id'=>8, 'district'=>'Thrissur', 'status'=>1],
			['id'=>9, 'district'=>'Palakkad', 'status'=>1],
			['id'=>10, 'district'=>'Malappuram', 'status'=>1],
			['id'=>11, 'district'=>'Kozhikode', 'status'=>1],
			['id'=>12, 'district'=>'Wayanad','status'=> 1],
			['id'=>13, 'district'=>'Kannur', 'status'=>1],
			['id'=>14, 'district'=>'Kasaragod', 'status'=>1],
		]);
    }
}
