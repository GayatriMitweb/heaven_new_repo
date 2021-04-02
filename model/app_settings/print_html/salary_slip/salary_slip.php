<?php

include "../../../../model/model.php";
include "../print_functions.php";
require("../../../../classes/convert_amount_to_word.php");
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id=$_GET['emp_id'];

$branch_status = $_POST['branch_status'];
$branch_id = $_POST['branch_id_filter'];
$customer_id = $_GET['customer_id'];
$from_date = $_POST['from_date'];

$to_date = $_POST['to_date'];

 $count = 0;
$sq_salary =mysql_fetch_assoc(mysql_query("select * from employee_salary_master where emp_id='$emp_id'")) ;

?>

<!-- header -->
    <section class="print_header main_block">
      <div class="col-md-6 no-pad">
        <div class="print_header_logo">
          <img src="<?php echo $admin_logo_url; ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-6 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
	      	 <h2>Salary Slip</h2>
        </div>
      </div>
    </section>

    <!-- Package -->
    <section class="print_sec main_block">
      <div class="row">
	      <div class="col-xs-12">
	        <div class="print_info_block">
	            <ul class="main_block noType">
	            	<?php $cust_name=mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'")); 
	            	?>
	              <li class="col-md-6"><span>User Name : </span><?= $cust_name['first_name'].' '.$cust_name['last_name'] ?></li>
	              <?php 
	              $month = $sq_salary['month'];
	              if($month==01){$month_name='January';}
						if($month==02){$month_name='February';}
						if($month==03){$month_name='March';}
						if($month==04){$month_name='April';}
						if($month==05){$month_name='May';}
						if($month==06){$month_name='June';}
						if($month==07){$month_name='July';}
						if($month==08){$month_name='August';}
						if($month==09){$month_name='September';}
						if($month==10){$month_name='October';}
						if($month==11){$month_name='November';}
						if($month==12){$month_name='December';}

	              ?>
	               <li class="col-md-6"><span>Month & Year : </span> <?= $month_name .' / '.$sq_salary['year'] ?></li>
	            </ul>
	        </div>
	      </div>
      </div>
    </section>


   
    <section class="print_sec main_block">

		<div class="row"> <div class="col-md-12"> <div class="table-responsive">

			

		<table class="table table-bordered salary_table" id="tbl_list" style="padding: 0 !important; margin: 0 !important" cellpadding="0" cellspacing="0">

		<thead>
			<tr class="table-heading-row">
				<th colspan="2">Earnings</th>
				<th colspan="2">Deduction</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Basic Pay</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['basic_pay']?></td>
				<td>Employer PF</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['employer_pf']?></td>
			</tr>
				<td>Dearness Allowance</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['dear_allow']?></td>
				<td>Employee PF</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['employee_pf']?></td>
				</tr>
			<tr>
				<td>HRA</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['hra']?></td>
				<td>ESIC</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['esic']?></td>
				</tr>
			<tr>
				<td>Travel Allowance</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['travel_allow']?></td>
				<td>PT</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['pt']?></td>
				</tr>
			<tr>
				<td>Medical Allowance</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['medi_allow']?></td>
				<td>TDS</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['tds']?></td>
				</tr>
			<tr>
				<td>Special Allowance</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['special_allow']?></td>
				<td>Labour Welfare Fund</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['labour_all']?></td>
				</tr>
			<tr>
				<td>Uniform Allowance</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['uniform_allowance']?></td>
				<td></td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"></td>
				</tr>
			<tr>
				<td>Incentive</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['incentive']?></td>
				<td></td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"></td>
				</tr>
			<tr>
				<td>Meal Allowance</td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"><?= $sq_salary['meal_allowance']?></td>
				<td></td>
				<td class="text-right" style="border-right: 1px solid #ddd !important"></td>
				</tr>
			

		</tbody>

			<tfoot>
				<tr class="active">
					<th class="text-right" colspan="2">Total Salary : <?= $sq_salary['gross_salary']?></th>
					<th class="text-right" colspan="2"> Total Deductions : <?= $sq_salary['deduction']?></th>
				</tr>
				<tr class="active">
					<th colspan="4" class=" text-right">Net Salary : <?= $sq_salary['net_salary']?></th>
				</tr>

		    </tfoot>

		</table>

		<section class="print_sec main_block inv_rece_footer_top">
			<div class="row">
				<div class="col-md-12">
					<h3 class="no-marg font_5 font_s_14">In Words :<?= $amount_to_word->convert_number_to_words($sq_salary['net_salary']) ?></h3>
				</div>
			</div>
		</section>

