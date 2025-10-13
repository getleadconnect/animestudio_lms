<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_category')->insert(
			[
				'id'=>1,
				'category'	=> 'All',
				'status'=>1,
				'added_by'=>1,
			]);
    }
}
