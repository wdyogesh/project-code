<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManagerClients extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   
    protected $table = 'manager_clients';
    protected $primaryKey = 'id';
    protected $hidden = array('created_at', 'updated_at');
    protected $fillable = ['id', 'client_id', 'manager_id','employee_id_created_by','created_record_date','updated_record_date'];
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
