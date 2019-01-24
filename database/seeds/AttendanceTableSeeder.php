<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Model\Faculty;
use App\Model\Student;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $check_in_deadline = Carbon::createFromTime(9, 0, 0, 'UTC');
        $t = 0;
        $statusController = 0;

        for($i=0; $i<100; $i++){
            $student = DB::table('students')->inRandomOrder()->first();
            $check_in_time = $now->addMinutes(rand(-120, 120));
            $check_in_time = $check_in_time->addWeeks(rand(-100, 100));
            $check_out_time = $check_in_time->addHours(rand(5, 8));

            DB::table('attendances')->insert([
                'status' => ($now->gt($check_in_deadline)) ? 2 : (1 - $statusController),
                'student_id' => $student->id,
                'checked_in_at' => $check_in_time,
                'checked_out_at' => $check_out_time,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $t++;
            if(($t % 10) == 0) $statusController = 1;
            else $statusController = 0;
        }
        
    }
}
