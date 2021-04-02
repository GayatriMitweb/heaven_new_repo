<form id="frm_tour_entities">

	<div class="app_panel_content Filter-panel">
		<div class="row text-center">
			<div class="col-md-4 col-sm-6">
				<select name="budget_type_id1" id="budget_type_id_new" title="Tour Type"> 
					<option value="">Tour Type</option>
					<?php 
					$sq = mysql_query("select * from tour_budget_type");
					while($row=mysql_fetch_assoc($sq)){
						?>
						<option value="<?= $row['budget_type_id'] ?>"><?= $row['budget_type'] ?></option>
						<?php
					}

					?>
				</select>
			</div>
		</div>
	</div>

<div class="row">
  <div class="col-xs-12 text-right text_center_xs mg_tp_20">
		<button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_tour_entities')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
		<button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_tour_entities')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
  </div>
</div> 
<div class="row mg_tp_20">
  <div class="col-md-12 mg_tp_10">
		<div class="table-responsive">
		    <table id="tbl_tour_entities" name="tbl_tour_entities" class="table table-bordered table-striped table-hover no-marg-sm">
		            <tr>
		                <td><input class="css-checkbox" id="chk_tour_group1" type="checkbox" checked><label class="css-label" for="chk_tour_group1"> </label></td>
		                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
		                <td><input type="text" id="txt_entity_name1" name="txt_entity_name1" placeholder="Entity Name" title="Entity Name"class="form-control"/></td>
		            </tr>                                
		    </table>
		</div>
  </div>
  <div class="row col-md-12 text-center">
		<button class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
  </div>
</div>
</form>
<?= end_panel() ?>
<script>
	$(function(){
		$('#frm_tour_entities').validate({
			rules:{
					budget_type_id : "required",
			},
			submitHandler:function(form){

				  var base_url = $('#base_url').val();
				  var budget_type_id = $('#budget_type_id_new').val();
				  var table = document.getElementById("tbl_tour_entities");
				  var rowCount = table.rows.length;
				  
				  var entity_name_arr = new Array();
				  
				  for(var i=0; i<rowCount; i++)
				  {
				    var row = table.rows[i];
				     
				    if(row.cells[0].childNodes[0].checked)
				    {
				       var entity_name = row.cells[2].childNodes[0].value;

				       if(entity_name==""){
				       	error_msg_alert('Enter entity name id row '+(i+1));
				       	return false;
				       }

				       var status = isInArray(entity_name, entity_name_arr);         
				       if(status==false){
				       	error_msg_alert(entity_name+' occured more than once.');
				       	return false;
				       }

				       entity_name_arr.push(entity_name);
				    }      
				  }	

				  $.ajax({
				  	type:'post',
				  	url: base_url+'controller/tour_estimate/tour_budget_entities_save.php',
				  	data:{ budget_type_id : budget_type_id, entity_name_arr : entity_name_arr },
				  	success:function(result){
				  		var msg = result.split('--');
				  		if(msg[0]=="error"){
				  			msg_alert(result);
				  		}else{
				  			msg_popup_reload(result);
				  		}				  		
				  	},
				  	error:function(result){
				  		console.log(result.responseText);
				  	}
				  });

			}
		});
	});
</script>