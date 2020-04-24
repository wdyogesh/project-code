<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\UserResolver;
use Auth;


class User extends Authenticatable implements Auditable, UserResolver
{

    use Notifiable,\OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'account_verification','name','registration_id','surname' ,'email', 'password','country_code','area_code','phone_number','dateof_birth','security_question_id','answer','role_id','mail_group_manager_id','mail_group_common_user_id','mail_group_email_first_name','manager_account_alternativeaccount_identification_flag','created_record_date','updated_record_date','profile_pic','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
    protected static $roleModel = 'App\Models\Role';

    public function scopeAdmin($query)
    {
        return $query->where('role_id',1);
    }
    public function alternativeacount()
    {
        return $this->hasOne('App\Models\ManagerAlternativeAccountFindingTable', 'main_manager_id','id');
    }

    public function client()
    {
        return $this->hasOne('App\Models\ManagerClients', 'client_id','id');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employee','employee_id','id');
    }

    public function useraddresses()
    {
        return $this->hasOne('App\Models\UserAddresses','user_id','id');
    }

    public function businessdetails()
    {
        return $this->hasOne('App\Models\ManagerBusinessDetails','user_id','id');
    }

}
