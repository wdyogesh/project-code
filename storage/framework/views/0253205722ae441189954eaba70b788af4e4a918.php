<?php $__env->startSection('admin-title'); ?>
Admin-Create Business Clients
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Business Client Record</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
         <form class="bootstrap-modal-form" action="<?php echo e(url('admin/edit-business-client')); ?>" method="post" files='true'>
            <?php echo e(csrf_field()); ?>

        <div class="box-body">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Business Name</label>
                <input type=text name='business_name' class="form-control" id="textname" value="<?php echo e($business_manager_details['businesss_name']); ?>" readonly>
              </div>
            </div> 
              <!-- /.form-group -->
            <div class="col-md-6">  
              <div class="form-group">
               <label>Business Type</label>
                <select id="purpose" name="business_category_type" class="form-control select2" style="width: 100%;">
                  <option value="" selected>select..</option>
                  <?php $__currentLoopData = $business_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business_categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option disabled="disabled"><?php echo e($business_categorie->category_name); ?></option>
                  <?php $__currentLoopData = $business_categorie->professions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profession): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option <?php if($business_manager_details['business_type'] == $profession->business_profession_type &&  $business_manager_details['other_business_type'] != 1): ?> selected="select" <?php endif; ?> value="<?php echo e($profession->business_profession_type); ?>"><?php echo e($profession->business_profession_type); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  <option <?php if($business_manager_details['other_business_type'] == 1): ?> selected="select" <?php endif; ?> value="Other professions" style="color:green;font-size:17px; ">Other professions</option> 
                </select>
              </div>
            </div>  
              <!-- /.form-group -->
          </div>
        
          <div class="row"  style='display:none;' id='business_type'>
            <div class="col-md-6">
              <div class="form-group">
                <label>Profession Type</label>
                <input type="text" class="form-control" name="other_business" <?php if($business_manager_details['other_business_type'] == 1): ?>value="<?php echo e($business_manager_details['business_type']); ?>" <?php else: ?> value="" <?php endif; ?> maxlength="20">
              </div>
            </div> 
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>First Name</label>
                <input type=text name='first_name' class="form-control" value="<?php echo e($business_manager_details['name']); ?>" id="textname" maxlength="20">
              </div>
            </div> 
              <!-- /.form-group -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Sur Name</label>
                <input type=text name='surname'  value="<?php echo e($business_manager_details['surname']); ?>" class="form-control" id="textname" maxlength="20">
              </div>
            </div>

             <div class="col-md-4">
              <div class="form-group">
                 <label for="pwd">Email</label>
                 <input type="text" class="form-control" name="email"  value="<?php echo e($business_manager_details['email']); ?>" maxlength="40" readonly>
              </div>
            </div> 
              <!-- /.form-group -->
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                 <label for="email">Country</label>
                 <select id="country" name="country" class="form-control">
                  <option value="">Select Country
                              </option>
                  <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($country); ?>"  <?php if($country == $business_manager_details['country']): ?> selected="select" <?php endif; ?> >
                      <?php echo e($country); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
              </div>
            </div> 
              <!-- /.form-group -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="pwd">State</label>
                <select id="state" name="state" class="form-control" >
                    <option value="">Select State</option>
                    <?php if($selected_countery_all_states_foreah != ""): ?>
                    <?php $__currentLoopData = $selected_countery_all_states_foreah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($state); ?>"  <?php if($state == $business_manager_details['state']): ?> selected="select" <?php endif; ?>><?php echo e($state); ?>

                    </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                      
                      <?php endif; ?> 
                    </select>
              </div>
            </div>

             <div class="col-md-4">
              <div class="form-group">
                 <label for="pwd">City</label>
                 <select id="city" name="city" class="form-control" >
                    <option value="">Select City</option>
                    <?php if($selected_state_all_cities_foreah != ""): ?>
                    <?php $__currentLoopData = $selected_state_all_cities_foreah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city); ?>"  <?php if($city == $business_manager_details['city']): ?> selected="select" <?php endif; ?>><?php echo e($city); ?>

                    </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                      <?php else: ?>
                      <?php endif; ?>
                    </select>
              </div>
            </div> 
              <!-- /.form-group -->
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                 <label for="email">Country Code</label>
                 <input type="text" name="country_code" id="country_code_second" maxlength="5" placeholder="Country Code" class="form-control" value="<?php echo e($business_manager_details['country_code']); ?>" onkeypress="return isNumberKey(event)" readonly>
              </div>
            </div> 
              <!-- /.form-group -->
            <div class="col-md-3">
              <div class="form-group">
                 <label for="pwd">Area Code</label>
                  <input type="text" name="area_code" id="paddress" maxlength="5" placeholder="Area Code" class="form-control" value="<?php echo e($business_manager_details['area_code']); ?>" onkeypress="return isNumberKey(event)">
              </div>
            </div>

             <div class="col-md-3">
              <div class="form-group">
                 <label for="pwd">Phone Number</label>
                 <input type="text" name="phone_number" id="paddress" value="<?php echo e($business_manager_details['phone_number']); ?>" maxlength="10" placeholder="Phone Number" class="form-control" onkeypress="return isNumberKey(event)">
              </div>
            </div> 

            <div class="col-md-3">
              <div class="form-group">
                 <label for="pwd">Pincode</label>
                 <input type="text" name="pincode" value="<?php echo e($business_manager_details['pincode']); ?>" id="paddress" maxlength="10" placeholder="Pin Code" class="form-control" onkeypress="return isNumberKey(event)">
              </div>
            </div> 
              <!-- /.form-group -->
          </div>

         </div>
          <!-- /.row -->
          <input type="hidden" name="manager_id" value="<?php echo e($business_manager_details['main_user_id']); ?>">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="learn_more_btn">
                <button type="submit" class="btn btn-success">Update</button>
              </div>
             </div>
       

       </form>

        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <!-- /.row -->

