<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SecurityQuestions extends Model
{
   
    protected $table = 'security_questions';
    protected $primaryKey = 'id';
    protected $hidden = array('created_at', 'updated_at');

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
 
}
