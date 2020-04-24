<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

/*1)ADMIN PANEL START*/
Route::group(['domain' => 'intell-comm.com'], function () {
	 Route::group(['middleware' => 'disablepreventback'],function(){
	 Route::group(['namespace' => 'SuperAdmin','prefix' => 'admin', 'middleware' => 'admin'],function(){
	 /*main admin dashboard-page displaying start*/
	 Route::get('dashboard','AdminController@dashboard');
	 /*main admin dashboard-page displaying end*/

	 /*managers client-management managemant start*/
	 Route::get('client-management','ClientController@index');
	 Route::get('create-business-client','ClientController@createBusinessClient');
	 Route::post('create-business-client','ClientController@postCreateBusinessClient');
	 Route::get('business-client-details/{managerid?}','ClientController@businesssManagerDetails');
	 Route::get('edit-business-client/{managerid?}','ClientController@editBusinesssManagerDetails');
	 Route::post('edit-business-client','ClientController@updateBusinesssManagerDetails');
	 Route::get('active-business-client/{managerid?}','ClientController@activeBusinesssManagerAccount');
	 Route::post('active-manager-account','ClientController@updateActivivation');
	 Route::get('trialperiod-business-clients-list','ClientController@trialPeriodClients');
	 /*managers client-management managemant end*/

	 /*subscriptions package managemant start*/
	 Route::get('subscription-plans','SubscriptionController@plans');
	 Route::get('crate-subscription-plans','SubscriptionController@createPlans');
	 Route::post('subscription-limit-users','SubscriptionController@subscriptionLimitUsers');
	 Route::get('edit-subscription-plan/{hashid?}','SubscriptionController@edit');
	 Route::post('subscription-update','SubscriptionController@update');
	 Route::delete('delete-subscription-package/{id?}','SubscriptionController@delete');
	 /*subscriptions package managemant end*/


	 /*Business client subscriptions managemant start*/
	 Route::get('business-cliens-subscriptions','BusinessManagersSubscriptions@index');
	 Route::get('business-level-subscriptions/{id?}','BusinessManagersSubscriptions@businessLevelSubscriptions');
	 /*Business client subscriptions managemant end*/

	 /*Admin in side software Mailing Box managemant start*/
	 Route::get('mail-box', ['as' => 'employee-manager-inbox', 'uses' => 'MailController@index']);
 	 Route::get('compose-message/{keyword?}', ['as' => 'employee-manager-compose', 'uses' => 'MailController@compose']);
	 Route::get('read-message-details/{id?}/{pagename?}', ['as' => 'manager-message-details-read', 'uses' => 'MailController@messageDetailsRead']);
	 Route::get('emial-data', ['as' => 'employee-all-emails', 'uses' => 'MailController@emailData']);
	 Route::post('send-mail', ['as' => 'employee-send-mail', 'uses' => 'MailController@postManagerSendMail']);
	 Route::get('sent-items', ['as' => 'employee-sent-items', 'uses' => 'MailController@sentItems']);
	 Route::get('drafts', ['as' => 'employee-drafts', 'uses' => 'MailController@drafts']);
	 Route::get('trash', ['as' => 'get-employee-trash', 'uses' => 'MailController@getTrash']);
	 Route::post('detail-message-trash', ['as' => 'employee-get-detail-message-trash', 'uses' => 'MailController@getDetailMessageTrash']);
	 Route::post('trash', ['as' => 'employee-trash', 'uses' => 'MailController@trash']);
	 Route::get('important-message', ['as' => 'get-employee-important', 'uses' => 'MailController@getImportant']);
	 Route::get('important/{id?}', ['as' => 'employee-important-message', 'uses' => 'MailController@important']);
	 Route::get('restore/{messageid?}', ['as' => 'employee-message-restore-from-trash', 'uses' => 'MailController@restore']);
	 Route::post('perminent-delete', ['as' => 'employee-permenent-delete-message-from-trash', 'uses' => 'MailController@perminentDelete']);
	 Route::post('detail-message--perminant-delete', ['as' => 'employee-detail-message-delete-complte-trash', 'uses' => 'MailController@getDetailMessagePerminantDelete']);
	 Route::get('reply-message/{message_id?}/{page_name?}',['as' => 'employee-reply-message', 'uses' => 'MailController@getReplyMessage']);
	 Route::post('reply-message-post',['as' => 'reply-message-post', 'uses' => 'MailController@postReplyMessage']);

  //new routs for grouping in messaging
    Route::get('manage-group','MailController@manageGroup');
    Route::get('add-group','MailController@addGroup');
    Route::post('add-group','MailController@storeGroup');
    Route::get('edit-group/{group_id?}','MailController@editGroup');
    Route::post('edit-group','MailController@posteditGroup');
    Route::delete('delete-group/{id?}','MailController@delete');
 /*Admin in side software Mailing Box managemant end*/

	 /*managers feedback managemant start*/
	 Route::get('feedback-categories','FeedBackCategoryController@index'); 
     Route::get('create-feedback-categories','FeedBackCategoryController@create');
     Route::post('create-feedback-categories','FeedBackCategoryController@storeCategory');
     Route::get('edit-feedback-categories/{id?}','FeedBackCategoryController@editCategory');
     Route::post('edit-feedback-categories','FeedBackCategoryController@update');
     Route::delete('delete-feedback-categories/{id?}','FeedBackCategoryController@delete');

     Route::get('manage-feedback','FeedbackController@index');
	 /*managers feedback managemant end*/

	  /*Other Party account configuration start(settings)*/
	 Route::get('profile','SettingsController@profile');
	 Route::get('edit-profile/{id?}','SettingsController@editProfile');
	 Route::post('edit-profile','SettingsController@updateProfile');
	 Route::get('change-password','SettingsController@changePassword');
	 Route::post('change-password','SettingsController@postPassword');
	 Route::post('edit-profile-picture','SettingsController@profielePicture');

	 /*admin ticketing  start(settings)*/
	 Route::get('my-tickets','TicketingController@index');
	 Route::get('create-ticket','TicketingController@create');
	 Route::post('send-ticket','TicketingController@send');
	 Route::get('open-thread/{id?}','TicketingController@thread');
	 Route::post('reply-ticket','TicketingController@reply');
	 Route::get('closed-tickets/{id?}','TicketingController@closedTicket');
	 /*admin ticketing plans end(settings)*/ 

	 /*admin send link for reset credentials  start*/
	 Route::get('send-reset-credentials-link','ResetCredentialsSendLink@index');
	 Route::get('send-reset-link/{role?}/{userid?}','ResetCredentialsSendLink@send')->name('admin-send-reset-link');
	 /*admin send link for reset credentials plans end*/ 
	});
	});
	Route::get('/admin','SuperAdmin\AdminController@index');
	Route::post('/admin/login','SuperAdmin\AdminController@login');
	Route::get('/admin/logout','SuperAdmin\AdminController@logout');
});

