<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class FIrstTimeBusinessClientSubscription extends Model {

   
    protected $table = 'first_time_business_client_subscription';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id'];
}
