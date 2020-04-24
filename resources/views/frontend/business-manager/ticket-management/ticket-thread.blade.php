@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Subscriptions
@endsection
@section('pagelevel-styles')
@endsection
@section('content')
 <section class="content-header">
     
  
<section class="content">
    
     <div class="row">
        <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title"><b style="color:green">Subject:</b>{{$main_ticket['subject']}}</h3>
            </div>
            <div class="box-body">
        
              <div class="form-group">
                <label><b>Ticket Id:</b></label> {{$main_ticket['ticket_id']}}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Status:</b> </label> {{$main_ticket['status']}}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><b> Created Date:</b> </label>  {{$main_ticket['record_created_date']}}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label><b> Last Action:</b> </label>  {{$main_ticket['record_updated_date']}}
              </div>
            </div>
        </div>
          <!-- /.box -->
     </div>
@foreach($main_thread as $thread)
    <div class="row">
    	<div class="col-xs-2">
    	</div>
     	 <div class="col-xs-8">
     		 <div class="box box-success" style="border-top-color:brown;background: #ccc;">
            <div class="box-header">
            	<div style="clear: both">
				    <p style="float: left;color:white"><b style="color:yellow">Messaged By:</b> {{$thread['name']}}</p>
				    <p style="float: right;color:white"><b style="color:yellow">Date:</b> {{$thread['created_date']}}</p>
				</div>
				<hr />
              
               
            </div>
            <div class="box-body">
               <p>{!! $thread['message'] !!}</p>
            </div>
            @if($thread['file'] != "")
            <div class="box-body">
               <p>
               	 <a href="{{asset('uploads/ticketing-documents/' . $thread['file']) }}" title="Attachment" class="btn btn-default btn-xs pull-right" download><i class="fa fa-cloud-download"></i></a>
               </p>
            </div>
            @endif
        </div>
     	</div>
    </div>
@endforeach  
@if($main_ticket['closed'] != 1)   
    <div class="row">
    	           <form action="{{url('manager/reply-ticket')}}" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
                       {{ csrf_field() }}
                    <input type="hidden" name="ticket_id" value="{{$main_ticket['id']}}">   
                       <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Reply</label>
                                <div class="col-sm-8">
                                    <textarea  class="form-control" name="problem" style="height:100px">{{old('problem')}}</textarea>
				                    <span class="text-danger">{{ $errors->first('problem') }}</span>
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Attachment</label>
                                <div class="col-sm-8">
                                    <input type="file" name="attachments" class="form-control">
                                </div>
                            </div>


                  <div class="form-group" align="center">
                    <a href="{{url('manager/my-tickets')}}" class="btn btn-info">
                       Go back
                   </a>
                   <button type="submit" class="btn btn-success">Submit</button>
               </div>
                  </div>
                </div>  
           </form>
    </div>
@endif
  
@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
@endsection
