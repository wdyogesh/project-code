<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class BusinessManagerSubscriptions extends Model implements Auditable
{
   use \OwenIt\Auditing\Auditable;
   
    protected $table = 'business_client_subscriptions';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','package_name','data_size','user_size_from','user_size_to','price','subscription_date','payment_status','currency_type','used_data'];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
