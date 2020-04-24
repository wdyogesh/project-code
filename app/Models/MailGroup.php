<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MailGroup extends Model
{
    protected $table = 'email_group';
    protected $primaryKey = 'id';
    protected $fillable = ['group_user_id','selected_ids','manager_id'];
 }
