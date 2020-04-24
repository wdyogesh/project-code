<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Hours extends Model
{

    protected $table = 'hours_table_additional';
    protected $primaryKey = 'id';
    protected $fillable = ['id','hours_values'];  
}
