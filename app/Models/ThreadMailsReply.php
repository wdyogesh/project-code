<?php 
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class ThreadMailsReply extends Model
{
    protected $table = 'thread_messsage_reply';
    protected $primaryKey = 'id';
     protected $fillable = ['master_message_id','sub_message_id'];
}
