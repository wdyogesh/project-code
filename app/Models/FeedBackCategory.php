<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FeedBackCategory extends Model
{
    protected $table = 'feedback_category';
    protected $primaryKey = 'id';
    protected $fillable = ['category_name','created_record_date','updated_record_date'];

}
