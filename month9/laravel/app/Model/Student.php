<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = ['name','sex','age'];

    public $timestamps = true;

    public function getDateFormat()
    {
        return time();
    }
}
