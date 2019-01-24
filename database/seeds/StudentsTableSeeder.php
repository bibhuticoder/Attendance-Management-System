<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Model\Faculty;
use App\Model\Student;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculty = DB::table('faculties')->inRandomOrder()->first();
        DB::table('students')->insert([
            'id'   => 1,
            'full_name' => 'Ram Prasad',
            'faculty' => $faculty->name,
            'faculty_id' => $faculty->id,
            'roll_no' => substr(Carbon::now()->year . '', 1, 3) . substr($faculty->name, 0, 3) . '0'.Student::count(),
            'joined_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        $faculty = DB::table('faculties')->inRandomOrder()->first();
        DB::table('students')->insert([
            'id'   => 2,
            'full_name' => 'Hari Bahadur',
            'faculty' => $faculty->name,
            'faculty_id' => $faculty->id,
            'roll_no' => substr(Carbon::now()->year . '', 1, 3) . substr($faculty->name, 0, 3) . '0'.Student::count(),
            'joined_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $faculty = DB::table('faculties')->inRandomOrder()->first();
        DB::table('students')->insert([
            'id'   => 3,
            'full_name' => 'Shyam Prasad Surname',
            'faculty' => $faculty->name,
            'faculty_id' => $faculty->id,
            'roll_no' => substr(Carbon::now()->year . '', 1, 3) . substr($faculty->name, 0, 3) . '0'.Student::count(),
            'joined_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $faculty = DB::table('faculties')->inRandomOrder()->first();
        DB::table('students')->insert([
            'id'   => 4,
            'full_name' => 'Random Prasad Surname',
            'faculty' => $faculty->name,
            'faculty_id' => $faculty->id,
            'roll_no' => substr(Carbon::now()->year . '', 1, 3) . substr($faculty->name, 0, 3) . '0'.Student::count(),
            'joined_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}
