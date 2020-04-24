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
          <h3 class="box-title">Business Client Registration</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
         <form class="bootstrap-modal-form" action="<?php echo e(url('admin/create-business-client')); ?>" method="post" files='true'>
            <?php echo e(csrf_field()); ?>

        <div class="box-body">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Business Name</label>
                <input type=text name='business_name' class="form-control" id="textname" maxlength="20">
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
                  <option value="<?php echo e($profession->business_profession_type); ?>"><?php echo e($profession->business_profession_type); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <option value="Other professions" style="color:green;font-size:17px; ">Other professions</option>

                </select>
              </div>
            </div>  
              <!-- /.form-group -->
          </div>
          
          <div class="row"  style='display:none;' id='business_type'>
            <div class="col-md-6">
              <div class="form-group">
                <label>Enter Profession Type</label>
                <input type="text" class="form-control" name="other_business" maxlength="20">
              </div>
            </div> 
              <!-- /.form-group -->
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>First Name</label>
                <input type=text name='first_name' class="form-control" id="textname" maxlength="20">
              </div>
            </div> 
              <!-- /.form-group -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Sur Name</label>
                <input type=text name='surname' class="form-control" id="textname" maxlength="20">
              </div>
            </div>

             <div class="col-md-4">
              <div class="form-group">
                 <label for="pwd">Email</label>
                 <input type="text" class="form-control" name="email" maxlength="40">
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
                              
                              <option value="<?php echo e($country); ?>"> <?php echo e($country); ?>

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
                </select>
              </div>
            </div>

             <div class="col-md-4">
              <div class="form-group">
                 <label for="pwd">City</label>
                 <select name="city" id="city" class="form-control">
                    <option value="">Select City</option>
                </select>
              </div>
            </div> 
              <!-- /.form-group -->
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                 <label for="email">Country Code</label>
                 <input type="text" name="country_code" id="country_code_second" maxlength="5" placeholder="Country Code" class="form-control" onkeypress="return isNumberKey(event)" readonly>
              </div>
            </div> 
              <!-- /.form-group -->
            <div class="col-md-3">
              <div class="form-group">
                 <label for="pwd">Area Code</label>
                  <input type="text" name="area_code" id="paddress" maxlength="5" placeholder="Area Code" class="form-control" onkeypress="return isNumberKey(event)">
              </div>
            </div>

             <div class="col-md-3">
              <div class="form-group">
                 <label for="pwd">Phone Number</label>
                 <input type="text" name="phone_number" id="paddress" maxlength="10" placeholder="Phone Number" class="form-control" onkeypress="return isNumberKey(event)">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                 <label for="pwd">Pincode</label>
                 <input type="text" name="pincode" id="paddress" maxlength="6" placeholder="Pin Code" class="form-control" onkeypress="return isNumberKey(event)">
              </div>
            </div> 
              <!-- /.form-group -->
          </div>

         </div>
          <!-- /.row -->
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="learn_more_btn">
                <button type="submit" class="btn btn-success">SUBMIT</button>
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
<script src="<?php echo e(asset('js/country-states.js')); ?>"></script>
<script language="javascript">
    populateCountries("country", "state");
    populateCountries("country2");
</script>
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }    
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>