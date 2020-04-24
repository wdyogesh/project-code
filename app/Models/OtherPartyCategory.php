<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OtherPartyCategory extends Model
{
    protected $table = 'other_party_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['category_name','manager_id','employee_id','soft_delete','other_party_registered_category','created_record_date','updated_record_date'];
    public function OtherPartyInvitedUsers()
    {
        return $this->hasMany('App\Models\OtherPartyInvitedUsers','other_party_category_id','id');
    }
}
