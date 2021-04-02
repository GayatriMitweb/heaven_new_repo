<?php 
  $tour_group = $sq_quotation['tour_group'];
  $sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$tour_group'"));

	$row_cost = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_group[tour_id]'"));
?>
<?php
        $tour_cost = $sq_quotation['tour_cost'];
        $service_charge = $sq_quotation['service_charge'];

        $bsmValues = json_decode($sq_quotation['bsm_values']);
        $service_tax_amount = 0;
        if($sq_quotation['service_tax_subtotal'] !== 0.00 && ($sq_quotation['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$sq_quotation['service_tax_subtotal']);
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
        $service_tax = explode(':',$service_tax_subtotal1[$i]);
        $service_tax_amount = $service_tax_amount + $service_tax[2];
        }
        }
       
        foreach($bsmValues[0] as $key => $value){
        switch($key){
        case 'basic' : $tour_cost = ($value != "") ? $tour_cost + $service_tax_amount : $tour_cost;$inclusive_b = $value;break;
        case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;break;
        
        }
        }
        $readonly = ($inclusive_d != '') ? 'readonly' : '';
        // echo "<pre>";
        // var_dump($bsmValues)
        ?>
<form id="frm_tab4_u">
	<div class="row mg_bt_10">
		<div class="col-md-2">
            <small>&nbsp;</small>
			<input type="hidden" id="pck_adult_cost" name="pck_adult_cost" value="<?= $row_cost['adult_cost'] ?>">
			<input type="text" id="adult_cost2" name="adult_cost2" placeholder="Adult Cost" title="Adult Cost"  onchange="group_quotation_cost_calculate1(this.id);validate_balance(this.id)" value="<?php echo $sq_quotation['adult_cost']; ?>">  
			<input type="hidden" id="total_adult1" name="total_adult1" value="0">  
		</div>
		<div class="col-md-2">
            <small>&nbsp;</small>
			<input type="hidden" id="pck_with_bed_cost" name="pck_with_bed_cost" value="<?= $row_cost['child_with_cost'] ?>">
			<input type="text" id="with_bed_cost2" name="with_bed_cost2" placeholder="Child With Bed Cost" title="Child With Bed Cost"  onchange="group_quotation_cost_calculate1(this.id);validate_balance(this.id)"  value="<?php echo $sq_quotation['with_bed_cost']; ?>"> 
		</div>
		<div class="col-md-2">
            <small>&nbsp;</small>
			<input type="hidden" id="pck_child_cost" name="pck_child_cost" value="<?= $row_cost['child_without_cost'] ?>">
			<input type="text" id="children_cost2" name="children_cost2" placeholder="Child Without Bed Cost" title="Child Without Bed Cost" onchange="group_quotation_cost_calculate1(this.id);validate_balance(this.id)"  value="<?php echo $sq_quotation['children_cost']; ?>"> 
			<input type="hidden" id="total_child1" name="total_child1" value="0">  
		</div>
		<div class="col-md-2"> 
            <small>&nbsp;</small>
			<input type="hidden" id="pck_infant_cost" name="pck_infant_cost" value="<?= $row_cost['infant_cost'] ?>">
			<input type="text" id="infant_cost2" name="infant_cost2" placeholder="Infant Cost" title="Infant Cost"  onchange="group_quotation_cost_calculate1(this.id);validate_balance(this.id)"  value="<?php echo $sq_quotation['infant_cost']; ?>">  
			<input type="hidden" id="total_infant1" name="total_infant1" value="0">  
		</div>
		
		<div class="col-md-2">
            <small id="basic_show" style="color:#000000"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
			<input type="text" id="tour_cost2" name="tour_cost2" placeholder="Total Tour Cost" title="Total Tour Cost" onchange="get_auto_values('quotation_date','tour_cost2','payment_mode','service_charge','markup','update','true','basic','basic');validate_balance(this.id)"  value="<?php echo $sq_quotation['tour_cost']; ?>" readonly>
		</div>
	</div>
	<div class="row mg_bt_10">
		<div class="col-md-2">
            <small id="service_show" style="color:#000000"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>	  
			<input type="text" id="service_charge" name="service_charge" onchange="group_quotation_cost_calculate1(); validate_balance(this.id)"  placeholder="Service Charge" title="Service Charge"  value="<?php echo $sq_quotation['service_charge']; ?>">
		</div>
		
		<div class="col-md-2">
            <small>&nbsp;</small>
			<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" readonly placeholder="Tax Amount" title="Tax Amount"  value="<?php echo $sq_quotation['service_tax_subtotal']; ?>" onchange="validate_balance(this.id)">
		</div>
		<div class="col-md-2">
		<small>&nbsp;</small>
			<input type="text" id="total_tour_cost" class="amount_feild_highlight text-right" name="total_tour_cost" placeholder="Quotation Cost" title="Quotation Cost"  value="<?php echo $sq_quotation['quotation_cost']; ?>"  readonly>
		</div>
	</div>
	<div class="row mg_tp_20">
		<div class="col-sm-6 col-xs-12 mg_bt_10">
		<h3 class="editor_title">Inclusions</h3>
		 	<TEXTAREA class="feature_editor" id="incl1" name="incl" placeholder="Inclusions" rows="3"><?= $sq_quotation['incl'] ?></TEXTAREA> 
		</div>
		<div class="col-sm-6 mg_bt_10">
		<h3 class="editor_title">Exclusions</h3>
		 	<TEXTAREA class="feature_editor" id="excl1" name="excl" placeholder="Exclusions" rows="3"><?= $sq_quotation['excl'] ?></TEXTAREA> 
		</div>
		<div class="col-sm-4 mg_bt_10 hidden">
		<h3 class="editor_title">Terms & Conditions</h3>
		 	<TEXTAREA class="feature_editor" id="terms1" name="terms" placeholder="Terms & Conditions" rows="3"><?= $sq_quotation['terms'] ?></TEXTAREA> 
		</div>
	</div>
	<div class="row mg_tp_20 text-center">
		<div class="col-md-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab3()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-sm btn-success" id="btn_quotation_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
		</div>
	</div>
</form>

<script>
$(document).ready(function(){
  $('#terms1').wysiwyg({
    controls:"bold,italic,|,undo,redo,image",
    initialContent: '',
  });
});

function cost_reflect()
{
  if(adult_cost2==""){ adult_cost2 = 0;}
  if(children_cost2==""){children_cost2 = 0;}
  if(infant_cost2==""){ infant_cost2 = 0;}
  if(with_bed_cost2==""){ with_bed_cost2 = 0;}

  var total_adult = $('#total_adult1').val();
  var total_infant = $('#total_infant1').val();
  var total_wb_children = $('#children_without_bed1').val();
  var child_with_bed = $('#children_with_bed1').val();
  
  var pck_adult_cost = $('#pck_adult_cost').val();
  var pck_child_cost = $('#pck_child_cost').val();
  var pck_infant_cost = $('#pck_infant_cost').val();
  var pck_with_bed_cost = $('#pck_with_bed_cost').val();


  var adult_cost1 = total_adult * pck_adult_cost;
  $("#adult_cost2").val(parseFloat(adult_cost1));
 
  var child_cost1 = total_wb_children * pck_child_cost;
  $("#children_cost2").val(parseFloat(child_cost1));

  var infant_cost1 = total_infant * pck_infant_cost;
  $("#infant_cost2").val(parseFloat(infant_cost1));
 
  var with_bed_cost3 = child_with_bed * pck_with_bed_cost;  
  $("#with_bed_cost2").val(parseFloat(with_bed_cost3));

  group_quotation_cost_calculate1('');
}
 
function group_quotation_cost_calculate1(id)
{
  if(adult_cost2==""){ adult_cost2 = 0;}
  if(children_cost2==""){children_cost2 = 0;}
  if(infant_cost2==""){ infant_cost2 = 0;}
  if(with_bed_cost2==""){ with_bed_cost2 = 0;}

  var adult_cost1 = $('#adult_cost2').val();
  var infant_cost1 = $('#infant_cost2').val();
  var children_cost1 = $('#children_cost2').val();
  var with_bed_cost1 = $('#with_bed_cost2').val();
 
  
  if(service_tax==""){service_tax = 0;}
  if(total_tour_cost==""){total_tour_cost1 = 0;}

  var total2 = parseFloat(adult_cost1) + parseFloat(children_cost1) + parseFloat(infant_cost1) + parseFloat(with_bed_cost1);

  $('#tour_cost2').val(total2.toFixed(2));

  if (id != 'tour_cost2') {
		$('#tour_cost2').trigger('change');
	}
  var service_tax_amount = 0;
  var service_tax_subtotal = $('#service_tax_subtotal').val();
  var total_tour_cost = $('#total_tour_cost').val();
  var service_charge = $('#service_charge').val();
  
	if (parseFloat(service_tax_subtotal) !== 0.0 && service_tax_subtotal !== '') {
		var service_tax_subtotal1 = service_tax_subtotal.split(',');
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}
	total2 = ($('#basic_show').html() == '&nbsp;') ? total2 : parseFloat($('#basic_show').text().split(' : ')[1]);
	service_charge = ($('#service_show').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show').text().split(' : ')[1]);
  total_tour_cost1 = parseFloat(total2) + parseFloat(service_tax_amount)+ parseFloat(service_charge);
  $('#total_tour_cost').val(Math.round(total_tour_cost1));

}
function switch_to_tab3(){ $('a[href="#tab3_u"]').tab('show'); }

$('#frm_tab4_u').validate({
	rules:{
		markup_cost : { required : true, number : true },
		tour_cost : { required : true, number: true },
	},
	submitHandler:function(form, e){
		e.preventDefault();
		var quotation_id = $('#quotation_id1').val();
		var enquiry_id = $('#enquiry_id1').val();
		var tour_name = $('#tour_name1').val();
		var from_date = $('#from_date1').val();
		var to_date = $('#to_date1').val();
		var total_days = $('#total_days1').val();
		var customer_name = $('#customer_name1').val();
		var email_id = $('#email_id1').val();
		var total_adult = $('#total_adult1').val();
		var total_children = parseFloat($('#children_with_bed1').val())+parseFloat($('#children_without_bed1').val());
		var total_infant = $('#total_infant1').val();
		var total_passangers = $('#total_passangers1').val();
		var children_without_bed = $('#children_without_bed1').val();
		var children_with_bed = $('#children_with_bed1').val();		
		var quotation_date = $('#quotation_date').val();
		var booking_type = $('#booking_type2').val();
		var adult_cost = $('#adult_cost2').val();
		var children_cost = $('#children_cost2').val();
		var infant_cost = $('#infant_cost2').val();
		var with_bed_cost = $('#with_bed_cost2').val();
		var tour_cost = $('#tour_cost2').val();
		var markup_cost = $('#markup_cost2').val();
		var service_charge = $('#service_charge').val();
		var service_tax = $('#service_tax2').val();
		var taxation_id = $('#taxation_id').val();
		var service_tax_subtotal = $('#service_tax_subtotal').val();
		var total_tour_cost = $('#total_tour_cost').val();
		var incl = $('#incl1').val();
		var excl = $('#excl1').val();
		var terms = $('#terms1').val();

 		if(parseFloat(taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; } 

		//Train Informationg	
		var train_from_location_arr = new Array();
		var train_to_location_arr = new Array();
		var train_class_arr = new Array();
		var train_arrival_date_arr = new Array();
		var train_departure_date_arr = new Array();
		var train_id_arr = new Array();

			var table = document.getElementById("tbl_package_tour_quotation_dynamic_train");
		  	var rowCount = table.rows.length;
			 
			  for(var i=0; i<rowCount; i++)
			  {
			    var row = table.rows[i];
			    
			    if(row.cells[0].childNodes[0].checked)
			    {
			       var train_from_location1 = row.cells[2].childNodes[0].value;         
			       var train_to_location1 = row.cells[3].childNodes[0].value;   
			       var train_class = row.cells[4].childNodes[0].value;         
				   var train_arrival_date = row.cells[6].childNodes[0].value;         
				   var train_departure_date = row.cells[5].childNodes[0].value;         	

			       if(row.cells[7] && row.cells[7].childNodes[0]){
			       	var train_id = row.cells[7].childNodes[0].value;
			       }
			       else{
			       	var train_id = "";
				   }
				  
			       train_from_location_arr.push(train_from_location1);
			       train_to_location_arr.push(train_to_location1);
			       train_class_arr.push(train_class);
				   train_arrival_date_arr.push(train_arrival_date);
				   train_departure_date_arr.push(train_departure_date);
			       train_id_arr.push(train_id); 
			    }      
			  }
		//Plane Information 
		var from_city_id_arr = new Array();
        var to_city_id_arr = new Array(); 	
		var plane_from_location_arr = new Array();
		var plane_to_location_arr = new Array();
		var airline_name_arr = new Array();
		var plane_class_arr = new Array();
		var arraval_arr = new Array();
		var dapart_arr = new Array();
		var plane_id_arr = new Array();

		var table = document.getElementById("tbl_package_tour_quotation_dynamic_plane_update");
		  var rowCount = table.rows.length;
		  
		  for(var i=0; i<rowCount; i++)
		  {
		    var row = table.rows[i];
		     
		    if(row.cells[0].childNodes[0].checked)
		    {
			   var plane_from_location1 = row.cells[2].childNodes[0].value;          
		       var plane_to_location1 = row.cells[3].childNodes[0].value;
		       var airline_name = row.cells[4].childNodes[0].value;  
		       var plane_class = row.cells[5].childNodes[0].value;  
		       var dapart1 = row.cells[6].childNodes[0].value;       
		       var arraval1 = row.cells[7].childNodes[0].value;
			   var from_city_id1 = row.cells[8].childNodes[0].value;
		       var to_city_id1 = row.cells[9].childNodes[0].value;

		       if(row.cells[10] && row.cells[10].childNodes[0]){
		       	var plane_id = row.cells[10].childNodes[0].value;
		       }
		       else{
		       	var plane_id = "";
		       }     
		       
		       from_city_id_arr.push(from_city_id1);
               to_city_id_arr.push(to_city_id1);
		       plane_from_location_arr.push(plane_from_location1);
		       plane_to_location_arr.push(plane_to_location1);
		       airline_name_arr.push(airline_name);
		       plane_class_arr.push(plane_class);
		       arraval_arr.push(arraval1);
		       dapart_arr.push(dapart1);
		       plane_id_arr.push(plane_id);
		    }      
		  }

		  /* Cruise Info*/
		  var dept_datetime_arr = new Array();
		  var arrival_datetime_arr = new Array();
		  var route_arr = new Array();
		  var cabin_arr = new Array();
		  var sharing_arr = new Array();
		  var c_entry_id_arr= new Array();

		  var table = document.getElementById("tbl_dynamic_cruise_quotation_update");
		  var rowCount = table.rows.length;
		  
		  for(var i=0; i<rowCount; i++)
		  {
		    var row = table.rows[i];
		    
		    if(row.cells[0].childNodes[0].checked)
		    {
		       var dept_datetime = row.cells[2].childNodes[0].value;         
		       var arrival_datetime = row.cells[3].childNodes[0].value;         
			   var route = row.cells[4].childNodes[0].value;         
			   var cabin = row.cells[5].childNodes[0].value;         
			   var sharing = row.cells[6].childNodes[0].value;         
		       if(row.cells[7]){
		       	 var c_entry_id = row.cells[7].childNodes[0].value;    ;
		       }
		       else{
		       	 var c_entry_id = '';
		       }
		       if(dept_datetime=="")
		       {
		          error_msg_alert('Enter cruise departure datetime in row'+(i+1));
		          return false;
		       }
		       if(arrival_datetime=="")
		       {
		          error_msg_alert('Enter cruise arrival datetime  in row'+(i+1));
		          return false;
		       }
		       if(route=="")
		       {
		          error_msg_alert('Enter cruise route in row'+(i+1));
		          return false;
		       }
		       if(cabin=="")
		       {
		          error_msg_alert('Enter cruise cabin in row'+(i+1));
		          return false;
		       }  
		       dept_datetime_arr.push(dept_datetime);
		       arrival_datetime_arr.push(arrival_datetime);
			   route_arr.push(route);
			   cabin_arr.push(cabin);
			   sharing_arr.push(sharing);
			   c_entry_id_arr.push(c_entry_id);
		    }      
		  }
		  var bsmValues = [];
            bsmValues.push({
            "basic" : $('#basic_show').find('span').text(),
            "service" : $('#service_show').find('span').text(),
            "markup" : $('#markup_show').find('span').text(),
            "discount" : $('#discount_show1').find('span').text()
            });
		var base_url = $('#base_url').val();
		$('#btn_quotation_update').button('loading');

		$.ajax({
			type:'post',
			url: base_url+'controller/package_tour/quotation/group_tour/quotation_update.php',
			data:{ quotation_id : quotation_id,tour_name : tour_name, from_date : from_date, to_date : to_date, total_days : total_days, customer_name : customer_name, email_id : email_id, total_adult : total_adult, total_children : total_children, total_infant : total_infant, total_passangers : total_passangers, children_without_bed : children_without_bed, children_with_bed : children_with_bed, quotation_date : quotation_date, booking_type : booking_type,adult_cost : adult_cost,children_cost : children_cost, infant_cost : infant_cost,with_bed_cost : with_bed_cost,tour_cost : tour_cost,markup_cost: markup_cost,service_charge : service_charge,taxation_id : taxation_id,service_tax : service_tax,service_tax_subtotal : service_tax_subtotal,total_tour_cost : total_tour_cost, train_from_location_arr : train_from_location_arr, train_to_location_arr : train_to_location_arr, train_class_arr : train_class_arr, train_arrival_date_arr : train_arrival_date_arr, train_departure_date_arr : train_departure_date_arr, train_id_arr : train_id_arr, plane_from_location_arr : plane_from_location_arr, plane_to_location_arr : plane_to_location_arr, plane_id_arr : plane_id_arr, plane_class_arr : plane_class_arr,airline_name_arr : airline_name_arr, arraval_arr : arraval_arr, dapart_arr : dapart_arr,dept_datetime_arr : dept_datetime_arr,arrival_datetime_arr : arrival_datetime_arr,route_arr : route_arr,cabin_arr : cabin_arr,sharing_arr : sharing_arr,c_entry_id_arr : c_entry_id_arr, enquiry_id : enquiry_id,incl:incl,excl : excl,terms :terms, from_city_id_arr : from_city_id_arr, to_city_id_arr : to_city_id_arr,bsmValues:bsmValues},
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
