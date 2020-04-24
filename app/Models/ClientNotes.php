<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class ClientNotes extends Model implements Auditable
{
     use \OwenIt\Auditing\Auditable;
    protected $table = 'client_notes';
    protected $primaryKey = 'id';
   /* protected $fillable = ['client_id','category_name','notes','manager_id','employee_id','common_user_id','file_name','other_party_id','created_record_date','updated_record_date'];*/
    protected $fillable = ['client_id','consultation_type','appointment_id','category_name','notes','manager_id','employee_id','common_user_id','other_party_id','created_record_date','updated_record_date'];
    //protected $hidden = array('created_at', 'updated_at');

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
