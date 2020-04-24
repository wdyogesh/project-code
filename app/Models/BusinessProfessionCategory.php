<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BusinessProfessionCategory extends Model
{
   
    protected $table = 'business_profession_category';
    protected $primaryKey = 'id';
    protected $hidden = array('created_at', 'updated_at');

    public function professions()
    {
        return $this->hasMany('App\Models\BusinessProfessionTypes', 'business_profession_category_id','id');
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
