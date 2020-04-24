<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MaddHatter\LaravelFullcalendar\Event;
use OwenIt\Auditing\Contracts\Auditable;

class AppointmentSettings extends Model implements Auditable
{
     use \OwenIt\Auditing\Auditable;
     protected $table = 'appointment_settings';
     protected $fillable = ['manager_id', 'time_slot_size','business_time_start','business_time_end','color_arrived','color_in_process','color_in_seen','color_in_dna','color_in_booked','advance_booking_weeks','calendar_time_range_from','calendar_time_range_to'];
     public static function getTableName()
     {
        return with(new static)->getTable();
     }
}
