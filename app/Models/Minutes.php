<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Minutes extends Model
{

    protected $table = 'mintes_table_additional';
    protected $primaryKey = 'id';
    protected $fillable = ['id','minuts_value'];  
}
