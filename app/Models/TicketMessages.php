<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TicketMessages extends Model
{
     protected $table = 'ticketing_messages';
     protected $fillable = ['ticket_id', 'message','attachments','manager_id','admin_id','common_user_id','record_created_date','record_updated_date']; 
}