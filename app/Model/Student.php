<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'full_name', 'joined_at', 'faculty', 'roll_no', 'faculty_id'
    ];

    public function attendances(){
        return $this->hasMany('App\Model\Attendance');
    }

}