//................................. SUBDOMAIN START  ........................

Route::group(['domain' => '{subdomain}.intell-comm.com'], function () {
	   Route::get('/', 'Frontend\SubdomainController@index');
	   Route::get('re-set-security-question-password/{userid?}/{request_id?}', 'Frontend\HomeController@reSetSecurityquestion');
	   Route::post('re-set-security-question', 'Frontend\HomeController@updateResetSecurityquestion');
	   Route::get('user-re-set-password/{userid?}/{request_id?}', 'Frontend\HomeController@reSetPassword');
	   Route::post('user-re-set-password', 'Frontend\HomeController@updateReSetPassword');
	/*1)...... Business Manager panel subdomain start.....*/
	Route::group(['middleware' => 'disablepreventback'],function(){

	    Route::group(['namespace' => 'Frontend\Manager','prefix' => 'manager','middleware' => 'manager'],function(){
	 
			 /*managers dashboard-page displaying start*/
			 Route::get('/dashboard','ManagerControllerr@dashboard')->name('manager-dashboard');

			 Route::get('manager-verificatin-account','ManagerControllerr@verificationAccount')->name('manager-verificatin-account');
			 Route::get('manager-verificatin-account-link/{id?}','ManagerControllerr@verificationAccountLink')->name('manager-verificatin-account-link');
			 Route::get('manaager-verification-account-completion/{id?}','ManagerControllerr@verificationAccountComplete')->name('manaager-verification-account-completion');
			 /*managers dashboard-page displaying end*/
	 
			 /*managers employee managemant start*/
			 Route::get('employees','EmployeeController@index');
			 Route::get('create-employees','EmployeeController@create');
			 Route::post('store-employee','EmployeeController@store');
			 Route::get('edit-employee/{id}','EmployeeController@edit');
			 Route::post('update-employee','EmployeeController@update');
			 Route::delete('delete-employee/{id?}','EmployeeController@delete');
			 Route::get('employee-details/{id?}','EmployeeController@details');
			 /*managers employee managemant end*/

			 /*managers clients managemant start*/
			 Route::get('/clients','ClientController@index');
			 Route::get('/create-client','ClientController@create');
			 Route::post('store-client','ClientController@store');
			 Route::get('edit-client/{id}','ClientController@edit');
			 Route::post('update-client','ClientController@update');
			 Route::delete('delete-client/{id?}','ClientController@delete');
			 Route::get('client-details/{id?}','ClientController@details');
			
			    /*New Client Notes Routs start*/
			     Route::get('manage-notes-category','ClientNotesController@index');
			     Route::get('create-notes-category','ClientNotesController@create');
			     Route::post('create-notes-category','ClientNotesController@storeCategory');
			     Route::get('edit-notes-category/{id?}','ClientNotesController@editCategory');
			     Route::post('edit-notes-category','ClientNotesController@update');
			     Route::delete('delete-notes-category/{id?}','ClientNotesController@delete');

                 Route::get('notes/{hashclientid?}','NoteController@manageNotes'); 
                 Route::post('searchnotes','NoteController@searchNotes'); 
			     Route::get('create-notes/{hashclientid?}','NoteController@createNotes');
			     Route::post('create-notes','NoteController@postNotes');
			     Route::get('edit-client-notes/{notesid?}/{clientid?}','NoteController@editNotes');
			     Route::post('update-notes','NoteController@updateNotes');
			     Route::delete('delete-client-notes/{id?}','NoteController@deleteNotes');
			     Route::get('details/{notesid?}/{clientid?}','NoteController@notesDetails');
			     Route::get('client-attachments/{clientid?}/{attachmentheading?}','AttachmentsController@index');
			     Route::get('attach-file/{clientid?}','AttachmentsController@createAttachment');
			     Route::post('save-attachment','AttachmentsController@postAttachment');
			    Route::get('edit-attachment/{attachmentid?}/{clientid?}','AttachmentsController@editAttachment');
			     Route::post('update-attachment','AttachmentsController@updateAttachment');
			     Route::delete('delete-attachment/{id?}','AttachmentsController@deleteAttachment');

			     Route::get('client-appointments/{clientid?}','NoteController@appointments');
			    /*New Client Notes Routs end*/   

			 /*managers appointments managemant start*/
			 Route::get('/appointments/{id?}','AppointmentController@index');
			 Route::post('/store-appointment','AppointmentController@store');
			 Route::get('/client-info','AppointmentController@clientinfo');
			 Route::get('edit-client-appointment/{id}','AppointmentController@editAppointment');
			 Route::post('update-appointment','AppointmentController@updateAppointment');
			 Route::delete('delete-appointment/{id?}','AppointmentController@delelte');
			 Route::get('cancel-appointment/{id?}','AppointmentController@cancel');
			 Route::get('client-id/{id?}','AppointmentController@details');
			 Route::get('client-arrived-check/{appointmentid?}','AppointmentController@arrivedStatusCheck');
			 Route::get('client-dna-check/{appointmentid?}','AppointmentController@dnaStatusCheck');
			 Route::get('client-in-process-check/{appointmentid?}','AppointmentController@inprocessStatusCheck');
			 Route::get('client-seen-check/{appointmentid?}','AppointmentController@seenStatusCheck');
			 /*managers appointments managemant end*/


			 /*managers other-parties managemant start*/
			 Route::get('manage-other-party-category','OtherPartyCategoryController@index');
			 Route::get('create-other-party-category','OtherPartyCategoryController@create');
			 Route::post('store-other-party-category','OtherPartyCategoryController@store');
			 Route::get('edit-other-party-category/{id?}','OtherPartyCategoryController@edit');
			 Route::post('edit-other-party-category','OtherPartyCategoryController@update');
			 Route::get('delete-other-party-category/{id?}','OtherPartyCategoryController@delete');
			 Route::get('manage-other-parties','OtherPartyController@index')->name('managers-otherparty-management');
			 Route::get('other-party-details/{id?}','OtherPartyController@details')->name('manager-other-party-details');
			 Route::get('other-party-activation/{other_party_user_id?}/{manager_id?}','OtherPartyController@activeInactive')->name('manager-other-party-active_inactive');
			 Route::get('other-party-registration-by-manager','OtherPartyController@otherPartyRegistration');
			 Route::post('store-other-party','OtherPartyController@store');
			 /*managers other-parties managemant end*/

			 /*managers other-parties managemant start*/
			 Route::get('invite-other-party','OtherPartyInviteController@index');
			 Route::get('send-other-party-invitation','OtherPartyInviteController@getSendInvitation');
			 Route::post('send-other-party-invitation','OtherPartyInviteController@postSendInvitation');
			 Route::delete('delete-other-party-invitation/{id?}','OtherPartyInviteController@deleteInvitation');
			 /*managers other-parties managemant end*/

			 /*managers Audit managemant start*/
			 Route::get('audit-management','AuditController@index');
			 Route::get('audit-details/{id?}','AuditController@details');
			 /*managers Audit managemant end*/

 /*managers Mailing Box managemant start*/
 Route::get('mail-box/{keyword?}', ['as' => 'manager-inbox', 'uses' => 'MailController@index']);
 Route::get('compose-message/{keyword?}/{clientorotherparty?}', ['as' => 'manager-compose', 'uses' => 'MailController@compose']);
 Route::get('read-message-details/{id?}/{pagename?}', ['as' => 'manager-message-details-read', 'uses' => 'MailController@messageDetailsRead']);
 Route::get('emial-data', ['as' => 'all-emails', 'uses' => 'MailController@emailData']);
 Route::post('manager-send-mail', ['as' => 'manager-send-mail', 'uses' => 'MailController@postManagerSendMail']);
 Route::get('sent-items', ['as' => 'manager-sent-items', 'uses' => 'MailController@sentItems']);
 Route::get('drafts', ['as' => 'manager-drafts', 'uses' => 'MailController@drafts']);
 Route::get('trash', ['as' => 'get-manager-trash', 'uses' => 'MailController@getTrash']);
 Route::post('detail-message-trash', ['as' => 'manager-get-detail-message-trash', 'uses' => 'MailController@getDetailMessageTrash']);
 Route::post('trash', ['as' => 'manager-trash', 'uses' => 'MailController@trash']);
 Route::get('important-message', ['as' => 'get-manager-important', 'uses' => 'MailController@getImportant']);
 Route::get('important/{id?}', ['as' => 'manager-important-message', 'uses' => 'MailController@important']);
 Route::get('restore/{messageid?}', ['as' => 'manager-message-restore-from-trash', 'uses' => 'MailController@restore']);
 Route::post('perminent-delete', ['as' => 'manager-permenent-delete-message-from-trash', 'uses' => 'MailController@perminentDelete']);
 Route::post('detail-message--perminant-delete', ['as' => 'manager-detail-message-delete-complte-trash', 'uses' => 'MailController@getDetailMessagePerminantDelete']);
 Route::get('manager-reply-message/{message_id?}/{page_name?}',['as' => 'manager-reply-message', 'uses' => 'MailController@getReplyMessage']);
 Route::post('reply-message-post',['as' => 'reply-message-post', 'uses' => 'MailController@postReplyMessage']);

    //new routs for grouping in messaging
    Route::get('manage-group','MailController@manageGroup');
    Route::get('add-group','MailController@addGroup');
    Route::post('add-group','MailController@storeGroup');
    Route::get('edit-group/{group_id?}','MailController@editGroup');
    Route::post('edit-group','MailController@posteditGroup');
    Route::delete('delete-group/{id?}','MailController@delete');
 /*managers Mailing Box managemant end*/

			 /*managers account configuration start(settings)*/
			 Route::get('/profile','SettingsController@profile');
			 Route::get('/edit-profile/{id?}','SettingsController@editProfile');
			 Route::post('/edit-profile','SettingsController@updateProfile')->name('manager-edit-profile');
			 Route::get('/change-password','SettingsController@changePassword');
			 Route::post('/change-password','SettingsController@postPassword');
			 Route::post('edit-profile-picture','SettingsController@profielePicture');
			 /*managers account configuration end(settings)*/

			 /*managers ticketing  start*/
			 Route::get('my-tickets','TicketingController@index');
			 Route::get('create-ticket','TicketingController@create');
			 Route::post('send-ticket','TicketingController@send');
			 Route::get('open-thread/{id?}','TicketingController@thread');
			 Route::post('reply-ticket','TicketingController@reply');
			 /*managers ticketing plans end*/ 

			 /*managers send link for reset credentials  start*/
			 Route::get('send-reset-credentials-link','ResetCredentialsSendLink@index');
			 Route::get('send-reset-link/{role?}/{userid?}','ResetCredentialsSendLink@send');
			 /*managers send link for reset credentials plans end*/ 
						 

			 /*managers subscription plans start(settings)*/
			  Route::get('settings','SettingsController@settings');
			  //appointment settings by manager start
              Route::get('appointment-settings','AppointmentController@appointmentSettings');
              Route::post('appointment-settings','AppointmentController@postAppointmentSettings');
              Route::get('edit-appointment-settings/{id?}','AppointmentController@editAppointmentSettings');
              Route::post('appointment-settings-update','AppointmentController@updateAppointmentSettings');
              Route::get('face-to-face-consultation-settings','AppointmentController@allPractionars');
              Route::get('face-to-face-consultant-availability/{facetofaceempid?}/{dayname?}','AppointmentController@faceToFaceAvailabilityForm');
             Route::post('face-to-face-consultant-availability','AppointmentController@save');
              //appointment settings by manager end


			  Route::get('/subscriptions','SettingsController@subscriptions');
			  Route::post('/suscribe-package','SettingsController@postSubscribe');
			  Route::get('addmoney/stripe','AddMoneyController@payWithStripe');
			  Route::post('addmoney/stripe', 'AddMoneyController@postPaymentWithStripe');
			 /*managers subscription plans end(settings)*/ 
	    });
	});
		Route::get('manager-login','Frontend\Manager\ManagerControllerr@login')->name('manager-login');
		Route::post('manager-login','Frontend\Manager\ManagerControllerr@postLogin');
		Route::get('manager-logout','Frontend\Manager\ManagerControllerr@logout');
		Route::get('manager/regitered-security-questions-choosing/{managerid?}', 'Frontend\ForgotPasswordController@enterSecurityQuestion');
		Route::post('manager/check-security-question-answer', 'Frontend\ForgotPasswordController@checkSecurityQuestionAnswer');
		Route::get('manager/password-setup/{managerid?}', 'Frontend\ForgotPasswordController@passwordSetup');
		Route::post('manager/password-setup', 'Frontend\ForgotPasswordController@postSetupPassword');
		Route::get('manager-send-forgot-credentials-request/{managerid?}', 'Frontend\HomeController@sendManagerRequestToAdminForResetLink');
	/*1)......  Business Manager panel subdomain end.....*/


	
	/*2)......  Business Employee panel subdomain start.....*/
	   Route::group(['middleware' => 'disablepreventback'],function(){
        Route::group(['namespace' => 'Frontend\Employee','prefix' => 'employee', 'middleware' => 'employee'],function(){		
		 Route::get('dashboard','EmployeeController@dashboard')->name('employee-dashboard');
		 Route::get('employee-verificatin-account','EmployeeController@verificationAccount')->name('employee-verificatin-account');
		 Route::get('employee-verificatin-account-link/{id?}','EmployeeController@verificationAccountLink')->name('employee-verificatin-account-link');
		 Route::get('employee-verification-account-completion/{id?}','EmployeeController@verificationAccountComplete')->name('employee-verification-account-completion');
		 /*In employee dashboard client-managemant start*/
		         Route::get('/clients','ClientController@index');
				 Route::get('/create-client','ClientController@create');
				 Route::post('store-client','ClientController@store');
				 Route::get('edit-client/{id}','ClientController@edit');
				 Route::post('update-client','ClientController@update');
				 Route::delete('delete-client/{id?}','ClientController@delete');
				 Route::get('client-details/{id?}','ClientController@details');
		        /*Client Notes Routs start*/

			     Route::get('manage-notes-category','ClientNotesController@index');
			     Route::get('create-notes-category','ClientNotesController@create');
			     Route::post('create-notes-category','ClientNotesController@storeCategory');
			     Route::get('edit-notes-category/{id?}','ClientNotesController@editCategory');
			     Route::post('edit-notes-category','ClientNotesController@update');
			     Route::delete('delete-notes-category/{id?}','ClientNotesController@delete');
                 
                 Route::get('notes/{hashclientid?}','NoteController@manageNotes');
                 Route::post('searchnotes','NoteController@searchNotes'); 
			     Route::get('create-notes/{hashclientid?}','NoteController@createNotes');
			     Route::post('create-notes','NoteController@postNotes');
			     Route::get('edit-client-notes/{notesid?}/{clientid?}','NoteController@editNotes');
			     Route::post('update-notes','NoteController@updateNotes');
			     Route::delete('delete-client-notes/{id?}','NoteController@deleteNotes');
			     Route::get('details/{notesid?}/{clientid?}','NoteController@notesDetails');
			     Route::get('client-attachments/{clientid?}/{attachmentheading?}','AttachmentsController@index');
			     Route::get('attach-file/{clientid?}','AttachmentsController@createAttachment');
			     Route::post('save-attachment','AttachmentsController@postAttachment');
			     Route::get('edit-attachment/{attachmentid?}/{clientid?}','AttachmentsController@editAttachment');
			     Route::post('update-attachment','AttachmentsController@updateAttachment');
			     Route::delete('delete-attachment/{id?}','AttachmentsController@deleteAttachment');

			     Route::get('client-appointments/{clientid?}','NoteController@appointments');
			    /*Client Notes Routs end*/  
		 /*In employee dashboard client-managemant end*/

		 /*In employee dashboard appointment-managemant start*/
		 Route::get('/appointments/{id?}','AppointmentController@index');
		 Route::post('/store-appointment','AppointmentController@store');
		 Route::get('/client-info','AppointmentController@clientinfo');
		 Route::get('edit-client-appointment/{id}','AppointmentController@editAppointment');
		 Route::post('update-appointment','AppointmentController@updateAppointment');
		 Route::delete('delete-appointment/{id?}','AppointmentController@delelte');
		 Route::get('cancel-appointment/{id?}','AppointmentController@cancel');
		 /*In employee dashboard appointment-managemant end*/ 

		 /*employee in side software other-parties managemant start*/
		 Route::get('manage-other-parties','OtherPartyController@index')->name('employees-otherparty-management');
		 Route::get('other-party-details/{id?}','OtherPartyController@details')->name('employee-other-party-details');
		 Route::get('other-party-activation/{other_party_user_id?}/{manager_id?}','OtherPartyController@activeInactive')->name('employee-other-party-active_inactive');
		 Route::get('invite-other-party','OtherPartyInviteController@index')->name('employee-invitations');
		 Route::get('send-other-party-invitation','OtherPartyInviteController@getSendInvitation')->name('employee-send-invitation');
		 Route::post('send-other-party-invitation','OtherPartyInviteController@postSendInvitation')->name('employe-post-otherparty-invitation');
		 Route::delete('delete-other-party-invitation/{id?}','OtherPartyInviteController@deleteInvitation');
		 Route::get('other-party-registration-by-employee','OtherPartyController@otherPartyRegistration');
			 Route::post('store-other-party','OtherPartyController@store');
		 /*employee in side software other-parties managemant end*/

/*employee in side software Mailing Box managemant start*/
 Route::get('mail-box/{keyword?}', ['as' => 'employee-manager-inbox', 'uses' => 'MailController@index']);
 Route::get('compose-message/{keyword?}/{clientorotherparty?}', ['as' => 'employee-manager-compose', 'uses' => 'MailController@compose']);
 Route::get('read-message-details/{id?}/{pagename?}', ['as' => 'manager-message-details-read', 'uses' => 'MailController@messageDetailsRead']);
 Route::get('emial-data', ['as' => 'employee-all-emails', 'uses' => 'MailController@emailData']);
 Route::post('send-mail', ['as' => 'employee-send-mail', 'uses' => 'MailController@postManagerSendMail']);
 Route::get('sent-items', ['as' => 'employee-sent-items', 'uses' => 'MailController@sentItems']);
 Route::get('drafts', ['as' => 'employee-drafts', 'uses' => 'MailController@drafts']);
 Route::get('trash', ['as' => 'get-employee-trash', 'uses' => 'MailController@getTrash']);
 Route::post('detail-message-trash', ['as' => 'employee-get-detail-message-trash', 'uses' => 'MailController@getDetailMessageTrash']);
 Route::post('trash', ['as' => 'employee-trash', 'uses' => 'MailController@trash']);
 Route::get('important-message', ['as' => 'get-employee-important', 'uses' => 'MailController@getImportant']);
 Route::get('important/{id?}', ['as' => 'employee-important-message', 'uses' => 'MailController@important']);
 Route::get('restore/{messageid?}', ['as' => 'employee-message-restore-from-trash', 'uses' => 'MailController@restore']);
 Route::post('perminent-delete', ['as' => 'employee-permenent-delete-message-from-trash', 'uses' => 'MailController@perminentDelete']);
 Route::post('detail-message--perminant-delete', ['as' => 'employee-detail-message-delete-complte-trash', 'uses' => 'MailController@getDetailMessagePerminantDelete']);
 Route::get('employee-reply-message/{message_id?}/{page_name?}',['as' => 'employee-reply-message', 'uses' => 'MailController@getReplyMessage']);
 Route::post('reply-message-post',['as' => 'reply-message-post', 'uses' => 'MailController@postReplyMessage']);

  //new routs for grouping in messaging
    Route::get('manage-group','MailController@manageGroup');
    Route::get('add-group','MailController@addGroup');
    Route::post('add-group','MailController@storeGroup');
    Route::get('edit-group/{group_id?}','MailController@editGroup');
    Route::post('edit-group','MailController@posteditGroup');
    Route::delete('delete-group/{id?}','MailController@delete');
 /*employee in side software Mailing Box managemant end*/

		 /*employee account configuration start(settings)*/
		 Route::get('/profile','SettingsController@profile')->name('employee-profile-details');
		 Route::get('/edit-profile/{id?}','SettingsController@editProfile')->name('employee-edit-profile');
		 Route::post('/edit-profile','SettingsController@updateProfile')->name('employee-post-profile');
		 Route::get('/change-password','SettingsController@changePassword')->name('employee-change-password');
		 Route::post('/change-password','SettingsController@postPassword')->name('employee-post-change-password');
		 Route::post('edit-profile-picture','SettingsController@profielePicture');
		});
		});
        Route::get('/set-security-question/{id?}', 'Frontend\HomeController@setSecurityQuestions');
        Route::post('/set-security-question/{id?}', 'Frontend\HomeController@insertSecurityQuestions');
        Route::get('set-password/{id?}', 'Frontend\HomeController@setPassword');
        Route::post('set-password', 'Frontend\HomeController@postSetPassword');
		Route::get('employee-login','Frontend\Employee\EmployeeController@login')->name('employee-login');
		Route::post('employee-login','Frontend\Employee\EmployeeController@postLogin');
		Route::get('employee-logout','Frontend\Employee\EmployeeController@logout');
		Route::get('employee/forgot-password', 'Frontend\EmployeeForgotPasswordController@mailcheck');
		Route::post('employee/forgot-password', 'Frontend\EmployeeForgotPasswordController@postMailcheck');
		Route::get('employee/regitered-security-questions-choosing/{managerid?}', 'Frontend\EmployeeForgotPasswordController@enterSecurityQuestion');
		Route::post('employee/check-security-question-answer', 'Frontend\EmployeeForgotPasswordController@checkSecurityQuestionAnswer');
		Route::get('employee/password-setup/{managerid?}', 'Frontend\EmployeeForgotPasswordController@passwordSetup');
		Route::post('employee/password-setup', 'Frontend\EmployeeForgotPasswordController@postSetupPassword');
		Route::get('employee-send-forgot-credentials-request/{employeeid?}', 'Frontend\HomeController@sendEmployeeRequestToManagerForResetLink')->name("sendlink");
	/*2)...... Business Employee panel subdomain end.....*/



	/*3)...... (pending integration)  Business client panel subdomain start.....*/
	 Route::group(['middleware' => 'disablepreventback'],function(){
        Route::group(['namespace' => 'Frontend\Client','prefix' => 'client', 'middleware' => 'client'],function(){		
		 Route::get('dashboard','ClientController@dashboard')->name('client-dashboard');
		 Route::get('client-verificatin-account','ClientController@verificationAccount')->name('client-verificatin-account');
		 Route::get('verificatin-account-link/{id?}','ClientController@verificationAccountLink')->name('client-verificatin-account-link');
		 Route::get('verification-account-completion/{id?}','ClientController@verificationAccountComplete')->name('client-verification-account-completion');

         /*Client Notes Routs start*/
			     Route::get('manage-notes','ClientNotesController@manageNotes');
			     Route::get('create-notes','ClientNotesController@createNotes');
			     Route::post('create-notes','ClientNotesController@postNotes');
			     Route::get('edit-notes/{id?}','ClientNotesController@editNotes');
			     Route::post('update-notes','ClientNotesController@updateNotes');
			     Route::delete('delete-notes/{id?}','ClientNotesController@deleteNotes');
			     Route::get('note-details/{id?}','ClientNotesController@notesDetails');
		/*Client Notes Routs end*/  
		 /*In employee dashboard client-managemant end*/
		
/*client in side software Mailing Box managemant start*/
 Route::get('mail-box/{keyword?}', ['as' => 'employee-manager-inbox', 'uses' => 'MailController@index']);
 Route::get('compose-message/{keyword?}', ['as' => 'employee-manager-compose', 'uses' => 'MailController@compose']);
 Route::get('read-message-details/{id?}/{pagename?}', ['as' => 'manager-message-details-read', 'uses' => 'MailController@messageDetailsRead']);
 Route::get('emial-data', ['as' => 'employee-all-emails', 'uses' => 'MailController@emailData']);
 Route::post('send-mail', ['as' => 'employee-send-mail', 'uses' => 'MailController@postManagerSendMail']);
 Route::get('sent-items', ['as' => 'employee-sent-items', 'uses' => 'MailController@sentItems']);
 Route::get('drafts', ['as' => 'employee-drafts', 'uses' => 'MailController@drafts']);
 Route::get('trash', ['as' => 'get-employee-trash', 'uses' => 'MailController@getTrash']);
 Route::post('detail-message-trash', ['as' => 'employee-get-detail-message-trash', 'uses' => 'MailController@getDetailMessageTrash']);
 Route::post('trash', ['as' => 'employee-trash', 'uses' => 'MailController@trash']);
 Route::get('important-message', ['as' => 'get-employee-important', 'uses' => 'MailController@getImportant']);
 Route::get('important/{id?}', ['as' => 'employee-important-message', 'uses' => 'MailController@important']);
 Route::get('restore/{messageid?}', ['as' => 'employee-message-restore-from-trash', 'uses' => 'MailController@restore']);
 Route::post('perminent-delete', ['as' => 'employee-permenent-delete-message-from-trash', 'uses' => 'MailController@perminentDelete']);
 Route::post('detail-message--perminant-delete', ['as' => 'employee-detail-message-delete-complte-trash', 'uses' => 'MailController@getDetailMessagePerminantDelete']);
 Route::get('employee-reply-message/{message_id?}/{page_name?}',['as' => 'employee-reply-message', 'uses' => 'MailController@getReplyMessage']);
 Route::post('reply-message-post',['as' => 'reply-message-post', 'uses' => 'MailController@postReplyMessage']);

  //new routs for grouping in messaging
    Route::get('manage-group','MailController@manageGroup');
    Route::get('add-group','MailController@addGroup');
    Route::post('add-group','MailController@storeGroup');
    Route::get('edit-group/{group_id?}','MailController@editGroup');
    Route::post('edit-group','MailController@posteditGroup');
    Route::delete('delete-group/{id?}','MailController@delete');
 /*client in side software Mailing Box managemant end*/

 //client appointments strat
  Route::get('my-appointments','AppointmentController@index');
 //client appointments end

		 /*employee account configuration start(settings)*/
		 Route::get('/profile','SettingsController@profile')->name('client-profile-details');
		 Route::get('/edit-profile/{id?}','SettingsController@editProfile')->name('client-edit-profile');
		 Route::post('/edit-profile','SettingsController@updateProfile')->name('client-post-profile');
		 Route::get('/change-password','SettingsController@changePassword')->name('client-change-password');
		 Route::post('/change-password','SettingsController@postPassword')->name('client-post-change-password');
		 Route::post('edit-profile-picture','SettingsController@profielePicture');
		});
		});
		Route::get('client-set-security-question/{id?}', 'Frontend\ClientSetPasswordAndSecurityQuestion@setSecurityQuestions');
        Route::post('/client-set-security-question/{id?}', 'Frontend\ClientSetPasswordAndSecurityQuestion@insertSecurityQuestions');
        Route::get('client-set-password/{id?}', 'Frontend\ClientSetPasswordAndSecurityQuestion@setPassword');
        Route::post('client-set-password', 'Frontend\ClientSetPasswordAndSecurityQuestion@postSetPassword');

		Route::get('client-login','Frontend\Client\ClientController@login')->name('client-login');
		Route::post('client-login','Frontend\Client\ClientController@postLogin');
		Route::get('client-logout','Frontend\Client\ClientController@logout');
		Route::get('client/forgot-password', 'Frontend\ClientForgotPassword@mailcheck');
		Route::post('client/forgot-password', 'Frontend\ClientForgotPassword@postMailcheck');
		Route::get('client/regitered-security-questions-choosing/{managerid?}', 'Frontend\ClientForgotPassword@enterSecurityQuestion');
		Route::post('client/check-security-question-answer', 'Frontend\ClientForgotPassword@checkSecurityQuestionAnswer');
		Route::get('client/password-setup/{managerid?}', 'Frontend\ClientForgotPassword@passwordSetup');
		Route::post('client/password-setup', 'Frontend\ClientForgotPassword@postSetupPassword');
		Route::get('client-send-forgot-credentials-request/{clientid?}', 'Frontend\HomeController@sendClientRequestToManagerForResetLink');
	/*3)...... Business client panel subdomain end.....*/


	/*4)...... Business client panel other party start.....*/
	 Route::group(['middleware' => 'disablepreventback'],function(){
        Route::group(['namespace' => 'Frontend\OtherParty','prefix' => 'other-party', 'middleware' => 'otherparty'],function(){		
		 Route::get('dashboard','OtherPartyController@dashboard')->name('otherparty-dashboard');
		 Route::get('verificatin-account','OtherPartyController@verificationAccount')->name('otherparty-verificatin-account');
		 Route::get('verificatin-account-link/{id?}','OtherPartyController@verificationAccountLink')->name('otherparty-verificatin-account-link');
		 Route::get('verification-account-completion/{id?}','OtherPartyController@verificationAccountComplete')->name('otherparty-verification-account-completion');

		 /*Other Party in side software Mailing Box managemant start*/
 Route::get('mail-box/{keyword?}', ['as' => 'employee-manager-inbox', 'uses' => 'MailController@index']);
 Route::get('compose-message/{keyword?}', ['as' => 'employee-manager-compose', 'uses' => 'MailController@compose']);
 Route::get('read-message-details/{id?}/{pagename?}', ['as' => 'manager-message-details-read', 'uses' => 'MailController@messageDetailsRead']);
 Route::get('emial-data', ['as' => 'employee-all-emails', 'uses' => 'MailController@emailData']);
 Route::post('send-mail', ['as' => 'employee-send-mail', 'uses' => 'MailController@postManagerSendMail']);
 Route::get('sent-items', ['as' => 'employee-sent-items', 'uses' => 'MailController@sentItems']);
 Route::get('drafts', ['as' => 'employee-drafts', 'uses' => 'MailController@drafts']);
 Route::get('trash', ['as' => 'get-employee-trash', 'uses' => 'MailController@getTrash']);
 Route::post('detail-message-trash', ['as' => 'employee-get-detail-message-trash', 'uses' => 'MailController@getDetailMessageTrash']);
 Route::post('trash', ['as' => 'employee-trash', 'uses' => 'MailController@trash']);
 Route::get('important-message', ['as' => 'get-employee-important', 'uses' => 'MailController@getImportant']);
 Route::get('important/{id?}', ['as' => 'employee-important-message', 'uses' => 'MailController@important']);
 Route::get('restore/{messageid?}', ['as' => 'employee-message-restore-from-trash', 'uses' => 'MailController@restore']);
 Route::post('perminent-delete', ['as' => 'employee-permenent-delete-message-from-trash', 'uses' => 'MailController@perminentDelete']);
 Route::post('detail-message--perminant-delete', ['as' => 'employee-detail-message-delete-complte-trash', 'uses' => 'MailController@getDetailMessagePerminantDelete']);
 Route::get('employee-reply-message/{message_id?}/{page_name?}',['as' => 'employee-reply-message', 'uses' => 'MailController@getReplyMessage']);
 Route::post('reply-message-post',['as' => 'reply-message-post', 'uses' => 'MailController@postReplyMessage']);

  //new routs for grouping in messaging
    Route::get('manage-group','MailController@manageGroup');
    Route::get('add-group','MailController@addGroup');
    Route::post('add-group','MailController@storeGroup');
    Route::get('edit-group/{group_id?}','MailController@editGroup');
    Route::post('edit-group','MailController@posteditGroup');
    Route::delete('delete-group/{id?}','MailController@delete');
 /*Other Party in side software Mailing Box managemant end*/

		 /*Other Party account configuration start(settings)*/
		 Route::get('/profile','SettingsController@profile')->name('otherparty-profile-details');
		 Route::get('/edit-profile/{id?}','SettingsController@editProfile')->name('otherparty-edit-profile');
		 Route::post('/edit-profile','SettingsController@updateProfile')->name('otherparty-post-profile');
		 Route::get('/change-password','SettingsController@changePassword')->name('otherparty-change-password');
		 Route::post('/change-password','SettingsController@postPassword')->name('otherparty-post-change-password');
		 Route::post('edit-profile-picture','SettingsController@profielePicture');
		 });
		 });
	    Route::get('/other-party-set-security-question/{id?}', 'Frontend\OtherPartySetPasswordAndSecurityQuestion@setSecurityQuestions');
        Route::post('/other-party-set-security-question/{id?}', 'Frontend\OtherPartySetPasswordAndSecurityQuestion@insertSecurityQuestions');
        Route::get('other-party-set-password/{id?}', 'Frontend\OtherPartySetPasswordAndSecurityQuestion@setPassword');
        Route::post('other-party-set-password', 'Frontend\OtherPartySetPasswordAndSecurityQuestion@postSetPassword');
        Route::get('business-other-party-users-registration/{invitation_id?}/{category_id?}','Frontend\OtherParty\OtherPartyController@create')->name('other-party-user-registration');
        Route::post('other-party-registration','Frontend\OtherParty\OtherPartyController@save')->name('other-party-registration');
        Route::get('other-party-login','Frontend\OtherParty\OtherPartyController@login')->name('other-party-login');
		Route::post('other-party-login','Frontend\OtherParty\OtherPartyController@postLogin');
		Route::get('other-party-logout','Frontend\OtherParty\OtherPartyController@logout');
		Route::get('other-party/forgot-password', 'Frontend\OtherPartForgotPassword@mailcheck');
		Route::post('other-party/forgot-password', 'Frontend\OtherPartForgotPassword@postMailcheck');
		Route::get('other-party/regitered-security-questions-choosing/{managerid?}', 'Frontend\OtherPartForgotPassword@enterSecurityQuestion');
		Route::post('other-party/check-security-question-answer', 'Frontend\OtherPartForgotPassword@checkSecurityQuestionAnswer');
		Route::get('other-party/password-setup/{managerid?}', 'Frontend\OtherPartForgotPassword@passwordSetup');
		Route::post('other-party/password-setup', 'Frontend\OtherPartForgotPassword@postSetupPassword');
		Route::get('other-party-send-forgot-credentials-request/{otherpartyid?}', 'Frontend\HomeController@sendOtherPartyRequestToManagerForResetLink');
	/*4)...... Business client panel other party end.....*/
});
//................................. SUBDOMAIN END  ........................

