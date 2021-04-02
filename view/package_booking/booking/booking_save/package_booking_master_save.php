<?php 
include "../../../../model/model.php";
include_once('../../../layouts/fullwidth_app_header.php'); 
$branch_admin_id = $_SESSION['branch_admin_id']; 
$financial_year_id = $_SESSION['financial_year_id']; 
$emp_id=$_SESSION['emp_id']; 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status'];
$sq=mysql_query("select emp_id,first_name, last_name from emp_master where emp_id='$emp_id'");

if($row=mysql_fetch_assoc($sq)){
    $first_name=$row['first_name'];
    $last_name=$row['last_name'];
}
$booker_name = $first_name." ".$last_name; 

$unique_timestapmp = md5(uniqid(rand(), true));
$unique_timestapmp = $emp_name."".$unique_timestapmp;
 
?>
    <input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
    <input type="hidden" id="txt_unique_timestamp" name="txt_unique_timestamp" value="<?php echo $unique_timestapmp; ?>">
    <input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
    <input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
    <input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch ?>" >
    <input type="hidden" id="hotel_sc" name="hotel_sc">
    <input type="hidden" id="hotel_markup" name="hotel_markup">
    <input type="hidden" id="hotel_taxes" name="hotel_taxes">
    <input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes">
    <input type="hidden" id="hotel_tds" name="hotel_tds">
<div class="bk_tab_head bg_light">
    <ul> 
        <li>
            <a href="javascript:void(0)" id="tab_1_head" class="active">
                <span class="num" title="Tour Details">1<i class="fa fa-check"></i></span><br>
                <span class="text">Tour Details</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_2_head">
                <span class="num" title="Traveling">2<i class="fa fa-check"></i></span><br>
                <span class="text">Travelling</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_3_head">
                <span class="num" title="Hotel & Transport">3<i class="fa fa-check"></i></span><br>
                <span class="text">Hotel & Transport</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_4_head">
                <span class="num" title="Receipt">4<i class="fa fa-check"></i></span><br>
                <span class="text">Receipt</span>
            </a>
        </li>
    </ul>
</div>

<div class="bk_tabs">
    <div id="tab_1" class="bk_tab active">
        <?php include_once("tab_1/package_booking_master_save_tab1.php"); ?>  
    </div>

    <div id="tab_2" class="bk_tab">
            <?php include_once("tab_2/package_booking_master_save_tab2.php"); ?>
    </div>

    <div id="tab_3" class="bk_tab">
            <?php include_once("tab_3/package_booking_master_save_tab3.php"); ?>   
    </div>
    <div id="tab_4" class="bk_tab">
            <?php include_once("tab_4/package_booking_master_save_tab4.php"); ?>   
    </div>
</div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
function validate_issueDate (from, to) {
	  var from_date = $('#'+from).val(); 
		var to_date = $('#'+to).val(); 

		var parts = from_date.split('-');
		var date = new Date();
		var new_month = parseInt(parts[1])-1;
		date.setFullYear(parts[2]);
		date.setDate(parts[0]);
		date.setMonth(new_month);

		var parts1 = to_date.split('-');
		var date1 = new Date();
		var new_month1 = parseInt(parts1[1])-1;
		date1.setFullYear(parts1[2]);
		date1.setDate(parts1[0]);
		date1.setMonth(new_month1);
        var today = new Date();

		var one_day=1000*60*60*24;

		var from_date_ms = date.getTime();
		var to_date_ms = date1.getTime();

		if(from_date_ms < today){
        //alert(from_date_ms);
            error_msg_alert("Date cannot be past date");
            $('#'+from).css({'border':'1px solid red'});  
            document.getElementById(from).value="";
            $('#'+from).focus();
            g_validate_status = false;
            return false;
        } 
		else if(from_date_ms>to_date_ms ){
		error_msg_alert(" To Date should be greater than From Date");
		$('#'+to).css({'border':'1px solid red'});  
			document.getElementById(to).value="";
			$('#'+to).focus();
			g_validate_status = false;
		return false;
    } 
  }

function copy_details(){
	if(document.getElementById("copy_details1").checked){
		var customer_id = $('#customer_id_p').val();
		var base_url = $('#base_url').val();
		
		if(customer_id != '' || customer_id != 0){
			$.ajax({
			type:'post',
			url:base_url+'view/load_data/customer_info_load.php',
			data:{customer_id : customer_id},
			success:function(result){
				result = JSON.parse(result);
				var table = document.getElementById("tbl_package_tour_member");
				var rowCount = table.rows.length;
				var row = table.rows[0];
				
				row.cells[3].childNodes[0].value = result.first_name;
				row.cells[4].childNodes[0].value = result.middle_name;
				row.cells[5].childNodes[0].value = result.last_name;
				row.cells[6].childNodes[0].value = result.gender;
				row.cells[7].childNodes[0].value = result.birth_date;
				row.cells[8].childNodes[0].value = result.age;
				adolescence_reflect('m_birthdate1');
				calculate_age_member('m_birthdate1');
			}
			});	
		}
	}
	else{
		var table = document.getElementById("tbl_package_tour_member");
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++)
		{
			var row = table.rows[i];
			if(row.cells[0].childNodes[0].checked)
			{
				row.cells[3].childNodes[0].value = '';
				row.cells[4].childNodes[0].value = '';
				row.cells[5].childNodes[0].value = '';
				row.cells[7].childNodes[0].value = '';
				row.cells[8].childNodes[0].value = '';
			}
		}
	}
}
</script>
<script src='../js/calculations.js'></script>
<script src='../js/business_rule_calculation.js'></script>
<?php
include_once('../../../layouts/fullwidth_app_footer.php');
?>