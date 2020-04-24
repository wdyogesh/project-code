@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Client Notes
@endsection
@section('pagelevel-styles')
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper manager-content-wrapper">
  <section class="content">


      <div class="row">
         <div class="col-md-3">
          <a href"#" class="btn btn-primary btn-block margin-bottom"><h4>
          {{$client_record['name']}} {{$client_record['surname']}} / Notes
         </h4>
         </a>

          <div class="box box-solid">
            <div class="box-header with-border">
             <!--  <h3 class="box-title">Folders</h3> -->

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
           @include('frontend.business-manager.client-management.client-details-sidebar')
          </div>
        
        </div>
        <div class="col-md-9">

                <div class="box-footer">

                  <div class="col-md-10" >
                    <input type="text" name="message"  placeholder="Type Message ..." id="message" class="form-control">
                  </div>   
                  <div class="col-md-2"  >
                  <a href="{{url('manager/create-notes/'.Hashids::encode($client_record['id']))}}" class="btn btn btn-success btn-flat pull-right">Add Note</a>
                  </div>    
                </div><br>
       <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Deleted Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>
        @if(Session::has('success'))
       <div  align="center" id="successMessage"  class="alert alert-info">{{ Session::get('success') }}
       </div>
       @endif 
                   <input type="hidden" value="{{$client_id}}" id="client_id">

       <div id="ajaxnotes">
        <div class="col-md-12">  
      @if(isset($all_client_notes))
      @foreach($all_client_notes as $notes)
          <div class="col-md-12">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary">
              <div class="box-header with-border">
               <h3 class="box-title"> <b>{{$notes['consultation_type']}}</b></h3>
              </div>
              <!-- /.box-header -->

              <div class="box-body">
               <!-- /.box-body -->
              <div class="box-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <p class="box-title"> <b style="color:#367fa9">Added By: </b>{{$notes['consultation_type']}}</p><hr>
                    <p class="box-title"> <b style="color:#367fa9">Appointment: </b>{{$notes['appoiintment_date']}}</p><hr>

                    <p class="box-title"> <b style="color:#367fa9">Category: </b>{{$notes['category_name']}}</p><hr>
                    <p class="box-title"> <b style="color:#367fa9">Other Party: </b>{{$notes['other_party_name']}} [{{$notes['other_party_category']}}]</p><hr>
                    <h5 class="box-title"> <b style="color:#367fa9">Notes:</b>{!! $notes['notes'] !!}</h5><hr>
                     <p class="box-title"> <b style="color:#367fa9">Created Date: </b>{{$notes['created_record_date']}}</p><hr>
                        
                  </div>
                </form>
              </div>
              
              </div>
             <div class="box-header with-border">
             @if($notes['added_by_id'] == Auth::user()->id)
               <a href="{{url('manager/edit-client-notes/'.Hashids::encode($notes['notes_id']).'/'.Hashids::encode($notes['client_id']))}}" class="btn btn-info" title="Edit">
                 <span class="glyphicon glyphicon-pencil"></span>
               </a>
                <button class="btn btn-danger btn-delete delete-client" value="{{$notes['notes_id']}}" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
             @endif
            </div>

            </div>
            <!--/.direct-chat -->
          </div>
      @endforeach  
      @endif  
      </div>
      </div>
      </div>
      </div>
      <!-- /.row -->
    </section>
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
  var url = "{{url('manager/delete-client-notes')}}";
  $(document).on('click','.delete-client',function(){
    if(confirm('Are you sure want to delete?')){
      var user_id = $(this).val();
      /*alert(user_id);*/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      })
      $.ajax({
        type: "DELETE",
        url: url + '/' + user_id,         
        success: function (data) {
          console.log(data);
          $('#sucMsgDeleteDiv').show('slow');
          setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 500);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
  });


$("#message").on('keyup blur keypress', function() {

  var mesg = $("#message").val();
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
    })
  if(mesg.length == 0){
    $.ajax({
            type: "POST",
            url: "{{url('manager/searchnotes')}}",
            data: {search: '', client_id: $("#client_id").val()},
            success: function( msg ) {
              $("#ajaxnotes").empty();
              $("#ajaxnotes").append(msg);
              //alert(msg);
                //$("#ajaxResponse").append("<div>"+msg+"</div>");
            }
        });
  }else{
    if(mesg.length > 2) {

   $.ajax({
            type: "POST",
            url: "{{url('manager/searchnotes')}}",
            data: {search: mesg, client_id: $("#client_id").val()},
            success: function( msg ) {
              $("#ajaxnotes").empty();
              $("#ajaxnotes").append(msg);
              //alert(msg);
                //$("#ajaxResponse").append("<div>"+msg+"</div>");
            }
        });
  }
 }
})

</script>
@endsection
