<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class User extends Model
{
    protected $table = "user";

    protected $fillable = ['tel','code','pwd'];


    public $timestamps = false;

}


