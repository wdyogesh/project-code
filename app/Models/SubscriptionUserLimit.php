<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SubscriptionUserLimit extends Model
{
   
    protected $table = 'subscription_user_limit';
    protected $primaryKey = 'id';
    protected $fillable = ['package_name','data_size','user_size_from','user_size_to','price'];
    protected $hidden = array('created_at', 'updated_at');
}
