<?php
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$branch_status = $_POST['branch_status'];
$sq_booking = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));
$reflections = json_decode($sq_booking['reflections']);
?>
<form id="frm_hotel_booking_update">

<div class="modal fade" id="booking_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 70%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Hotel Booking</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="booking_id" name="booking_id" value="<?= $booking_id ?>">
        <input type="hidden" id="hotel_sc" name="hotel_sc" value="<?php echo $reflections[0]->hotel_sc ?>">
        <input type="hidden" id="hotel_markup" name="hotel_markup" value="<?php echo $reflections[0]->hotel_markup ?>">
        <input type="hidden" id="hotel_taxes" name="hotel_taxes" value="<?php echo $reflections[0]->hotel_taxes ?>">
        <input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes" value="<?php echo $reflections[0]->hotel_markup_taxes ?>">
        <input type="hidden" id="hotel_tds" name="hotel_tds" value="<?php echo $reflections[0]->hotel_tds ?>">

        <div class="panel panel-default panel-body app_panel_style feildset-panel">
          <legend>Personal Information</legend>
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <select name="customer_id1" id="customer_id1" style="width: 100%" onchange="customer_info_load('1')" disabled>
                  <?php 
                  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
                  if($sq_customer['type']=='Corporate'){
                  ?>
                    <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
                  <?php }  else{ ?>
                    <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                  <?php } ?>
                  <?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
                  </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                    <input type="text" id="email_id1" name="email_id1" title="Email Id" placeholder="Email ID" title="Email ID" readonly>
                  </div>    
              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="mobile_no1" name="mobile_no1" title="Mobile Number" placeholder="Mobile No" title="Mobile No" readonly>
              </div>   
              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <input type="text" id="company_name1" class="hidden" name="company_name1" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
              </div>
            </div>          
              <script>
                customer_info_load('1');
              </script>
            <div class="row">
              <div class="col-sm-3 col-xs-12 mg_bt_10_sm_xs">
                <input type="text" id="pass_name1" name="pass_name1" placeholder="Passenger Name" title="Passenger Name" value="<?= $sq_booking['pass_name'] ?>">
              </div>
              <div class="col-sm-3 col-xs-12 mg_bt_10_sm_xs">
                <input type="text" id="adults1" name="adults1" placeholder="Adults" title="Adults" value="<?= $sq_booking['adults'] ?>" onchange="get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','true','discount1',true);validate_balance(this.id)">
              </div>
              <div class="col-sm-3 col-xs-12 mg_bt_10_sm_xs">
                <input type="text" id="childrens1" name="childrens1" placeholder="Childrens" title="Childrens" value="<?= $sq_booking['childrens'] ?>" onchange="get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','true','discount1',true);validate_balance(this.id)">
              </div>
              <div class="col-sm-3 col-xs-12 mg_bt_10_sm_xs">
                <input type="text" id="infants1" name="infants1" placeholder="Infants" title="Infants" value="<?= $sq_booking['infants'] ?>" onchange="validate_balance(this.id)">
              </div>
            </div>              
        </div>
        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
        <legend>Room Details</legend>

        <div class="row text-right mg_bt_10">
            <div class="col-xs-12">
                <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_hotel_booking_update')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            </div>
        </div>

        <div class="row"> <div class="col-xs-12"> <div class="table-responsive" id="hotel_booking_wrap">
          <?php $prefix = "_u"; ?>
          <table id="tbl_hotel_booking_update" class="table table-bordered table-hover table-striped no-marg pd_bt_51" style="width: 1685px;">              
              <?php 
              $sq_entry_count = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$booking_id'"));
              if($sq_entry_count==0){
                include_once('hotel_booking_dynamic_tbl.php');
              }
              else{
                $count = 0;
                $sq_entry = mysql_query("select * from hotel_booking_entries where booking_id='$booking_id'");
                while($row_entry = mysql_fetch_assoc($sq_entry)){
                  $bg = ($row_entry['status']=="Cancel") ? "danger" : "";
                  $count++;
                  ?>
                  <tr class="<?= $bg ?>">
                      <td ><input id="chk_hotel_<?= $prefix.$count ?>_f" type="checkbox" checked disabled></td>
                      <td><input maxlength="15" type="text" name="username"  value="<?= $count ?>" placeholder="Sr. No." disabled/></td>
                      <td style="width:150px"><select id="city_id<?= $prefix.$count ?>_f" class="city_id_u" name="city_id<?= $prefix.$count ?>_f" title="City" onchange="hotel_name_list_load(this.id)" class="app_select2" style="width:100%">
                              <?php
                              $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));
                              ?>
                              <option value="<?php echo $sq_city['city_id'] ?>"><?php echo $sq_city['city_name'] ?></option>
                          </select>
                      </td>    
                      <td style="width:150px"><select id="hotel_id<?= $prefix.$count ?>_f" name="hotel_id<?= $prefix.$count ?>_f" title="Hotel" onchange="get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','true','service_charge','discount1',true);">
                              <?php 
                              $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_id, hotel_name from hotel_master where hotel_id='$row_entry[hotel_id]'"));
                              ?>
                              <option value="<?php echo $sq_hotel['hotel_id'] ?>"><?php echo $sq_hotel['hotel_name'] ?></option>
                          </select>
                      </td>    
                      <td><input type="text" class="app_datetimepicker" id="check_in<?= $prefix.$count ?>_f" name="check_in<?= $prefix.$count ?>_f" placeholder="Check-In Date Time" title="Check-In Date Time" onchange="get_to_datetime(this.id,'check_out<?= $prefix.$count ?>_f')" value="<?= date('d-m-Y H:i:s', strtotime($row_entry['check_in'])) ?>"></td>
                      <td><input type="text" class="app_datetimepicker" id="check_out<?= $prefix.$count ?>_f" name="check_out<?= $prefix.$count ?>_f"  placeholder="Check-Out Date Time" title="Check-Out Date Time" value="<?= date('d-m-Y H:i:s', strtotime($row_entry['check_out'])) ?>"></td>
                      <td><input type="text" id="no_of_nights<?= $prefix ?>_f" name="no_of_nights<?= $prefix ?>_f" placeholder="*No Of Nights" title="No Of Nights" onchange="validate_balance(this.id)" value="<?= $row_entry['no_of_nights'] ?>"></td>
                      <td><input type="text" id="rooms<?= $prefix.$count ?>_f" name="rooms<?= $prefix.$count ?>_f" placeholder="*Rooms" title="Rooms" onchange="validate_balance(this.id)" value="<?= $row_entry['rooms'] ?>"></td>
                      <td><select name="room_type<?= $prefix.$count ?>_f" id="room_type<?= $prefix.$count ?>_f" title="Room Type">
                            <?php if($row_entry['room_type']!=''){ ?>
                              <option value="<?= $row_entry['room_type'] ?>"><?= $row_entry['room_type'] ?></option>
                              <option value="">Room Type</option>
                              <option value="AC">AC</option>
                              <option value="Non AC">Non AC</option>
                            <?php }else{ ?>
                            <option value="">Room Type</option>
                              <option value="AC">AC</option>
                              <option value="Non AC">Non AC</option>
                            <?php } ?>
                      </select></td>
                      <td><select name="category<?= $prefix.$count ?>_f" id="category<?= $prefix.$count ?>_f" title="Category">
                        <?php if($row_entry['category']!=''){ ?>
                              <option value="<?= $row_entry['category'] ?>"><?= $row_entry['category'] ?></option>
                              <?php }?>
                              <?php echo get_room_category_dropdown(); ?>
                      </select></td>
                      <td><select name="accomodation_type<?= $prefix.$count ?>_f" id="accomodation_type<?= $prefix.$count ?>_f" title="Accommodation Type">
                        <?php  if($row_entry['accomodation_type']!=''){ ?>
                              <option value="<?= $row_entry['accomodation_type'] ?>"><?= $row_entry['accomodation_type'] ?></option>
                              <option value="">Accommodation Type</option>
                              <option value="Twin Sharing">Twin Sharing</option>
                              <option value="Single Adult">Single Adult</option>
                              <option value="Triple Sharing">Triple Sharing</option>
                              <option value="Quadruple Sharing">Quadruple Sharing</option>
                            <?php }else{?>
                              <option value="">Accommodation Type</option>
                              <option value="Twin Sharing">Twin Sharing</option>
                              <option value="Single Adult">Single Adult</option>
                              <option value="Triple Sharing">Triple Sharing</option>
                              <option value="Quadruple Sharing">Quadruple Sharing</option>
                            <?php } ?>
                      </select></td>
                      <td><input type="text" id="extra_beds<?= $prefix.$count ?>_f" name="extra_beds<?= $prefix.$count ?>_f" placeholder="Extra Beds" title="Extra Beds" onchange="number_validate(this.id)" value="<?= $row_entry['extra_beds'] ?>"></td>
                      <td><select title="Meal Plan" id="meal_plan<?= $prefix.$count ?>_f" name="meal_plan<?= $prefix.$count ?>_f" title="Meal Plan" Placeholder="Meal Plan">
                      <?php if($row_entry['meal_plan']!=""){?>
                              <option value="<?= $row_entry['meal_plan'] ?>"><?= $row_entry['meal_plan'] ?></option>
                              <?php get_mealplan_dropdown(); ?>
                      <?php } else { ?>
                      <option value="">Meal Plan</option>
                              <option value="EP">EP</option> 
                              <option value="AP">AP</option>
                              <option value="CP">CP</option>
                              <option value="MAP">MAP</option>
                              <option value="NA">NA</option>
                              <?php } ?>
                      </select></td>
                      <td><input type="text" id="conf_no<?= $prefix.$count ?>_f" name="conf_no<?= $prefix.$count ?>_f" placeholder="Confirmation No." title="Confirmation No." value="<?= $row_entry['conf_no'] ?>"></td>
                      <td class="hidden"><input type="text" value="<?= $row_entry['entry_id'] ?>"></td>
                  </tr>
                  <?php
                }
              }
              ?>
          </table> 

        </div></div></div>
      </div>
      <?php
        $sub_total = $sq_booking['sub_total'];
        $service_charge = $sq_booking['service_charge'];
        $markup = $sq_booking['markup'];
        $discount = $sq_booking['discount'];

        $bsmValues = json_decode($sq_booking['bsm_values']);
        $service_tax_amount = 0;
        if($sq_booking['service_tax_subtotal'] !== 0.00 && ($sq_booking['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$sq_booking['service_tax_subtotal']);
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
        $service_tax = explode(':',$service_tax_subtotal1[$i]);
        $service_tax_amount = $service_tax_amount + $service_tax[2];
        }
        }
        $markupservice_tax_amount = 0;
        if($sq_booking['markup_tax'] !== 0.00 && $sq_booking['markup_tax'] !== ""){
        $service_tax_markup1 = explode(',',$sq_booking['markup_tax']);
        for($i=0;$i<sizeof($service_tax_markup1);$i++){
        $service_tax = explode(':',$service_tax_markup1[$i]);
        $markupservice_tax_amount = $markupservice_tax_amount+ $service_tax[2];
        }
        }
        foreach($bsmValues[0] as $key => $value){
        switch($key){
        case 'basic' : $sub_total = ($value != "") ? $sub_total + $service_tax_amount : $sub_total;$inclusive_b = $value;break;
        case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;break;
        case 'markup' : $markup = ($value != "") ? $markup + $markupservice_tax_amount : $markup;$inclusive_m = $value;break;
        case 'discount' : $discount = ($value != "") ? $discount + $sq_booking['tds'] : $discount;$inclusive_d = $value;break;
        }
        }
        $readonly = ($inclusive_d != '') ? 'readonly' : '';
        // echo "<pre>";
        // var_dump($bsmValues)
        ?>
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
          <legend>Costing Details</legend>
          <div class="row mg_tp_20">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <small id="basic_show1" style="color:red"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
              <input type="text" id="sub_total1" name="sub_total1" placeholder="Amount" title="Amount" onchange="get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','true','service_charge','discount1',true);total_fun1();validate_balance(this.id)" value="<?= $sub_total ?>">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <small id="service_show1" style="color:red"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
              <input type="text" id="service_charge1" name="service_charge1" placeholder="Service Charge" title="Service Charge" onchange="total_fun1();validate_balance(this.id);get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','false','service_charge','discount1');" value="<?= $service_charge ?>">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <small>&nbsp;</small>
                <input type="text" id="service_tax_subtotal1" name="service_tax_subtotal1" placeholder="Tax Amount" title="Tax Amount" readonly value="<?= $sq_booking['service_tax_subtotal'] ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <small id="markup_show1" style="color:red"><?= ($inclusive_m == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_m ?></span></small>
              <input type="text" id="markup1" name="markup1" placeholder="Markup " title="Markup" onchange="total_fun1();get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','false','markup','discount1');validate_balance(this.id)" value="<?= $markup ?>">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <small>&nbsp;</small>
                <input type="text" id="service_tax_markup1" name="service_tax_markup1" placeholder="Tax on Markup" title="Tax on Markup" value="<?= $sq_booking['markup_tax'] ?>" readonly>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <small id="discount_show1" style="color:red"><?= ($inclusive_d == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_d ?></span></small>
              <input type="text" id="discount1" name="discount1" placeholder="Discount" title="Discount" onchange="total_fun1();get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','true','discount','discount1',true);validate_balance(this.id)" value="<?= $sq_booking['discount'] ?>">
            </div>
          </div>
          <div class="row">           
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" id="tds1" name="tds1" placeholder="TDS" title="TDS" onchange="total_fun1();validate_balance(this.id)" value="<?= $sq_booking['tds'] ?> " <?= $readonly ?>>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="roundoff1" id="roundoff1" class="text-right" placeholder="Round Off" title="RoundOff" value="<?= $sq_booking['roundoff'] ?> " readonly>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="total_fee1" id="total_fee1" class="amount_feild_highlight text-right" placeholder="Net Total" title="Net Total" value="<?= $sq_booking['total_fee'] ?>" readonly>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <input type="text" name="due_date1" id="due_date1" placeholder="Due Date" title="Due Date" value="<?= get_date_user($sq_booking['due_date']) ?>">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
              <input type="text" name="booking_date1" id="booking_date1" placeholder="Booking Date" value="<?= get_date_user($sq_booking['created_at']) ?>" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('booking_date1','sub_total1','payment_mode','service_charge1','markup1','update','true','service_charge','discount1',true);">
            </div>
          </div>
        </div>
        <div class="row text-center mg_tp_20 mg_bt_20">
            <div class="col-xs-12">
              <button class="btn btn-sm btn-success" id="update_btn"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
        </div> 
      </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#booking_update_modal').modal('show');
$('#city_id_u1, #city_id_u1_f, #customer_id1').select2();
$('#booking_date1,#due_date1,#booking_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#check_in_u1, #check_out_u1, #check_in_u1_f, #check_out_u1_f').datetimepicker({ format:'d-m-Y H:i:s' });
city_lzloading(".city_id_u");
function customer_details_update()
{
  var customer_id = $('#customer_id1').val();
  var base_url = $('#base_url').val();
  $.post(base_url+'view/visa_passport_ticket/train_ticket/home/customer_details_update.php',{customer_id : customer_id},function(data){
    $('#customer_details_update_div').html(data);
  });
}

function total_fun1()
{
  var service_tax = $('#service_tax1').val();
  var service_tax_subtotal = $('#service_tax_subtotal1').val();   
  var sub_total = $('#sub_total1').val();
  var service_charge = $('#service_charge1').val();
  var markup = $('#markup1').val();
  var service_tax_markup = $('#service_tax_markup1').val();
  var discount = $('#discount1').val();
  var tds = $('#tds1').val();

  if(sub_total==""){ sub_total = 0; }
  if(service_tax_subtotal==""){ service_tax_subtotal = 0; }
  if(service_charge==""){ service_charge = 0; }
  if(markup==""){ markup = 0; }
  if(discount==""){ discount = 0; }
  if(tds==""){ tds = 0; }

  if(parseFloat(discount) > (parseFloat(service_charge)+parseFloat(markup))){
      error_msg_alert("Discount can't be greater than service charge + markup !");
      return false;
    }
  var service_tax_amount = 0;
  if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== ''){

    var service_tax_subtotal1 = service_tax_subtotal.split(",");
    for(var i=0;i<service_tax_subtotal1.length;i++){
      var service_tax = service_tax_subtotal1[i].split(':');
      service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
    }
  }
  
  var markupservice_tax_amount = 0;
  if(parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== ""){
    var service_tax_markup1 = service_tax_markup.split(",");
    for(var i=0;i<service_tax_markup1.length;i++){
      var service_tax = service_tax_markup1[i].split(':');
      markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
    }
  }


  sub_total = ($('#basic_show1').html() == '&nbsp;') ? sub_total : parseFloat($('#basic_show1').text().split(' : ')[1]);
    service_charge = ($('#service_show1').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show1').text().split(' : ')[1]);
    markup = ($('#markup_show1').html() == '&nbsp;') ? markup : parseFloat($('#markup_show1').text().split(' : ')[1]);
    discount =($('#discount_show1').html() == '&nbsp;') ? discount : parseFloat($('#discount_show1').text().split(' : ')[1]); 
   
  var total_amount = parseFloat(sub_total) + parseFloat(service_tax_amount) + parseFloat(markupservice_tax_amount) + parseFloat(service_charge) + parseFloat(markup) + parseFloat(tds) - parseFloat(discount);


  

  var total=total_amount.toFixed(2);
  var roundoff = Math.round(total)-total;
  $('#roundoff1').val(roundoff.toFixed(2));
  $('#total_fee1').val(parseFloat(total)+parseFloat(roundoff));  
}

$(function(){
  $('#frm_hotel_booking_update').validate({
    rules:{
        customer_id1:{ required : true },
        sub_total1:{ required : true, number: true },
        service_charge1 :{ required : true, number:true },
        total_fee1 :{ required : true, number:true },
        booking_date1:{ required : true },
    },
    submitHandler:function(form){

      var booking_id = $('#booking_id').val();
      var customer_id = $('#customer_id1').val();
      var pass_name = $('#pass_name1').val();
      var adults = $('#adults1').val();
      var childrens = $('#childrens1').val();
      var infants = $('#infants1').val();  
      var sub_total = $('#sub_total1').val();  
      var service_charge = $('#service_charge1').val();
      var service_tax_subtotal = $('#service_tax_subtotal1').val();
      var discount = $('#discount1').val();
      var markup = $('#markup1').val();
      var service_tax_markup = $('#service_tax_markup1').val();
      var tds = $('#tds1').val();        
      var total_fee = $('#total_fee1').val();
      var roundoff = $('#roundoff1').val();
      var due_date1 = $('#due_date1').val();
      var booking_date1 = $('#booking_date1').val();
      
      var city_id_arr = new Array();
      var hotel_id_arr = new Array();
      var check_in_arr = new Array();
      var check_out_arr = new Array();
      var no_of_nights_arr = new Array();
      var rooms_arr = new Array();
      var room_type_arr = new Array();
      var category_arr = new Array();
      var accomodation_type_arr = new Array();
      var extra_beds_arr = new Array();
      var meal_plan_arr = new Array();
      var conf_no_arr = new Array();
      var entry_id_arr = new Array();

      var table = document.getElementById("tbl_hotel_booking_update");
      var rowCount = table.rows.length;        
      for(var i=0; i<rowCount; i++){

        var row = table.rows[i];
        if(row.cells[0].childNodes[0].checked){

            var city_id = row.cells[2].childNodes[0].value;
            var hotel_id = row.cells[3].childNodes[0].value;
            var check_in = row.cells[4].childNodes[0].value;
            var check_out = row.cells[5].childNodes[0].value;
            var no_of_nights = row.cells[6].childNodes[0].value;
            var rooms = row.cells[7].childNodes[0].value;
            var room_type = row.cells[8].childNodes[0].value;
            var category = row.cells[9].childNodes[0].value;
            var accomodation_type = row.cells[10].childNodes[0].value;
            var extra_beds = row.cells[11].childNodes[0].value;
            var meal_plan = row.cells[12].childNodes[0].value;
            var conf_no = row.cells[13].childNodes[0].value;
            
            if(row.cells[14]){
              var entry_id = row.cells[14].childNodes[0].value;  
            }
            else{
              var entry_id = "";
            }
            
            var msg = "";
            if(city_id==""){ msg +="City is required in row:"+(i+1)+'<br>';  }
            if(hotel_id==""){ msg +="Hotel is required in row:"+(i+1)+'<br>';  }
            if(check_in==""){ msg +="Check-In is required in row:"+(i+1)+'<br>';  }
            if(check_out==""){ msg +="Check-Out is required in row:"+(i+1)+'<br>';  }
            if(extra_beds==""){ msg +="Extra beds is required in row:"+(i+1)+'<br>';  }
            if(rooms==""){ msg +="Rooms is required in row:"+(i+1)+'<br>';  }
            if(no_of_nights==""){ msg +="No of Nights is required in row:"+(i+1)+'<br>';  }

            if(msg!=""){
              error_msg_alert(msg);
              return false;
            }

            city_id_arr.push(city_id);
            hotel_id_arr.push(hotel_id);
            check_in_arr.push(check_in);
            check_out_arr.push(check_out);
            no_of_nights_arr.push(no_of_nights);
            rooms_arr.push(rooms);
            room_type_arr.push(room_type);
            category_arr.push(category);
            accomodation_type_arr.push(accomodation_type);
            extra_beds_arr.push(extra_beds);
            meal_plan_arr.push(meal_plan);
            conf_no_arr.push(conf_no);
            entry_id_arr.push(entry_id);
        }      
      }

      var hotel_sc = $('#hotel_sc').val();
      var hotel_markup = $('#hotel_markup').val();
      var hotel_taxes = $('#hotel_taxes').val();
      var hotel_markup_taxes = $('#hotel_markup_taxes').val();
      var hotel_tds = $('#hotel_tds').val();
      var reflections = [];
      reflections.push({
        'hotel_sc':hotel_sc,
        'hotel_markup':hotel_markup,
        'hotel_taxes':hotel_taxes,
        'hotel_markup_taxes':hotel_markup_taxes,
        'hotel_tds':hotel_tds
      });
      var bsmValues = [];
          bsmValues.push({
          "basic" : $('#basic_show1').find('span').text(),
          "service" : $('#service_show1').find('span').text(),
          "markup" : $('#markup_show1').find('span').text(),
          "discount" : $('#discount_show1').find('span').text()
          });
      var base_url = $('#base_url').val();
			//Validation for booking and payment date in login financial year
			var check_date1 = $('#booking_date1').val();
			$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
				if(data !== 'valid'){
					error_msg_alert("The Booking date does not match between selected Financial year.");
					return false;
				}else{
            $('#update_btn').button('loading');
          
            $.ajax({
              type: 'post',
              url: base_url+'controller/hotel/booking/booking_update.php',
              data:{ booking_id : booking_id, customer_id : customer_id,pass_name : pass_name, adults : adults, childrens : childrens, infants : infants, sub_total : sub_total, service_charge : service_charge, service_tax_subtotal : service_tax_subtotal,markup:markup, discount : discount, tds : tds, total_fee : total_fee, city_id_arr : city_id_arr, hotel_id_arr : hotel_id_arr, check_in_arr : check_in_arr, check_out_arr : check_out_arr, no_of_nights_arr : no_of_nights_arr, rooms_arr : rooms_arr, room_type_arr : room_type_arr, category_arr : category_arr, accomodation_type_arr : accomodation_type_arr, extra_beds_arr : extra_beds_arr, meal_plan_arr : meal_plan_arr, conf_no_arr : conf_no_arr, entry_id_arr : entry_id_arr, due_date1 : due_date1, booking_date1 : booking_date1,reflections:reflections,service_tax_markup:service_tax_markup,bsmValues:bsmValues,roundoff:roundoff },
              success: function(result){
                  msg_popup_reload(result);  
                  $('#update_btn').button('reset');
                    
              }
            });
          }
        });
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>