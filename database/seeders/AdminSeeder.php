<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use DB;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	   DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	   DB::table('admins')->insert([
			[
				'name'	=> 'admin',
				'center_id'	=>1,
				'email'	=> 'admin@gmail.com',
				'mobile'=>'1234567890',
				'role_id'=>1,
				'password'	=> Hash::make('12345'),
				'status'=>1
			],
			[
				'name'	=> 'Shaji',
				'center_id'	=>1,
				'email'	=> 'shaji@webqua.com',
				'mobile'=>'1234567891',
				'role_id'=>1,
				'password'	=> Hash::make('12345'),
				'status'=>1
			],
		]);
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
