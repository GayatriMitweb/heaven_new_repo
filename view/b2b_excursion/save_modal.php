<?php
include "../../model/model.php";
?>
<form id="frm_b2b_exc_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activity</h4>
      </div>
      <div class="modal-body">	
		<div class="row">
		<div class="col-md-12 app_accordion">
		<div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="accordion_content package_content">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading1">
							<div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1" id="collapsed1">                  
								<div class="col-md-12"><span><em style="margin-left: 15px;"><?php echo "Activity Information"; ?></em></span></div>
							</div>
						</div>
						<div id="collapse1" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading1">
							<div class="panel-body">
								<div class="row mg_bt_10">
									<div class="col-sm-2">
										<select name="city_id" id="city_id" title="Select City" style="width:100%">
										</select>
									</div>
									<div class="col-sm-2">
										<input type="text" id="service_name" name="service_name" placeholder="*Activity Name" title="Activity Name">
									</div>
									<div class="col-sm-2">
										<input type="text" id="duration" name="duration" placeholder="Duration" title="Duration">
									</div>
									<div class="col-sm-2">
										<input type="text" id="dep_point" name="dep_point" placeholder="Pickup Point" title="Pickup Point">
									</div>
									<div class="col-sm-2">
										<input type="text" id="rep_time" name="rep_time" placeholder="Reporting Time" title="Reporting Time">
									</div>
									<div class="col-sm-2">
										<select name="off_days" id="off_days" data-toggle="tooltip" title="Select Off Days" style="width:100%" multiple>
										<option value="">Select Off Days</option>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday">Wednesday</option>
										<option value="Thursday">Thursday</option>
										<option value="Friday">Friday</option>
										<option value="Saturday">Saturday</option>
										<option value="Sunday">Sunday</option>
										</select>
									</div>
								</div>
								<div class="row mg_bt_10">
									<div class="col-sm-6">
										<textarea id="description" name="description" onchange="validate_spaces(this.id)" placeholder="Description" title="Description"></textarea>
									</div>
									<div class="col-sm-6">
										<textarea id="note" name="note" onchange="validate_spaces(this.id)" placeholder="Note" title="Note"></textarea>
									</div>
								</div>
								<div class="row mg_bt_10">
									<div class="col-md-6 text-left">
										<button type="button" class="btn btn-sm btnType st-custBtn" onclick="display_format_modal1();" data-toggle="tooltip" title="Download CSV"><i class="icon fa fa-download"></i>CSV Format</button>

										<div class="div-upload" id="div_upload_button2" data-toggle="tooltip" title="Upload CSV">
											<div id="timing_tariff_upload" class="upload-button1"><span>CSV</span></div>
											<span id="timing_status"></span>
											<ul id="files" ></ul>
											<input type="hidden" id="timing_tariff_url" name="timing_tariff_url">
										</div>
										<span style="color: red;" class="note">Note : Upload CSV for Timing Slots.</span>
									</div>
									<input type="hidden" id="timing_slots"/>
								</div>
							</div>
							<div class="row mg_bt_20">
								<div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
									<h3 class="editor_title">Inclusions</h3>
									<textarea class="feature_editor" id="inclusions" name="inclusions" placeholder="Inclusions" title="Inclusions" rows="3"></textarea>
								</div>
								<div class="col-md-4 col-sm-4"> 
									<h3 class="editor_title">Exclusions</h3>
									<textarea class="feature_editor" id="exclusions" name="exclusions" class="form-control"  placeholder="Exclusions" title="Exclusions" rows="3"></textarea>
								</div>
								<div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
									<h3 class="editor_title">Terms & Conditions</h3>
									<textarea class="feature_editor" id="terms" name="terms" placeholder="Terms & Conditions" title="Terms & Conditions" rows="3"></textarea>
								</div>
							</div>	
							<div class="row mg_bt_20">
								<div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
									<h3 class="editor_title">Useful Information</h3>
									<textarea class="feature_editor" id="upolicy" name="upolicy" placeholder="Booking Policy" title="Booking Policy" rows="3"></textarea>
								</div>
								<div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
									<h3 class="editor_title">Booking Policy</h3>
									<textarea class="feature_editor" id="bpolicy" name="bpolicy" placeholder="Booking Policy" title="Booking Policy" rows="3"></textarea>
								</div>
								<div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
									<h3 class="editor_title">Cancellation Policy</h3>
									<textarea class="feature_editor" id="cpolicy" name="cpolicy" placeholder="Cancellation Policy" title="Cancellation Policy" rows="3"></textarea>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion_content package_content mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading2">
							<div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2" id="collapsed1">                  
							<div class="col-md-12"><span><em style="margin-left: 15px;"><?php echo "Costing Information"; ?></em></span></div>
							</div>
						</div>
						<div id="collapse2" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading2">
						<div class="panel-body">
							<div class="row mg_bt_10">
								<div class="col-md-3 mg_bt_10">
									<select name="currency_code" id="currency_code" title="Currency" style="width:100%">
									<?php
									global $currency;
									$sq_dcurrency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$currency'"));
									?>
									<option value="<?= $sq_dcurrency['id'] ?>"><?= $sq_dcurrency['currency_code'] ?></option>
									<?php
										$sq_currency = mysql_query("select * from currency_name_master where id!='$currency' order by default_currency desc");
										while($row_currency = mysql_fetch_assoc($sq_currency)){
										?>
										<option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-12">
							<div class="row mg_bt_10">
								<h5 style='border-bottom: 1px solid #e5e5e5;'>Basic Costing</h5>
									<div class="row text-right mg_bt_10">
										<button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_exc_tarrif_basic')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
										<button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_exc_tarrif_basic')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
									</div>
									<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table id="table_exc_tarrif_basic" name="table_exc_tarrif_basic" class="table table-bordered no-marg pd_bt_51" style="width:100%">
											<tr>
												<td><input class="css-checkbox" id="chk_basic" type="checkbox" checked><label class="css-label" for="chk_basic"> </label></td>
												<td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
												<td><select name="transfer_option" id="transfer_option" data-toggle="tooltip" class="form-contrl app_select2" title="Transfer Option" style="width:150px">
													<option value="">*Transfer Option</option>
													<option value="Without Transfer">Without Transfer</option>
													<option value="Sharing Transfer">Sharing Transfer</option>
													<option value="Private Transfer">Private Transfer</option>
													<option value="SIC">SIC</option>
													</select></td>
												<td><input type="text" id="from_date_basic" class="form-control" name="from_date_basic" placeholder="Valid From" title="Valid From" value="<?= date('d-m-Y') ?>" style="width:120px"/></td>
												<td><input type="text" id="to_date_basic" class="form-control" name="to_date_basic" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date' ,'to_date')" value="<?= date('d-m-Y') ?>" style="width:120px" /></td>
												<td><input type="text" id="adult_cost" name="adult_cost" placeholder="*Adult Cost" title="Adult Cost" onchange="validate_balance(this.id);" style="width:120px"></td>
												<td><input type="text" id="child_cost" name="child_cost" placeholder="*Child Cost" title="Child Cost" onchange="validate_balance(this.id);" style="width:120px"></td>
												<td><input type="text" id="infant_cost" name="infant_cost" placeholder="Infant Cost" title="Infant Cost" onchange="validate_balance(this.id);" style="width:120px"></td>
												<td><select name="markup_in" id="markup_in" style="width: 125px" class="form-control app_select2" title="Markup In">
													<option value=''>Amount In</option>
													<option value='Flat'>Flat</option>
													<option value='Percentage'>Percentage</option></select></td>
												<td><input type='number' id="amount" name="amount" placeholder="*Markup Amount" class="form-control" title="Markup Amount" style="width: 147px;"/></td>
												<td><input type="hidden" id="entry_id" name="entry_id" /></td>
											</tr>
											</table>
										</div>
									</div>
									</div>
							</div>
							</div>
							<div class="col-md-12">
							<div class="row mg_bt_10">
								<h5 style='border-bottom: 1px solid #e5e5e5;'>Offers/Coupons</h5>
									<div class="row text-right mg_bt_10">
										<button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_exc_tarrif_offer')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
										<button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_exc_tarrif_offer')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
									</div>
									<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table id="table_exc_tarrif_offer" name="table_exc_tarrif_offer" class="table table-bordered no-marg pd_bt_51" style="width:100%">
											<tr>
												<td><input class="css-checkbox" id="chk_offer" type="checkbox"><label class="css-label" for="chk_offer"> </label></td>
												<td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
												<td><select name="offer_type" id="offer_type" style="width: 125px" class="form-control app_select2">
													<option value=''>Select Type</option>
													<option value='Offer'>Offer</option>
													<option value='Coupon'>Coupon</option></td>
												<td><input type="text" id="from_date" class="form-control" name="from_date" placeholder="Valid From" title="Valid From" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
												<td><input type="text" id="to_date" class="form-control" name="to_date" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date' ,'to_date')" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
												<td><select name="amount_in" id="amount_in" style="width: 125px" class="form-control app_select2">
													<option value=''>Amount In</option>
													<option value='Flat'>Flat</option>
													<option value='Percentage'>Percentage</option></select></td>
												<td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 130px;"/></td>
												<td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;"/></td>
												<td><select name="agent_type" id="agent_type" style="width: 135px" class="form-control app_select2" multiple>
													<option value=''>Agent Type</option>
													<option value='Platinum'>Platinum</option>
													<option value='Gold'>Gold</option>
													<option value='Silver'>Silver</option></select></td>
												<td><input type="hidden" id="entry_id" name="entry_id" /></td>
											</tr>
											</table>
										</div>
									</div>
									</div>
							</div>
							</div>
						</div>
						</div>
					</div>
				</div>			
		</div>
		</div>
		<div class="row mg_bt_10">
			<div class="col-md-12">          
				<div class="div-upload">
					<div id="photo_upload_btn_i" class="upload-button1"><span>Image</span></div>
					<span id="photo_status" ></span>
					<ul id="files" ></ul>
					<input type="hidden" id="photo_upload_url_i" name="photo_upload_url_i">
				</div>(Upload Maximum 3 images)
			</div>
		</div>
		<div class="row mg_tp_10">
			<div class="col-sm-6">  
				<span style="color: red;" class="note">Note : Image size should be less than 100KB, resolution : 900X450.</span>
			</div>
		</div>
      	<input type="hidden" name="hotel_image_path" id="hotel_image_path">
		<div class="row mg_tp_20 text-center">
			<div class="col-md-12">
				<button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>
</form>
<script>
$('#save_modal').modal('show');
$('#off_days,#currency_code,#agent_type,#transfer_option').select2();
$('#rep_time').datetimepicker({ datepicker:false, format:'H:i A',showMeridian: true });
$('#to_date,#from_date,#to_date_c,#from_date_c,#from_date_basic,#to_date_basic').datetimepicker({ timepicker:false, format:'d-m-Y' });
city_lzloading('#city_id');
timing_tariff_csv();
function timing_tariff_csv(){
	var btnUpload=$('#timing_tariff_upload');
	var status=$('#timing_status');
    new AjaxUpload(btnUpload, {
      action: 'upload_timing_csv.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

		if(!confirm('Do you want to import this file?')){
			return false;
		}
		if (! (ext && /^(csv)$/.test(ext))){ 
			error_msg_alert('Only CSV files are allowed');
			return false;
		}
    	$(btnUpload).find('span').text('Uploading');
      },
      onComplete: function(file, response){
        //On completion clear the status
    	$(btnUpload).find('span').text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
        } else{
		  document.getElementById("timing_tariff_url").value = response;
    	  $(btnUpload).find('span').text('Uploading');
		  timing_tariff_prepare();
          $(btnUpload).find('span').text('Uploaded');          
        }
      }
    });
}

