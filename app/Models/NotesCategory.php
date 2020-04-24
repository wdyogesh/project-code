<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class NotesCategory extends Model implements Auditable
{
     use \OwenIt\Auditing\Auditable;
    protected $table = 'notes_category';
    protected $primaryKey = 'id';
    protected $fillable = ['category_name','manager_id','employee_id','common_user_id','created_record_date','updated_record_date','soft_delete'];
    //protected $hidden = array('created_at', 'updated_at');

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
