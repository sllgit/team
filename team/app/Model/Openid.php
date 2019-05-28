<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Openid extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'openid';
}
