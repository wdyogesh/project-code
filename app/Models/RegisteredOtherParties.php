<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RegisteredOtherParties extends Model
{
    protected $table = 'registered_other_parties';
    protected $primaryKey = 'id';
    protected $fillable = ['other_party_id','manager_id','employee_id','invitation_table_record_id','active'];
}
