<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback_management';
    protected $primaryKey = 'id';
    protected $fillable = ['category_id','rating','business_client_id','created_record_date','updated_record_date'];

}
