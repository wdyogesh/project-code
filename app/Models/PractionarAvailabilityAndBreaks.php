<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PractionarAvailabilityAndBreaks extends Model
{
    protected $table = 'practionar_availability_time_with_breaks';
    protected $primaryKey = 'id';
    protected $fillable = ['manager_id','practionar_employee_id','day_name','availability_start_time','availability_end_time','break1_start_time','break1_end_time','break2_start_time','break2_end_time','break3_start_time','break3_end_time'];
}
