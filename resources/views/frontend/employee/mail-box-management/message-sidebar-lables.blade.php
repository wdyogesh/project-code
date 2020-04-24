<div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Labels</h3>

        <div class="box-tools">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="{{url('employee/important-message')}}" style="{{ Request::is('employee/important-message')? 'color:green' : ''}}"><i class="fa fa-circle-o text-red"></i> Important<span class="label label-info pull-right">{{$important_messages_count}}</span></a></li>
         <!--  <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
          <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li> -->
        </ul>
      </div>
      <!-- /.box-body -->
    </div>