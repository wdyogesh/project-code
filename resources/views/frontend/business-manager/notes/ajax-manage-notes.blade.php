<div class="col-md-12">  
      @if(isset($all_client_notes))
      @foreach($all_client_notes as $notes)
          <div class="col-md-12">
            <!-- DIRECT CHAT PRIMARY -->
            <input type="hidden" value="{{$notes['client_id']}}" id="client_id">
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
      @else
      <h3 style="color:blue;" align="center">No Results Found</h3>
      @endif  
      </div>