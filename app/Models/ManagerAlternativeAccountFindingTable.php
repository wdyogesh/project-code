<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ManagerAlternativeAccountFindingTable extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   
    protected $table = 'manager_alternative_account_finding_table';
    protected $primaryKey = 'id';
    protected $fillable = ['main_manager_id','alternative_business_manager_account_user_id'];
    public $timestamps  = false;

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
