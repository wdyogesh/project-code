<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class TrashMails extends Model
{
     protected $table = 'trash_emails';
     protected $primaryKey = 'id';
     protected $fillable = ['email_table_id','user_id','page_name','is_perminant_delete','is_active','is_deleted'];
}
