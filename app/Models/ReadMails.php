<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ReadMails extends Model
{
     protected $table = 'read_emails';
     protected $primaryKey = 'id';
     protected $fillable = ['email_table_id','user_id','is_read','is_deleted'];
}
