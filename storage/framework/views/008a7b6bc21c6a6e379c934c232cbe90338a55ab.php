<div class="container">
<div class="item-1">
<?php if(count($old_data) != 0): ?>
<h4 class="modal-title" id="classModalLabel">
      Old Data
</h4>
<table style="width:100%">
<?php $__currentLoopData = $old_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <tr>
    <th><?php echo e($key); ?>:</th>
    <td><?php echo e($m); ?></td>
  </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
</table>
<?php endif; ?>
</div>

<div class="item-2">
<?php if(count($new_inserted_data) != 0): ?>

<?php if(count($old_data) == 0): ?>
<h4 class="modal-title" id="classModalLabel" style="background: white;">
      New Data
</h4>
<table style="width:200%; background:#80ffff; ">
<?php else: ?>
<h4 class="modal-title" id="classModalLabel">
      New Data
</h4>
<table style="width:100%">
<?php endif; ?>
<?php $__currentLoopData = $new_inserted_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <tr>
    <th><?php echo e($key); ?>:</th>
    <td><?php echo e($m); ?></td>
  </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
</table>
<?php endif; ?>
 </div>

<style> 
.container {
        overflow:hidden;
        width: 100%;
        margin: 0px auto;
        padding: 0px;
        border:0;
  
}
.item-1 {
  float: left;
  width: 50%;
  background:#4da6ff;
  
}
.item-2 { 
  margin: 0;
  float: left;
  width: 50%;
 background:#80ffff;

}  
      
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}
</style>
       