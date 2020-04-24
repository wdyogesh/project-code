<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ForgotCredentialRequests extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;

    protected $table = 'reset-credentials-link-send';
    protected $primaryKey = 'id';
    protected $fillable = ['id','request_id','business_manager_id','role_name','email','request_by_internal_user_id','request_by_manager_user_id','status','user_reset_complete','created_record_date','updated_record_dtae','created_at','updated_at'];  
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
