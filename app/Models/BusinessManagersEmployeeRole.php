<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class BusinessManagersEmployeeRole extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   
    protected $table = 'businessmanagers_employee_roles';
    protected $primaryKey = 'id';
    protected $fillable = ['employee_role_name','manager_id','','created_record_date','updated_record_dtae'];
    public $timestamps  = false;
    public function scopeManager($query)
    {
        return $query->where('manager_id',Auth::user()->id);
    }
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
