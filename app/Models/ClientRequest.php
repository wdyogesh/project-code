<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ClientRequest extends Model
{
     protected $table = 'client_request';
     protected $primaryKey = 'id';
     protected $fillable = ['client_id','manager_id','subject','message','othr_party_id','created_record_date','updated_record_date'];
}
