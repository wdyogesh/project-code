<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Emails extends Model
{
     protected $table = 'emails';
     protected $primaryKey = 'id';
     protected $fillable = ['manager_id','employee_id','common_user_id','subject','to_id','from_id','message','attachments','date','is_active','is_drafts','is_read','is_sent','is_notify','is_deleted','is_important','email_address','master_message_id'];
}
