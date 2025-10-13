<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_types')->insert([
				['id'=>1,'course_type'	=> 'Main'],
				['id'=>2,'course_type'	=> 'Latest Batches'],
				['id'=>3,'caourse_type'	=> 'Others']
			]);
    }
}
