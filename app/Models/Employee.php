<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Employee extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;

    protected $table = 'employees';
    protected $primaryKey = 'id';
     protected $fillable = ['employee_id','manager_id','businessmanagers_employee_roles_id','created_record_date','updated_record_dtae','created_at','updated_at'];
    protected $hidden = array('created_at', 'updated_at');
    
 public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