</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script>
    $(document).ready(function(){
        $('#purpose').on('change', function() {
          /*alert('hai');*/
            if ( this.value == 'Other professions')
            {
                $("#business_type").show();
            }
            else
            {
                $("#business_type").hide();
            }
        });
    });
</script>
 <script type="text/javascript">
    $('#country').change(function(){
    var country = $(this).val();    
    if(country){
        $.ajax({
           type:"GET",
           url:"<?php echo e(url('api/get-state-list')); ?>?country="+country,
           success:function(res){               
            if(res){
                $("#state").empty();
                $("#city").empty();
                $("#state").append('<option>Select</option>');
                $("#city").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#state").append('<option value="'+value+'">'+value+'</option>');
                });
           
            }else{
               $("#state").empty();
            }
           }
        });
    }else{
        $("#state").empty();
        $("#city").empty();
    }      
   });
    $('#state').on('change',function(){
    var state = $(this).val();    
    if(state){
        $.ajax({
           type:"GET",
           url:"<?php echo e(url('api/get-city-list')); ?>?state="+state,
           success:function(res){               
            if(res){
                $("#city").empty();
                $("#city").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#city").append('<option value="'+value+'">'+value+'</option>');
                });
           
            }else{
               $("#city").empty();
            }
           }
        });
    }else{
        $("#city").empty();
    }
        
   });
</script>
<!-- state city select end -->
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }    
</script>
<script>
var countryurl = "<?php echo e(url('api/country-and-codes')); ?>";
$(document).ready(function(){
        $('#country').on('change', function(){
             var country_name = $(this).val();
            //alert(country_name);
             if (country_name == '') {
               $('#country_code').val('');                
                $('#country_code_second').val('');
             }else{
              $.ajax({
              type: "GET",
              url: countryurl + '/' + country_name,         
              success: function (data) {
                //alert('hai');
                 /* alert('+' + ' ' + data.countries_isd_code);*/ 
                $('#country_code').val('+' + ' ' + data.phonecode);                
                $('#country_code_second').val('+' + ' ' + data.phonecode);                
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
             }
             
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        //Get
       var other_professsion = $('#purpose').val();
       if (other_professsion == 'Other professions')
          {
              $("#business_type").show();
          }
          else
          {
              $("#business_type").hide();
          }
       
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>