<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'mid';
    protected $table = 'music';
}
