
<?php 
include "../../../../../../model/model.php";
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
 
$from_date1 = date('Y-m-d', strtotime($from_date));
$to_date1 = date('Y-m-d', strtotime($to_date));

if($from_date!="" && $to_date!=""){ 
    $sq_high_count = mysql_num_rows(mysql_query("select * from enquiry_master_entries where enquiry_id in(select enquiry_id from enquiry_master where enquiry='Strong' and status!='Disabled' and enquiry_date between '$from_date1' and '$to_date1' ) and followup_status='Dropped' and status!='False' "));
 
} 

 $query2 = "SELECT `enquiry_type`, COUNT(`enquiry_type`) AS `value_occurrence` FROM `enquiry_master` where enquiry_id in (select enquiry_id from enquiry_master_entries where followup_status='Dropped' and status!='False') and enquiry_date between '$from_date1' and '$to_date1' and status!='Disabled' GROUP BY `enquiry_type` ORDER BY `value_occurrence` DESC LIMIT 1";

      $sq_drop_type = mysql_fetch_assoc(mysql_query($query2));

  $query = "SELECT `assigned_emp_id`, COUNT(`assigned_emp_id`) AS `value_occurrence` FROM `enquiry_master` where enquiry_id in (select enquiry_id from enquiry_master_entries where followup_status='Dropped' and status!='False' ) and enquiry_date between '$from_date1' and '$to_date1' and status!='Disabled'  GROUP BY `assigned_emp_id` ORDER BY `value_occurrence` DESC LIMIT 1";
 
 $sq_eq_emp = mysql_fetch_assoc(mysql_query($query));

 $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_eq_emp[assigned_emp_id]'"));

  $query1 = "SELECT `assigned_emp_id`, COUNT(`assigned_emp_id`) AS `value_occurrence` FROM `enquiry_master` where enquiry_id in (select enquiry_id from enquiry_master_entries where followup_status='Converted'  and status!='False') and enquiry_date between '$from_date1' and '$to_date1'
      and status!='Disabled' GROUP BY  `assigned_emp_id` ORDER BY `value_occurrence` DESC LIMIT 1";
 
 $sq_eq_emp1 = mysql_fetch_assoc(mysql_query($query1));

 $sq_emp1 = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_eq_emp1[assigned_emp_id]'"));
?>

 
<input type="hidden" id="from_date" value="<?= $from_date1 ?>">
<input type="hidden" id="to_date" value="<?= $to_date1 ?>">
<div class="row mg_tp_20 mg_bt_10">
    <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs col-md-offset-2">
        <div class="widget_parent-bg-img bg-red">
            <div class="widget_parent">
                <div class="stat_content main_block">
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Number of highest strong enquiries dropped </span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= $sq_high_count ?></span>
                   </span>
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Enquiry type having highest dropped enquiries</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""> <?= $sq_drop_type['enquiry_type'] ?></span>
                    </span> 
                </div>   
            </div>
        </div>
        
    </div>
     <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
        <div class="widget_parent-bg-img bg-red">
            <div class="widget_parent">
                <div class="stat_content main_block">
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Highest dropped enquiries from</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= $sq_emp['first_name'].' '.$sq_emp['last_name']?></span>
                   </span>
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Highest Converted enquiries from</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""> <?= $sq_emp1['first_name'].' '.$sq_emp1['last_name'] ?></span>
                    </span> 
                </div>   
            </div>
        </div>
        
    </div>
</div>

<div class="main_block mg_tp_10">
    <div class="col-md-12">
        <div class="app_panel_content Filter-panel">
            <div class="row">
                <?php 
                if($role=="Admin")
                {
                    ?>
                <div class="col-md-3 col-sm-6 mg_bt_10">
                    <select name="emp_id_filter" id="emp_id_filter" style="width:100%" title="Users">
                      <option value="">User</option>
                      <?php 
                      $sq_emp = mysql_query("select * from emp_master where emp_id!='0' and active_flag='Active'");
                      while($row_emp = mysql_fetch_assoc($sq_emp)){
                        ?>
                        <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
                </div>
                <?php
                    }
             elseif($branch_status=='yes' && $role=='Branch Admin'){  ?>
                <div class="col-md-3 col-sm-6 mg_bt_10">
                    <select name="emp_id_filter" id="emp_id_filter" style="width:100%" title="Users">
                       <option value="">User</option>
                <?php     $query = "select * from emp_master where active_flag='Active' and branch_id='$branch_admin_id' order by first_name asc";
                    $sq_emp = mysql_query($query);
                    while($row_emp = mysql_fetch_assoc($sq_emp)){
                        ?>
                        <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                        <?php
                      }
                        ?>
                    </select>
                </div>
                <?php
                    
                    }
                ?>
            
                <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                    <select name="enquiry_type_filter" id="enquiry_type_filter" title="Enquiry Type">
                        <option value="">Enquiry</option>
                        <option value="Bus">Bus</option>
                        <option value="Car Rental">Car Rental</option>
                         <option value="Flight Ticket">Flight Ticket</option>
                        <option value="Group Booking">Group Booking</option>
                        <option value="Hotel">Hotel</option>
                        <option value="Package Booking">Package Booking</option>
                        <option value="Passport">Passport</option>
                        <option value="Train Ticket">Train Ticket</option>
                        <option value="Visa">Visa</option> 
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 mg_bt_10">
                    <select name="enquiry_status_filter" id="enquiry_status_filter" title="Enquiry Status">
                        <option value="">Status</option>
                        <option value="Strong">Strong</option>
                        <option value="Hot">Hot</option>
                        <option value="Cold">Cold</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 ">
                    <button class="btn btn-sm btn-info ico_right" onclick="enquiry_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="div_list_e"></div>
<script>
$('#emp_id_filter').select2();
function enquiry_list_reflect()
{
  var emp_id = $("#emp_id_filter").val();  
  var enquiry_type = $("#enquiry_type_filter").val(); 
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  var enquiry_status = $('#enquiry_status_filter').val();

  $.get( "report_reflect/sales_projection/analysis/enquiry_list_reflect.php" , { emp_id : emp_id , enquiry_type : enquiry_type , from_date : from_date , to_date : to_date , enquiry_status : enquiry_status} , function ( data ) {

        $ ("#div_list_e").html( data ) ;
  } ) ; 
}
     
enquiry_list_reflect();
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
 
