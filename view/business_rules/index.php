<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>

<?= begin_panel('Business Rules','') ?>
      <div class="header_bottom">
        <div class="row text-center">
            <label for="rd_taxes" class="app_dual_button active" data-id="1">
		        <input type="radio" id="rd_taxes" name="rd_rules" checked onchange="business_rules_reflect()">
		        &nbsp;&nbsp;Taxes
		    </label>    
		    <label for="rd_tax_rules" class="app_dual_button" data-id="2">
		        <input type="radio" id="rd_tax_rules" name="rd_rules" onchange="business_rules_reflect()">
		        &nbsp;&nbsp;Tax Rule
		    </label>
		    <label for="rd_other_rules" class="app_dual_button" data-id="3">
		        <input type="radio" id="rd_other_rules" name="rd_rules" onchange="business_rules_reflect()">
		        &nbsp;&nbsp;Other Rules
		    </label>
        </div>
      </div> 

  <!--=======Header panel end======-->
<div id="div_rules"></div>
<?= end_panel() ?>
<script>
function business_rules_reflect(){
	var id = $('input[name="rd_rules"]:checked').attr('id');
	if(id=="rd_taxes"){
		$.post('taxes/index.php', {}, function(data){
			$('#div_rules').html(data);
		});
	}
	if(id=="rd_tax_rules"){
		$.post('taxes_rules/index.php', {}, function(data){
			$('#div_rules').html(data);
		});
	}
	if(id=="rd_other_rules"){
		$.post('other/index.php', {}, function(data){
			$('#div_rules').html(data);
		});
	}
}
business_rules_reflect();

function check_validity(id){
  var id = $('#'+id).val();
  if(id === "Permanent"){
    $('#from_date').attr({ 'disabled': 'disabled' });
    $('#to_date').attr({ 'disabled': 'disabled' });
  }else{
    $('#from_date').removeAttr('disabled');
    $('#to_date').removeAttr('disabled');
  }
}

function check_amount(id){
  var id = $('#'+id).val();
  if(id === "Flat"){
    $('#target_amount').attr({ 'disabled': 'disabled' });
  }else{
    $('#target_amount').removeAttr('disabled');
  }
}
function values_load(id){
	var currency = $('#currency_code').val();
  	var condition = $("#"+id).val();
	var count = id.substring(9);
	var html = '';

	document.getElementById('currency'+count).setAttribute("style", "display:none;");
	document.getElementById('amount'+count).setAttribute("style", "display:none;");
    $('#value'+count).removeAttr('disabled');

	html = '<option value="">Select Value</option>';
	$("#value"+count).html('');
	$("#value"+count).html(html);
	
	if(condition === "2"){
		html = '<option value="">Select Value</option></option><option value="Domestic">Domestic</option><option value="International">International</option>';
		$("#value"+count).html(html);
	}
	else if(condition === "3"){
		html = '<option value="">*Mode</option><option value="Cash"> Cash </option><option value="Cheque"> Cheque </option><option value="Credit Card">Credit Card</option><option value="NEFT"> NEFT </option><option value="RTGS"> RTGS </option><option value="IMPS"> IMPS </option><option value="DD"> DD </option><option value="Online"> Online </option><option value="Credit Note"> Credit Note </option><option value="Other"> Other </option>';
		$("#value"+count).html(html);
	}
	else if(condition === "10"){
		html = '<option value="">Select Value</option><option value="All">All</option><option value="Hotel">Hotel</option><option value="Transporter">Transporter</option><option value="DMC">DMC</option><option value="Car Rental">Car Rental</option><option value="Visa">Visa</option><option value="Flight">Flight</option><option value="Activity">Activity</option><option value="Cruise">Cruise</option><option value="Train">Train</option><option value="Passport">Passport</option><option value="Insurance">Insurance</option><option value="Other">Other</option>';
		$("#value"+count).html(html);
	}
	else if(condition === "8"){
		html = '<option value="">Select Value</option><option value="All">All</option><option value="Hotel">Hotel</option><option value="Transport">Transport</option><option value="DMC">DMC</option><option value="Car Rental">Car Rental</option><option value="Visa">Visa</option><option value="Flight">Flight</option><option value="Activity">Activity</option><option value="Cruise">Cruise</option><option value="Train">Train</option><option value="Passport">Passport</option><option value="Insurance">Insurance</option><option value="Other">Other</option>';
		$("#value"+count).html(html);
	}
	else if(condition === "9"){
		html = '<option value="">Select Value</option><option value="All">All</option><option value="Hotel Service Fee">Hotel Service Fee</option><option value="Transporter Service Fee">Transporter Service Fee</option><option value="DMC Service Fee">DMC Service Fee</option><option value="Car Rental Service Fee">Car Rental Service Fee</option><option value="Visa Service Fee">Visa Service Fee</option><option value="Flight Service Fee">Flight Service Fee</option><option value="Activity Service Fee">Activity Service Fee</option><option value="Cruise Service Fee">Cruise Service Fee</option><option value="Train Service Fee">Train Service Fee</option><option value="Passport Service Fee">Passpor Service Feet</option><option value="Insurance Service Fee">Insurance Service Fee</option><option value="Other Service Fee">Other Service Fee</option>';
		$("#value"+count).html(html);
	}
	else if(condition === "13"){
		html = '<option value="">Select Value</option><option value="Sale">Sale</option><option value="Refund">Refund</option><option value="Reissue">Reissue</option>';
		$("#value"+count).html(html);
	}
	else if(condition === "14"){
		html = '<option value="">Select Value</option><option value="Economy">Economy</option><option value="Premium Economy">Premium Economy</option><option value="Business Class">Business Class</option><option value="First Class">First Class</option>';
		$("#value"+count).html(html);
	}
	else if(condition === "16"){
		html = '<option value="">Select Value</option><option value="TRUE">TRUE</option>';
		$("#value"+count).html(html);
	}
	else if(condition === "1" || condition === "5" || condition === "6" || condition === "7" || condition === "12"){
		$.post('get_condition_values.php', {condition : condition}, function(data){
			$("#value"+count).append(data);
		});
	}
	else{
    	document.getElementById('currency'+count).setAttribute("style", "display:show;");
    	document.getElementById('amount'+count).setAttribute("style", "display:show;");
    	$('#amount'+count).removeAttr('readonly');
		$('#value'+count).attr({ 'disabled': 'disabled' });
		$('#currency'+count).val(currency);
	}
}
function target_amount_change(id, type){
  var value = document.getElementById(id).value;
  var col = (type == 'save') ? 3 : 4;
  switch(value){
    case 'Exclusive' : document.getElementById("target_amount").options[col].disabled = false;break;
    case 'Inclusive' : document.getElementById("target_amount").options[col].disabled = true;break;
  }
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>