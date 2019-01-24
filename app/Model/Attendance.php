<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'status', 'student_id', 'checked_in_at', 'checked_out_at'
    ];

    public function student(){
        return $this->belongsTo('App\Model\Student');
    }
}
