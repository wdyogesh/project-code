<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MaddHatter\LaravelFullcalendar\Event;
use OwenIt\Auditing\Contracts\Auditable;

class Appointments extends Model implements Event,Auditable
{
     use \OwenIt\Auditing\Auditable;
     protected $table = 'appointments';


     protected $fillable = ['client_id', 'start_date_time','practionar_id','end_date_time', 'manager_id','employee_id_create_appoinment','cancellation','color','comment','arrived','record_created_date','record_updated_date','created_at','status','updated_at'];

     protected $dates = ['start_date_time', 'end_date_time'];
    
    
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return $this->is_all_day;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get the event's ID
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Optional FullCalendar.io settings for this event
     *
     * @return array
     */
    public function getEventOptions()
    {
        return [
            'color' => $this->background_color,
        ];
    }
}
