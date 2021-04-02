<?php

include "../../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='group_tour/payment/index.php'"));
$branch_status = $sq['branch_status'];
/*======******Header******=======*/

// require_once('../../layouts/admin_header.php');
?>
<input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
 <!-- begin_panel('Group Tour Receipt',79) ?> -->
<div class="row text-right mg_bt_20">

    <div class="col-xs-12">

      <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>

        <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Receipt</button>

    </div>

</div>

 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >

<div class="app_panel_content Filter-panel">

  <div class="row">

      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

            <select name="cust_type_filter" id="cust_type_filter" style="width:100%" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">

                <?php get_customer_type_dropdown(); ?>
                
                
                
                

            </select>

      </div>

      <div  id="company_div" class="hidden">

      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    

      </div> 
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

        <select id="booking_id_filter" name="booking_id_filter" style="width:100%" title="Booking Id"> 

              <?php get_group_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id); ?>

        </select>

      </div>

      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

          <select name="payment_mode_filter" id="payment_mode_filter" title="Mode">

              <?php get_payment_mode_dropdown(); ?>

          </select>

      </div>   
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

          <select id="tour_id_filter" name="tour_id_filter" onchange="tour_group_dynamic_reflect(this.id,'group_id_filter');" style="width:100%" title="Select Tour"> 

              <option value=""> Tour Name  </option>

              <?php

                  $sq=mysql_query("select tour_id,tour_name from tour_master order by tour_name");

                  while($row=mysql_fetch_assoc($sq))

                  {

                    echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";

                  }    

              ?>

          </select>

      </div>

       <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

        <select class="form-control" id="group_id_filter" name="group_id_filter" onchange="traveler_member_reflect();" title="Tour Group"> 

            <option value=""> Tour Group </option>        

        </select>

      </div><div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

          <input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date">

      </div> 

      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

          <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">

      </div>    



      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 hidden">

          <select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">

              <?php get_financial_year_dropdown(); ?>

          </select>

      </div>

  </div>

  <div class="row">     

      <div class="col-xs-12 text-center">

          <button class="btn btn-sm btn-info ico_right" onclick="list_reflect();bank_receipt()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

      </div>

  </div>

</div>



<div id="div_modal"></div>

<div id="div_list" class="main_block loader_parent mg_tp_20">
<div class="table-responsive">
        <table id="gtour_r_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="receipt_data"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>

$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#booking_id_filter, #tour_id_filter, #customer_id_filter, #cust_type_filter').select2();

dynamic_customer_load('','');
var columns = [
	{ title : "S_No"},
	{ title : " "},
	{ title : "Booking_ID"},
  { title : "Customer_Name"},
  { title : "Tour"},
	{ title : "Tour_Group"},
	{ title : "Mode"},
	{ title : "Receipt_Date"},
	{ title : "Branch_Name"},
	{ title : "Amount", className : "success"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
];

function save_modal()

{
    var branch_status = $('#branch_status').val();
    $('#btn_save_modal').button('loading');
    var base_url = $('#base_url').val();
    $.post(base_url+'/view/group_tour/payment/save_modal.php', {branch_status : branch_status}, function(data){

        $('#btn_save_modal').button('reset');

        $('#div_modal').html(data);

    });

}

function update_modal(payment_id)

{
  var base_url = $('#base_url').val();
    $.post(base_url+'/view/group_tour/payment/update_modal.php', { payment_id : payment_id  }, function(data){

        $('#div_modal').html(data);

    });

}

function list_reflect()

{
    $('#div_list').append('<div class="loader"></div>');
    var tour_id = $('#tour_id_filter').val();

    var group_id = $('#group_id_filter').val();

    var customer_id = $('#customer_id_filter').val();

    var booking_id = $('#booking_id_filter').val();

    var payment_mode = $('#payment_mode_filter').val();

    var from_date = $('#from_date_filter').val();

    var to_date = $('#to_date_filter').val();

    var financial_year_id = $('#financial_year_id_filter').val();

    var cust_type = $('#cust_type_filter').val();

    var company_name = $('#company_filter').val();
    var branch_status = $('#branch_status').val();
    var base_url = $('#base_url').val();

    $.post(base_url+'/view/group_tour/payment/list_reflect.php', { tour_id : tour_id, group_id : group_id, customer_id : customer_id, booking_id : booking_id, payment_mode : payment_mode, from_date : from_date, to_date : to_date, financial_year_id : financial_year_id , cust_type : cust_type, company_name : company_name, branch_status : branch_status}, function(data){

         //$('#div_list').html(data);
        pagination_load(data,columns,true,true,10,'gtour_r_book');
        $('.loader').remove();
    });

}

list_reflect();

function customer_booking_dropdown_load(){

    var customer_id = $('#customer_id_filter').val();
    var base_url = $('#base_url').val();
    $.post(base_url+'/view/group_tour/payment/customer_booking_dropdown_load.php', { customer_id : customer_id }, function(data){

        $('#booking_id_filter').html(data);

    });

}

function company_name_reflect()

{  
  var branch_status = $('#branch_status').val();
  var cust_type = $('#cust_type_filter').val();
  var base_url = $('#base_url').val();
    $.post(base_url+'/view/group_tour/payment/company_name_load.php', { cust_type : cust_type, branch_status : branch_status }, function(data){

      if(cust_type=='Corporate'){
        $('#company_div').addClass('company_class');  
      }
      else
      {
        $('#company_div').removeClass('company_class');   
      }
      $('#company_div').html(data);
    });

}

company_name_reflect();

function bank_receipt(){
	var payment_mode = $('#payment_mode_filter').val();
	var base_url = $('#base_url').val();
	$.post(base_url+'view/hotels/booking/payment/bank_receipt_generate.php',{payment_mode : payment_mode}, function(data){
		$('#receipt_data').html(data);
	});
}

function excel_report()

{

  var tour_id = $('#tour_id_filter').val();

  var group_id = $('#group_id_filter').val();

  var customer_id = $('#customer_id_filter').val();

  var booking_id = $('#booking_id_filter').val();

  var payment_for = $("#cmb_payment_for").val();

  var payment_mode = $('#payment_mode_filter').val();

  var from_date = $('#from_date_filter').val();

  var to_date = $('#to_date_filter').val();

  var financial_year_id = $('#financial_year_id_filter').val();

  var cust_type = $('#cust_type_filter').val();

  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
  
  var base_url = $('#base_url').val();
  window.location = base_url+'/view/group_tour/payment/excel_report.php?tour_id='+tour_id+'&from_date='+from_date+'&to_date='+to_date+'&financial_year_id='+financial_year_id+'&group_id='+group_id+'&customer_id='+customer_id+'&booking_id='+booking_id+'&payment_for='+payment_for+'&payment_mode='+payment_mode+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;

}

//*******************Get Dynamic Customer Name Dropdown**********************//

  function dynamic_customer_load(cust_type, company_name)

  {

    var cust_type = $('#cust_type_filter').val();
    var branch_status = $('#branch_status').val();
    var company_name = $('#company_filter').val();
    var base_url = $('#base_url').val();
      $.get(base_url+"/view/group_tour/payment/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){

      $('#customer_div').html(data);

    });   

  }

  function cash_bank_receipt_generate()

