<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FacultiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faculties')->insert([
            'id'   => 1,
            'name' => 'Computer Science',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('faculties')->insert([
            'id'   => 2,
            'name' => 'Biology',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('faculties')->insert([
            'id'   => 3,
            'name' => 'Physics',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('faculties')->insert([
            'id'   => 4,
            'name' => 'English',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('faculties')->insert([
            'id'   => 5,
            'name' => 'Social Work',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
