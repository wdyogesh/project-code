<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Ticketings extends Model
{
     protected $table = 'ticketing';
     protected $fillable = ['ticket_id','business_name','subject','status','closed', 'manager_id','category','record_created_date','record_updated_date']; 
}