{

  var bank_name_reciept = $('#bank_name_reciept').val();



  var payment_amount = 0;

  var payment_type = 'cash';

  var payment_id = '';



  if($('input[name="chk_receipt"]:checked').length==0){

    error_msg_alert('Please select at least one payment to generate receipt!');

    return false;

  }



  $('input[name="chk_receipt"]:checked').each(function(){



    var amount = $(this).attr('data-amount');

    payment_amount = parseFloat(payment_amount) + parseFloat(amount);



  });



  var base_url = $('#base_url').val();



  url = base_url+'view/bank_receipts/group_tour_payment/cash_payment_receipt.php?payment_amount='+payment_amount+'&payment_type='+payment_type+'&payment_id='+payment_id+'&bank_name_reciept='+bank_name_reciept;

                window.open(url, '_blank');  

}





function cheque_bank_receipt_generate()

{

  var bank_name_reciept = $('#bank_name_reciept').val();

  var payment_amount = 0;

  var payment_id_arr = new Array();

  var branch_name_arr = new Array();



  $('input[name="chk_receipt"]:checked').each(function(){



    var amount = $(this).attr('data-amount');

    var payment_id = $(this).attr('data-payment-id');

    var offset = $(this).attr('data-offset');

    var branch_name = $('#branch_name_'+offset).val();



    payment_amount = parseFloat(payment_amount) + parseFloat(amount);

    payment_id_arr.push(payment_id);

    branch_name_arr.push(branch_name);



  });
  if(payment_id_arr.length==0){

		error_msg_alert('Please select at least one payment to generate receipt!');

		return false;

  } 
  $('input[name="chk_receipt"]:checked').each(function(){

//var id = $(this).attr('id');
 var offset = $(this).attr('data-offset');
var branch_name = $('#branch_name_'+offset).val();

if(branch_name==""){
  error_msg_alert("Please enter branch name for selected payments!");				
  exit(0);
}
});
var base_url = $('#base_url').val();  



url = url = base_url+'view/bank_receipts/group_tour_payment/cheque_payment_receipt.php?payment_id='+payment_id_arr+'&branch_name='+branch_name_arr+'&total_amount='+payment_amount+'&bank_name_reciept='+bank_name_reciept;

            window.open(url, '_blank');  

}
function whatsapp_send_r(booking_id, payment_amount, base_url){
	$.post(base_url+'controller/group_tour/booking_payment/receipt_whatsapp_send.php',{booking_id:booking_id, payment_amount:payment_amount}, function(data){
    window.open(data);
	});
}
</script>

<?= end_panel() ?>

<?php

/*======******Footer******=======*/

require_once('../../layouts/admin_footer.php'); 

?>