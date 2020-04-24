<div class="container">
<div class="item-1">
@if(count($old_data) != 0)
<h4 class="modal-title" id="classModalLabel">
      Old Data
</h4>
<table style="width:100%">
@foreach($old_data as $key => $m)
  <tr>
    <th>{{$key}}:</th>
    <td>{{$m}}</td>
  </tr>
@endforeach  
</table>
@endif
</div>

<div class="item-2">
@if(count($new_inserted_data) != 0)

@if(count($old_data) == 0)
<h4 class="modal-title" id="classModalLabel" style="background: white;">
      New Data
</h4>
<table style="width:200%; background:#80ffff; ">
@else
<h4 class="modal-title" id="classModalLabel">
      New Data
</h4>
<table style="width:100%">
@endif
@foreach($new_inserted_data as $key => $m)
  <tr>
    <th>{{$key}}:</th>
    <td>{{$m}}</td>
  </tr>
@endforeach  
</table>
@endif
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
       