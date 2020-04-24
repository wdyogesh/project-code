<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
     protected $table = 'audits';

     protected $dates = ['start_date_time', 'end_date_time'];

     public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
