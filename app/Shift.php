<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    public $fillable = ['code', 'name', 'timeIn','timeOut'];

   
}
