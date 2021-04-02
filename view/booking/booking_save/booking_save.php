<?php
include "../../../model/model.php";

include_once('../../layouts/fullwidth_app_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$financial_year_id = $_SESSION['financial_year_id']; 
$emp_id=$_SESSION['emp_id']; 
$row=mysql_fetch_assoc(mysql_query("select emp_id,first_name, last_name from emp_master where emp_id='$emp_id'"));
$first_name=$row['first_name'];
$last_name=$row['last_name'];
$employee_name = $first_name." ".$last_name; 
$branch_status = $_POST['branch_status'];
$unique_timestapmp = md5(uniqid(rand(), true)); 
$unique_timestapmp = $employee_name."".$unique_timestapmp;
?>
<input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
<input type="hidden" id="txt_unique_timestamp" name="txt_unique_timestamp" value="<?php echo $unique_timestapmp; ?>">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
<input type="hidden" id="hotel_sc" name="hotel_sc">
<input type="hidden" id="hotel_markup" name="hotel_markup">
<input type="hidden" id="hotel_taxes" name="hotel_taxes">
<input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes">
<input type="hidden" id="hotel_tds" name="hotel_tds">
<div class="bk_tab_head bg_light">
    <ul>
        <li>
            <a href="javascript:void(0)" id="tab_1_head" class="active">
                <span class="num">1<i class="fa fa-check"></i></span><br>
                <span class="text">Tour</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_2_head">
                <span class="num">2<i class="fa fa-check"></i></span><br>
                <span class="text">Travelling</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab_3_head">
                <span class="num">3<i class="fa fa-check"></i></span><br>
                <span class="text">Receipt</span>
            </a>
        </li>
    </ul>
</div>

<div class="bk_tabs">
    
    <div id="tab_1" class="bk_tab active">
        <?php include_once('tab_1/tab_1.php'); ?>
    </div>
    <div id="tab_2" class="bk_tab">
        <?php include_once('tab_2/tab_2.php'); ?>
    </div>
    <div id="tab_3" class="bk_tab">
        <?php include_once('tab_3/tab_3.php'); ?>
    </div>

</div>

<?php include "guideline_modal.php"; ?>
<script>

function copy_details(){
	if(document.getElementById("copy_details1").checked){
		var customer_id = $('#customer_id_p').val();
		var base_url = $('#base_url').val();
		
		if(customer_id == 0){				
			var first_name = $('#cust_first_name').val();
			var middle_name = $('#cust_middle_name').val();
			var last_name = $('#cust_last_name').val();
			var birthdate = $('#cust_birth_date').val();

			if(typeof first_name === 'undefined'){ first_name = '';}
			if(typeof middle_name === 'undefined'){ middle_name = '';}
			if(typeof last_name === 'undefined'){ last_name = '';}
			if(typeof birthdate === 'undefined'){ birthdate = '';}

			var table = document.getElementById("tbl_member_dynamic_row");
			var rowCount = table.rows.length;
			for(var i=0; i<rowCount; i++)
			{
				var row = table.rows[i];
				if(row.cells[0].childNodes[0].checked)
				{
					row.cells[3].childNodes[0].value = first_name;
					row.cells[4].childNodes[0].value = middle_name;
					row.cells[5].childNodes[0].value = last_name;
					row.cells[7].childNodes[0].value = birthdate;
  					adolescence_reflect('m_birthdate1');
					calculate_age_member('m_birthdate1');
					payment_details_reflected_data('tbl_member_dynamic_row');
				}
			}
		}
		else{
			$.ajax({
			type:'post',
			url:base_url+'view/load_data/customer_info_load.php',
			data:{customer_id : customer_id},
			success:function(result){
				result = JSON.parse(result);
				var table = document.getElementById("tbl_member_dynamic_row");
				var rowCount = table.rows.length;
				for(var i=0; i<rowCount; i++)
				{
					var row = table.rows[i];
					if(row.cells[0].childNodes[0].checked)
					{
						row.cells[3].childNodes[0].value = result.first_name;
						row.cells[4].childNodes[0].value = result.middle_name;
						row.cells[5].childNodes[0].value = result.last_name;
						row.cells[6].childNodes[0].value = result.gender;
						row.cells[7].childNodes[0].value = result.birth_date;
  					adolescence_reflect('m_birthdate1');
            		calculate_age_member('m_birthdate1');
					payment_details_reflected_data('tbl_member_dynamic_row');
					}
				}
			}
			});	
		}
	}
	else{
		var table = document.getElementById("tbl_member_dynamic_row");
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
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="../js/calculations.js"></script>
<script src="../js/business_rule.js"></script>

<?php 
include_once('../../layouts/fullwidth_app_footer.php');
?>
