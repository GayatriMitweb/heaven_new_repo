<form id="frm_tab31">

<div class="row mg_tp_10">
<?php
		$basic_cost1 = $sq_quotation['subtotal'];
		$service_charge = $sq_quotation['service_charge'];
		$markup = $sq_quotation['markup_cost'];

		$bsmValues = json_decode($sq_quotation['bsm_values']);
		$service_tax_amount = 0;
		if($sq_quotation['service_tax'] !== 0.00 && ($sq_quotation['service_tax']) !== ''){
			$service_tax_subtotal1 = explode(',',$sq_quotation['service_tax']);
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount = $service_tax_amount + $service_tax[2];
			}
		}
		$markupservice_tax_amount = 0;
		if($sq_quotation['markup_cost_subtotal'] !== 0.00 && $sq_quotation['markup_cost_subtotal'] !== ""){
			$service_tax_markup1 = explode(',',$sq_quotation['markup_cost_subtotal']);
			for($i=0;$i<sizeof($service_tax_markup1);$i++){
				$service_tax = explode(':',$service_tax_markup1[$i]);
				$markupservice_tax_amount = $markupservice_tax_amount+ $service_tax[2];
			}
		}
		foreach($bsmValues[0] as $key => $value){
			switch($key){
				case 'basic' : $basic_cost = ($value != "") ? $basic_cost1 + $service_tax_amount : $basic_cost1;$inclusive_b = $value;break;
				case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;break;
				case 'markup' : $markup = ($value != "") ? $markup + $markupservice_tax_amount : $markup;$inclusive_m = $value;break;
			}
		}
		$readonly = ($inclusive_d != '') ? 'readonly' : '';
    ?>
	<div class="col-md-2">
		<small id="basic_show1"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
	    <input type="text" id="subtotal1" name="subtotal1" placeholder="Total Fare" title="Total Fare"  onchange="flight_quotation_cost_calculate('1');validate_balance(this.id);get_auto_values('quotation_date1','subtotal1','payment_mode','service_charge1','markup_cost1','update','true','service_charge', true);" value="<?= $basic_cost ?>">

	</div>
	<div class="col-md-2">
		<small id="service_show1"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
	    <input type="text" id="service_charge1" name="service_charge1" placeholder="Service Charge" title="Service Charge"  onchange="validate_balance(this.id);get_auto_values('quotation_date1','subtotal1','payment_mode','service_charge1','markup_cost1','update','false','service_charge', true);" value="<?= $service_charge ?>">

	</div>
	<div class="col-md-2">
		<small>&nbsp;</small>
	    <input type="text" id="service_tax1" name="service_tax1" placeholder="Tax Amount" title="Tax Amount"  onchange="flight_quotation_cost_calculate('1');validate_balance(this.id);" value="<?= $sq_quotation['service_tax'] ?>" readonly>

	</div>
	<div class="col-md-2">
		<small id="markup_show1"><?= ($inclusive_m == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_m ?></span></small>
	    <input type="text" id="markup_cost1" name="markup_cost1" placeholder="Markup Cost" title="Markup Cost"  onchange="validate_balance(this.id);get_auto_values('quotation_date1','subtotal1','payment_mode','service_charge1','markup_cost1','update','false','service_charge', true);" value="<?= $markup ?>">

	</div>
	<div class="col-md-2">
		<small>&nbsp;</small>
  		<input type="text" id="markup_cost_subtotal1" name="markup_cost_subtotal1" placeholder="Tax  Markup" title="Tax Markup" onchange="flight_quotation_cost_calculate('1');" value="<?= $sq_quotation['markup_cost_subtotal'] ?>" readonly>  
  	</div>
	  <div class="col-md-2">
		<small>&nbsp;</small>
  		<input type="text" id="roundoff1" name="roundoff1" placeholder="Round Off" title="Round Off" onchange="flight_quotation_cost_calculate('1');" value="<?= $sq_quotation['roundoff'] ?>" readonly>  
  	</div>

 </div>
<div class="row mg_tp_20">

<div class="col-md-2">

<input type="text" id="total_tour_cost1" class="amount_feild_highlight text-right" name="total_tour_cost1" placeholder="Quotation Cost" title="Quotation Cost" value="<?= $sq_quotation['quotation_cost'] ?>"readonly>

</div>
</div>
	<div class="row mg_tp_20 text-center">

		<div class="col-md-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-sm btn-success" id="btn_quotation_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>

		</div>

	</div>

</form>

<script>
 
function switch_to_tab2(){ $('a[href="#tab_2"]').tab('show'); }

$('#frm_tab31').validate({
	submitHandler:function(form,e){
		e.preventDefault();
		var quotation_id = $('#quotation_id1').val();
		var enquiry_id = $('#enquiry_id1').val();
		var customer_name = $("#customer_name1").val();
		var email_id = $('#email_id1').val();
		var mobile_no = $('#mobile_no1').val();
		var quotation_date = $('#quotation_date1').val();
		var subtotal = $('#subtotal1').val();
		var markup_cost = $('#markup_cost1').val();
		var markup_cost_subtotal = $('#markup_cost_subtotal1').val();
		var service_charge = $('#service_charge1').val();
		var service_tax = $('#service_tax1').val();
		var bsmValues = [];
		bsmValues.push({
			"basic" : $('#basic_show1').find('span').text(),
			"service" : $('#service_show1').find('span').text(),
			"markup" : $('#markup_show1').find('span').text()
		});
		var roundoff = $('#roundoff1').val();
		var total_tour_cost = $('#total_tour_cost1').val();
		 
		//Plane Information 
		var from_city_id_arr = new Array();
        var to_city_id_arr = new Array(); 
		var from_sector_arr = new Array();
		var to_sector_arr = new Array();
		var airline_name_arr = new Array();
		var plane_class_arr = new Array();
		var total_adult_arr = new Array();
		var total_child_arr = new Array();
		var total_infant_arr = new Array();
		var arraval_arr = new Array();
		var dapart_arr = new Array();
		var plane_id_arr = new Array();

		var table = document.getElementById("tbl_flight_quotation_dynamic_plane_update");
		  var rowCount = table.rows.length;
		  
		  for(var i=0; i<rowCount; i++)
		  {
		    var row = table.rows[i];
		     
		    if(row.cells[0].childNodes[0].checked)
		    {
		       var from_sector = row.cells[2].childNodes[0].value;
	           var to_sector = row.cells[3].childNodes[0].value;   
	           var airline_name = row.cells[4].childNodes[0].value;  
			   var plane_class = row.cells[5].childNodes[0].value;  
			   var total_adult = row.cells[6].childNodes[0].value;
			   var total_child = row.cells[7].childNodes[0].value;
			   var total_infant = row.cells[8].childNodes[0].value;       
	           var dapart1 = row.cells[9].childNodes[0].value;
			   var arraval1 = row.cells[10].childNodes[0].value;
			   var from_city_id1 = row.cells[11].childNodes[0].value;
			   var to_city_id1 = row.cells[12].childNodes[0].value; 

		        if(row.cells[13] && row.cells[13].childNodes[0]){
	            var plane_id = row.cells[13].childNodes[0].value;
	           }

		       else{
		       	var plane_id = "";
		       }     
		       
		       from_city_id_arr.push(from_city_id1);
               to_city_id_arr.push(to_city_id1);
		       from_sector_arr.push(from_sector);
		       to_sector_arr.push(to_sector);
		       airline_name_arr.push(airline_name);
			   plane_class_arr.push(plane_class);
			   total_adult_arr.push(total_adult);
			   total_child_arr.push(total_child);
			   total_infant_arr.push(total_infant);
		       arraval_arr.push(arraval1);
		       dapart_arr.push(dapart1);
		       plane_id_arr.push(plane_id);
		      
		    }      
		  }
		  console.log(from_city_id_arr);
		var base_url = $('#base_url').val();
		$('#btn_quotation_update').button('loading');

		$.ajax({
			type:'post',
			url: base_url+'controller/package_tour/quotation/flight/quotation_update.php',
			data:{ quotation_id : quotation_id, enquiry_id : enquiry_id , customer_name : customer_name, email_id : email_id, mobile_no : mobile_no , quotation_date : quotation_date, subtotal : subtotal,markup_cost:markup_cost,markup_cost_subtotal : markup_cost_subtotal , service_tax : service_tax , service_charge : service_charge, total_tour_cost : total_tour_cost, from_sector_arr : from_sector_arr, to_sector_arr : to_sector_arr,airline_name_arr : airline_name_arr , plane_class_arr : plane_class_arr, arraval_arr : arraval_arr, dapart_arr : dapart_arr,plane_id_arr :plane_id_arr, from_city_id_arr : from_city_id_arr, to_city_id_arr : to_city_id_arr,total_adult_arr : total_adult_arr, total_child_arr : total_child_arr, total_infant_arr : total_infant_arr, bsmValues : bsmValues, roundoff : roundoff},
			success: function(message){			
                	$('#btn_quotation_update').button('reset');
                	var msg = message.split('--');
					if(msg[0]=="error"){
						error_msg_alert(msg[1]);
					}
					else{
						$('#vi_confirm_box').vi_confirm_box({
						            false_btn: false,
						            message: message,
						            true_btn_text:'Ok',
						    callback: function(data1){
						        if(data1=="yes"){
					        	  $('#quotation_update_modal').modal('hide');
					        	 document.location.reload();
					        	 //quotataion_list_reflect();
						        }
						      }
						});
					}

                }  
		});

	}
});

        	 
</script>
