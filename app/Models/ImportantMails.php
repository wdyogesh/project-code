<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ImportantMails extends Model
{
     protected $table = 'important_emails';
     protected $primaryKey = 'id';
     protected $fillable = ['email_table_id','user_id','is_important','is_deleted'];
}
