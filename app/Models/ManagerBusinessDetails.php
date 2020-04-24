<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManagerBusinessDetails extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   
    protected $table = 'manager_business_details';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'businesss_name', 'business_type', 'other_business_type', 'created_at', 'updated_at'];
    protected $hidden = array('created_at', 'updated_at');

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
