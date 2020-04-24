<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['role_name', 'role_slug', 'status', 'created_at', 'updated_at','created_record_date','updated_record_date'];
    //protected $hidden = array('created_at', 'updated_at');


    public function scopeManager($query)
    {
        return $query->where('business_managers_id_roles_identification',Auth::user()->id);
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