function timing_tariff_prepare(){
    var cust_csv_dir = document.getElementById("timing_tariff_url").value;
  	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/b2b_excursion/exc_timing_slots.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){

          var pass_arr = JSON.parse(result);
          if(pass_arr.length != 0){
			$('#timing_slots').val(result);
          }else{
            error_msg_alert('No Records in CSV!'); return false;
          }
        }
    });
}

function display_format_modal1(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/excursion_timing_slots.csv";
}

upload_user_pic_attch();
function upload_user_pic_attch(){

    var img_array = new Array(); 
    var btnUpload=$('#photo_upload_btn_i');
    $(btnUpload).find('span').text('Image');

    $("#photo_upload_url_i").val('');
    new AjaxUpload(btnUpload, {
      action: 'upload_image_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");
          $(btnUpload).find('span').text('Upload');
        }
        else{
          if(response=="error1"){
            $(btnUpload).find('span').text('Upload Images');
            error_msg_alert('Maximum size exceeds');
            return false;
          }
		  else{
              $(btnUpload).find('span').text('Uploaded'); 
              $("#photo_upload_url_i").val(response);
          }
          img_array.push(response);
        }
        if(img_array.length>3){
          error_msg_alert("You can upload only 3 images"); return false;
        }
        $("#hotel_image_path").val(img_array);
    }
});
}
$(function(){
	$('#frm_b2b_exc_save').validate({
		rules:{
			city_id : { required : true },
			service_name : { required : true },
		},
		submitHandler:function(form){

			var city_id = $('#city_id').val();
			var service_name = $('#service_name').val();
			var duration = $('#duration').val();
			var dep_point = $('#dep_point').val();
			var rep_time = $('#rep_time').val();
			var description = $('#description').val();
			var note = $('#note').val();
			var timing_slots = $('#timing_slots').val();
			var off_days = '';
			$('#off_days').find('option:selected').each(function(){ off_days += $(this).attr('value')+','; });
			off_days = off_days.substring(0, off_days.length - 1);

			var inclusions = $('#inclusions').val();
			var exclusions = $('#exclusions').val();
			var terms = $('#terms').val();
			var upolicy = $('#upolicy').val();
			var bpolicy = $('#bpolicy').val();
			var cpolicy = $('#cpolicy').val();

			if(city_id==''){
				error_msg_alert('Select City in Activity Information!'); return false;
			}
			if(service_name==''){
				error_msg_alert('Enter Activity in Activity Information!'); return false;
			}

			var taxation_type = $('#taxation_type').val();
			var taxation_id = $('#taxation_id').val();
			var service_tax = $('#service_tax').val();
			if(service_tax == '0'){ error_msg_alert('Select Tax(%)'); return false;}
			var taxation = [{
				'taxation_type' : taxation_type,
				'taxation_id' : taxation_id,
				'service_tax' : service_tax
			}];
			var currency_code = $('#currency_code').val();
			var active_flag = 'Active';
			var photo_upload_url = $('#hotel_image_path').val();

			//Tariff Basics
			var transfer_option_array = [];
			var bfrom_date_array = new Array();
			var bto_date_array = new Array();
			var adult_cost_array = new Array();
			var child_cost_array = new Array();
			var infant_cost_array = new Array();
			var markup_in_array = new Array();
			var markup_cost_array = new Array();
			var table = document.getElementById("table_exc_tarrif_basic");
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++){
			var row = table.rows[i];           

				if(row.cells[0].childNodes[0].checked){
					var transfer_option = row.cells[2].childNodes[0].value;
					var from_date = row.cells[3].childNodes[0].value;
					var to_date = row.cells[4].childNodes[0].value;
					var adult_cost = row.cells[5].childNodes[0].value;
					var child_cost = row.cells[6].childNodes[0].value;
					var infant_cost = row.cells[7].childNodes[0].value;
					var markup_in = row.cells[8].childNodes[0].value;
					var markup_cost = row.cells[9].childNodes[0].value;

					if(from_date==''){
						error_msg_alert('Select Valid From Date in Row-'+(i+1));
						return false;
					}
					if(to_date==''){
						error_msg_alert('Select Valid To Date in Row-'+(i+1));
						return false;
					}
					if(adult_cost==''){
						error_msg_alert('Enter Adult Cost in Row-'+(i+1));
						return false;
					}
					if(child_cost==''){
						error_msg_alert('Enter Child Cost in Row-'+(i+1));
						return false;
					}
					if(markup_in==''){
						error_msg_alert('Select Markup In in Row-'+(i+1));
						return false;
					}
					if(markup_cost==''){
						error_msg_alert('Enter Markup Cost in Row-'+(i+1));
						return false;
					}

					transfer_option_array.push(transfer_option);
					bfrom_date_array.push(from_date);
					bto_date_array.push(to_date);
					adult_cost_array.push(adult_cost);
					child_cost_array.push(child_cost);
					infant_cost_array.push(infant_cost);
					markup_in_array.push(markup_in);
					markup_cost_array.push(markup_cost);
				}
			}
			if(bfrom_date_array.length == 0){ error_msg_alert('Please Enter Basic Costing in Costing Information!'); return false;}

			var type_array = new Array();
			var from_date_array = new Array();
			var to_date_array = new Array();
			var offer_in_array = new Array();
			var offer_array = new Array();
			var coupon_code_array = new Array();
			var agent_type_array = new Array();
			var table = document.getElementById("table_exc_tarrif_offer");
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++){
			var row = table.rows[i];           

				if(row.cells[0].childNodes[0].checked){
					var type = row.cells[2].childNodes[0].value;
					var from_date = row.cells[3].childNodes[0].value;
					var to_date = row.cells[4].childNodes[0].value;
					var offer_in = row.cells[5].childNodes[0].value;
					var coupon_code = row.cells[6].childNodes[0].value;
					var offer = row.cells[7].childNodes[0].value;
					var agent_type = "";
					$(row.cells[8]).find('option:selected').each(function(){ agent_type += $(this).attr('value')+','; });
					agent_type = agent_type.trimChars(",");

					if(type==''){
						error_msg_alert('Select Type in Row-'+(i+1));
						return false;
					}
					if(from_date==''){
						error_msg_alert('Select Valid From Date in Row-'+(i+1));
						return false;
					}
					if(to_date==''){
						error_msg_alert('Select Valid To Date in Row-'+(i+1));
						return false;
					}
					if(offer_in==''){
						error_msg_alert('Select Offer-In in Row-'+(i+1));
						return false;
					}
					if(offer==''){
						error_msg_alert('Enter Offer Amount in Row-'+(i+1));
						return false;
					}
					if(type == 'Coupon' && coupon_code == ''){
						error_msg_alert('Enter Coupon Code in Row-'+(i+1));
						return false;
					}

					type_array.push(type);
					from_date_array.push(from_date);
					to_date_array.push(to_date);
					offer_in_array.push(offer_in);
					coupon_code_array.push(coupon_code);
					offer_array.push(offer);
					agent_type_array.push(agent_type);
				}
			}
			
			$('#btn_save').button('loading');
			$.ajax({
				type:'post',
				url: base_url()+'controller/b2b_excursion/b2b_exc_save.php',
				data:{ city_id : city_id, service_name : service_name,transfer_option:transfer_option,duration:duration,dep_point:dep_point,rep_time:rep_time,description:description,note:note,off_days:off_days,timing_slots:JSON.stringify(timing_slots),inclusions:inclusions,exclusions:exclusions,terms:terms,upolicy:upolicy,bpolicy:bpolicy,cpolicy:cpolicy,currency_code:currency_code,taxation:JSON.stringify(taxation), active_flag : active_flag , adult_cost : adult_cost,child_cost : child_cost,photo_upload_url : photo_upload_url,transfer_option_array:transfer_option_array,bfrom_date_array:bfrom_date_array,bto_date_array:bto_date_array,adult_cost_array:adult_cost_array,child_cost_array:child_cost_array,infant_cost_array:infant_cost_array,markup_in_array:markup_in_array,markup_cost_array:markup_cost_array,type_array:type_array,from_date_array:from_date_array,to_date_array:to_date_array,offer_in_array:offer_in_array,offer_array:offer_array,coupon_code_array:coupon_code_array,agent_type_array:agent_type_array},
				success:function(result){
					var msg = result.split('--');
					if(msg[0] != 'error'){
						update_b2c_cache();
						msg_alert(result);
						$('#save_modal').modal('hide');
						list_reflect();
					}
					else{
						error_msg_alert(msg[1]);
						$('#btn_save').button('reset');
						return false;
					}
				}
			});
		}
	});
});
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>