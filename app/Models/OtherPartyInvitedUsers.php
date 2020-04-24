<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class OtherPartyInvitedUsers extends Model
{
    protected $table = 'other_party_invited_users';
    protected $primaryKey = 'id';
     protected $fillable = ['other_party_category_id','other_party_name','other_party_email','manager_id','employee_id','register_by_manager','register_by_employee','registration_completed','created_record_date','updated_record_date'];
    public function OtherPartyRegisteredUsers()
    {
        return $this->hasOne('App\Models\RegisteredOtherParties','invitation_table_record_id','id');
    }
}
