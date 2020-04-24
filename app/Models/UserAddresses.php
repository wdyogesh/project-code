<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserAddresses extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
   
    protected $table = 'user_addresses';
    protected $primaryKey = 'id';
     protected $fillable = ['user_id','country','state','city','pincode','address','created_at','updated_at'];
    protected $hidden = array('created_at', 'updated_at');

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    
 
}