Route::group(['domain' => 'intell-comm.com'], function () {
    Route::get('manager-registration','Frontend\Manager\ManagerControllerr@businessManagerRegistration');
	Route::post('manager-registration', 'Frontend\Manager\ManagerControllerr@postBusinessManagerRegistration');
	Route::get('login-category','Frontend\LoginFrontsideAllCategory@index');
	//manager from main page login start
	Route::get('manager-login','Frontend\Manager\ManagerControllerr@getManagerMailWithLogin');
	Route::post('manager-mail-access','Frontend\Manager\ManagerControllerr@postManagerMailWithLogin');
    //manager from main page login end

    //employee from main page login start
	Route::get('employee-login','Frontend\LoginFrontsideAllCategory@getEmployeeMailWithLogin');
	Route::post('employee-mail-access','Frontend\LoginFrontsideAllCategory@postEmployeeMailWithLogin');
	Route::get('choose-business-account','Frontend\LoginFrontsideAllCategory@chooseBusinessIfUserHasOneMore')->name('choose-business');
    //employee from main page login end

    //client from main page login start
	Route::get('client-login','Frontend\LoginFrontsideAllCategory@getClientMailWithLogin');
	Route::post('client-mail-access','Frontend\LoginFrontsideAllCategory@postClientMailWithLogin');
    Route::get('choose-client-business-account','Frontend\LoginFrontsideAllCategory@chooseBusinessIfClientHasOneMore')->name('choose-client-business');
    //client from main page login end 

    //other-party from main page login start
	Route::get('other-party-login','Frontend\LoginFrontsideAllCategory@getOtherPartyMailWithLogin');
	Route::post('other-party-mail-access','Frontend\LoginFrontsideAllCategory@postOtherPartyMailWithLogin');
	Route::get('choose-other-party-business-account','Frontend\LoginFrontsideAllCategory@chooseBusinessIfOtherPartyHasOneMore')->name('choose-other-party-business');
    //other-party from main page login end

	/*Main home page start*/
	Route::get('/', 'Frontend\HomeController@index');
	/*Main home page end*/

	//Route::get('api/dependent-dropdown','APIController@index');

});

Route::get('api/get-state-list','APIController@getStateList');
Route::get('api/get-city-list','APIController@getCityList');
Route::get('api/country-and-codes/{name?}', 'APIController@countrycodes');