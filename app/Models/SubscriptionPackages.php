<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SubscriptionPackages extends Model
{
   
    protected $table = 'subscription_packages';
    protected $primaryKey = 'id';
    protected $fillable = ['package_name','data_size'];
    protected $hidden = array('created_at', 'updated_at');
}
