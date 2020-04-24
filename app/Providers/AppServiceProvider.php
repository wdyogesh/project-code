<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Appointments;
use App\Models\Calendar;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
use App\Models\Role;
use App\Models\Emails;
use App\Models\TrashMails;
use App\Models\ReadMails;
use App\Models\ImportantMails;
use App\Models\Employee;
use App\Models\UserAddresses;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);
      view()->composer('*', function($view){
        if(Auth::user()){
            $manager_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
            $manager_unread_table_messages=ReadMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
           //manager panel All underead inbox messages with check important message query
           $inbox_messages_unread_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
             })->whereNotIn('emails.id',$manager_trash_table_messages)->whereNotIn('emails.id',$manager_unread_table_messages)->where('to_id',Auth::user()->id)->select('*','emails.id as master_table_email_id')->count();

           //manager panel All read inbox messages with check important message query
          $all_inbox_read_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
          })->whereNotIn('emails.id',$manager_trash_table_messages)->whereIn('emails.id',$manager_unread_table_messages)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->count();
          //count of read and unred messages
          $total_red_unread_messages_count=$inbox_messages_unread_messages+$all_inbox_read_messages;

          //sent messages count
          $manager_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
          $sent_messages_count = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$manager_trash_table_messages)->where('from_id',Auth::user()->id)/*->where('manager_id',Auth::user()->id)*/->where('is_drafts',0)->where('master_message_id',NULL)->select('*','emails.id as master_table_email_id')->count();

          //manager panel draft messages
          $manager_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
            $draft_messages_count = Emails::leftJoin('important_emails as info', function($join){
                    $join->on('info.email_table_id', '=', 'emails.id');
                    $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
                })->whereNotIn('emails.id',$manager_trash_table_messages)->where('from_id',Auth::user()->id)->where('manager_id',Auth::user()->id)->where('is_drafts',1)->select('*','emails.id as master_table_email_id')->count();

          //manager panel important messages
           $manager_important_messages=ImportantMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
            $important_messages_count = Emails::leftJoin('important_emails as info', function($join){
                    $join->on('info.email_table_id', '=', 'emails.id');
                    $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
                })->whereIn('emails.id',$manager_important_messages)->select('*','emails.id as master_table_email_id')->count();

         //manager panel trash count
         $manager_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->where('is_perminant_delete',0)->pluck('email_table_id')->all();
          $trash_messages_count =Emails::leftJoin('important_emails as info', function($join){
                                  $join->on('info.email_table_id', '=', 'emails.id');
                                  $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
                              })->whereIn('emails.id',$manager_trash_table_messages)->select('*','emails.id as master_table_email_id')->count();

            $view->with('inbox_messages_unread_messages', $inbox_messages_unread_messages)
                 ->with('all_inbox_read_messages', $all_inbox_read_messages)
                 ->with('total_red_unread_messages_count', $total_red_unread_messages_count)
                 ->with('sent_messages_count', $sent_messages_count)
                 ->with('draft_messages_count', $draft_messages_count)
                 ->with('trash_messages_count', $trash_messages_count)
                 ->with('important_messages_count', $important_messages_count);
        }
      });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
