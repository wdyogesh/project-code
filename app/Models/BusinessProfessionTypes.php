<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BusinessProfessionTypes extends Model
{
   
    protected $table = 'business_profession_types';
    protected $primaryKey = 'id';
    protected $hidden = array('created_at', 'updated_at');

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
