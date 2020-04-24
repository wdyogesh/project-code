        <h4 class="modal-title" id="classModalLabel">
              Inserted Values
        </h4>
       <table id="classTable" class="table table-bordered">
         <thead>
          
						<tr>
            @foreach($inserted_data as $key => $m)
							<th>{{$key}}</th>
             @endforeach    
						</tr>
          
					</thead>
          <tbody>
          
            <tr>
             @foreach($inserted_data as $key => $m)
              <td>{{$m}}</td>
             @endforeach   
            </tr>
         
          </tbody>
        </table>
        @if(count($updated_data) != 0)
        <h4 class="modal-title" id="classModalLabel">
              Updated Values
        </h4>
       <table id="classTable" class="table table-bordered">
         <thead>
          
            <tr>
            @foreach($updated_data as $key => $m)
              <th>{{$key}}</th>
             @endforeach    
            </tr>
          
          </thead>
          <tbody>
          
            <tr>
             @foreach($updated_data as $key => $m)
              <td>{{$m}}</td>
             @endforeach   
            </tr>
         
          </tbody>
        </table>
        @endif