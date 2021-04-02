<?php
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$role_id= $_SESSION['role_id'];

$sq_query = mysql_fetch_assoc(mysql_query("select * from hotel_vendor_price_master where pricing_id='$pricing_id'"));
$hotel_id = $sq_query['hotel_id'];
$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$sq_query[hotel_id]'"));
$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$sq_query[city_id]'"));
$sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$sq_query[currency_id]'"));

$sq_countc = mysql_num_rows(mysql_query("select * from hotel_contracted_tarrif where pricing_id='$pricing_id'"));
?>
<form id="frm_tab1">
<input type="hidden" value='<?=$pricing_id ?>' id="pricing_id" name="pricing_id" />
<input type="hidden" value='<?=$sq_countc ?>' id="sq_countc" name="sq_countc" />
<div class="app_panel"> 
    <!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
            <a title="Next">
                <i class="fa fa-arrow-right"></i>
            </a>
            </button>
          </div>
      </div>
    </div> 
    <!--=======Header panel end======-->

        <div class="container">
        <h5 class="booking-section-heading main_block text-center">Hotel Basic Details</h5>
        <div class="app_panel_content Filter-panel">
        <div class="row mg_bt_20">
            <div class="col-md-3 mg_bt_10">
                <select id="cmb_city_id1" name="cmb_city_id1" onchange="hotel_name_list_load(this.id)" class="city_master_dropdown" style="width:100%" title="Select City Name">
                    <option value='<?= $sq_city['city_id'] ?>'><?= $sq_city['city_name'] ?></option>
                </select>
            </div>
            <div class="col-md-3 mg_bt_10">
                <select id="hotel_id1" name="hotel_id1" style="width:100%" title="Select Hotel Name">
                    <option value='<?= $sq_hotel['hotel_id'] ?>'><?= $sq_hotel['hotel_name'] ?></option>
                    <option value="">*Select Hotel</option>
                </select>
            </div>
            <div class="col-md-2 mg_bt_10">
                <select name="currency_code" id="currency_code1" title="Currency" style="width:100%">
                
                <option value='<?= $sq_currency['id'] ?>'><?= $sq_currency['currency_code'] ?></option>
                <?php
                    $sq_currency = mysql_query("select * from currency_name_master order by default_currency desc");
                    while($row_currency = mysql_fetch_assoc($sq_currency)){
                    ?>
                    <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
                <select name="taxation_type1" id="taxation_type1" title="Taxation Type" required>
                <option value="<?= $sq_hotel['taxation_type'] ?>"><?= $sq_hotel['taxation_type'] ?></option>
               
                </select>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
                <select name="taxation_id1" id="taxation_id1" title="Tax" onchange="generic_tax_reflect(this.id, 'service_tax1', 'calculate_total_amount', '1');" required>
                    
                </select>
                <input type="hidden" id="service_tax1" name="service_tax1" value="<?= $sq_hotel['service_tax'] ?>">
            </div> -->
        </div>
        </div>

        <h5 class="booking-section-heading main_block text-center">Hotel Seasonal Tariff</h5>
        <?php if($sq_countc==0){?>
        <div class="row mg_bt_10">
            <div class="col-md-12 text-right text_center_xs">
                <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif1','1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_hotel_tarrif1','1')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table_hotel_tarrif1" name="table_hotel_tarrif" class="table table-bordered table-hover table-striped pd_bt_51 no-marg" style="width: 1400px;">
                        <tr>
                        <td><input class="css-checkbox" id="chk_ticket1" type="checkbox"><label class="css-label" for="chk_ticket"> </label></td>
                        <?php include 'hotel_tarrif_list.php';?>
                    </table>
                </div>
            </div>
        </div>
        <?php }
        else{ ?>
            <div class="row mg_bt_10">
                <div class="col-md-12 text-right text_center_xs">
                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="table_hotel_tarrif" name="table_hotel_tarrif" class="table table-bordered table-hover table-striped pd_bt_51 no-marg" style="width: 1400px;">
                    <?php
                    $count = 1;
                    $sq_tab2 = mysql_query("select * from hotel_contracted_tarrif where pricing_id='$pricing_id'");
                    while($row_tab2 = mysql_fetch_assoc($sq_tab2)){ ?>
                        <tr>
                            <td><input class="css-checkbox" id="chk_ticket<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
                            <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                            <td><select name="room_cat<?= $count ?>-u" id="room_cat<?= $count ?>-u" style="width:145px;" title="Room Category" class="form-control app_select2">
						            <option value='<?= $row_tab2['room_category']?>'><?= $row_tab2['room_category']?></option>
                                    <?php get_room_category_dropdown(); ?>
                                </select></td>
                            <td><input type="text" id="m_occupancy" name="m_occupancy" placeholder="*Max Occupancy" title="Max Occupancy" onchange="validate_balance(this.id)" style="width: 130px;" value='<?= $row_tab2['max_occupancy'] ?>'/></td>           
                            <td><input type="text" id="from_date<?= $count ?>-u" class="form-control" name="from_date<?= $count ?>-u" placeholder="Valid From" title="Valid From" style="width: 120px;" onchange="get_to_date(this.id,'to_date<?= $count ?>-u')" value='<?= get_date_user($row_tab2['from_date']) ?>' /></td>
                            <td><input type="text" id="to_date<?= $count ?>-u" class="form-control" name="to_date<?= $count ?>-u" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date<?= $count ?>-u' ,'to_date<?= $count ?>-u')" value='<?= get_date_user($row_tab2['to_date']) ?>' style="width: 120px;" /></td>
                            <td style='display:none;'><input type="text" id="single_bed" name="single_bed" placeholder="Single Bed" title="Single Bed" onchange="validate_balance(this.id)" /></td>
                            <td><input type="text" id="double_bed" name="double_bed" placeholder="Room Cost" title="Room Cost"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab2['double_bed'] ?>'/></td>
                            <td style='display:none;'><input type="text" id="triple_bed" name="triple_bed" placeholder="Triple Bed" title="Triple Bed"  onchange="validate_balance(this.id)" /></td>
                            <td><input type="text" id="cwbed" name="cwbed" placeholder="Child With Bed" title="Child With Bed"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab2['child_with_bed'] ?>' /></td>
                            <td><input type="text" id="cwobed" name="cwobed" placeholder="Child Without Bed" title="Child Without Bed"  onchange="validate_balance(this.id)" style="width: 137px;" value='<?= $row_tab2['child_without_bed'] ?>' /></td>
                            <td style='display:none;'><input type="text" id="first_child" name="first_child" placeholder="First Child" title="First Child"  onchange="validate_balance(this.id)" /></td>
                            <td style='display:none;'><input type="text" id="second_child" name="second_child" placeholder="Second Child" title="Second Child"  onchange="validate_balance(this.id)" /></td>
                            <td><input type="text" id="with_bed" name="with_bed" placeholder="Extra Bed" title="Extra Bed"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab2['extra_bed'] ?>' /></td>
                            <td style='display:none;'><input type="text" id="queen" name="queen" placeholder="Queen Bed" title="Queen Bed"  onchange="validate_balance(this.id)" /></td>
                            <td style='display:none;'><input type="text" id="king" name="king" placeholder="King Bed" title="King Bed"  onchange="validate_balance(this.id)" /></td>
                            <td style='display:none;'><input type="text" id="quad_bed" name="quad_bed" placeholder="Quad Bed" title="Quad Bed"  onchange="validate_balance(this.id)" /></td>
                            <td style='display:none;'><input type="text" id="twin" name="twin" placeholder="Twin Bed" title="Twin Bed"  onchange="validate_balance(this.id)"/></td>
                            <td><input type="text" id="markup_per" name="markup_per" placeholder="Markup(%)" title="Markup(%)"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab2['markup_per'] ?>' /></td>
                            <td><input type="text" id="flat_markup" name="flat_markup" placeholder="Flat Markup" title="Flat Markup"  onchange="validate_balance(this.id)" style="width: 120px;" value='<?= $row_tab2['markup'] ?>' /></td>
                            <td><select name="meal_plan" id="meal_plan" style="width: 110px" class="form-control app_select2" title="Meal Plan">
                            <?php if($row_tab2['meal_plan'] != ''){?> <option value='<?= $row_tab2['meal_plan'] ?>'><?= $row_tab2['meal_plan']?></option><?php }?>
                            <?php get_mealplan_dropdown(); ?></td>
                            <td><input type="hidden" id="entry_id" name="entry_id" value='<?= $row_tab2['entry_id'] ?>' /></td>
                        </tr>
                        <script>
                        $('#to_date<?= $count ?>-u,#from_date<?= $count ?>-u').datetimepicker({ timepicker:false, format:'d-m-Y' });
                        $('#room_cat<?= $count ?>-u').select2();
                        </script>
                    <?php $count++; } ?>
                    </table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row text-center mg_tp_20 mg_bt_150">
            <div class="col-xs-12">
                <button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
            </div>
        </div>
</form>
<?= end_panel() ?>

<script>
$('#currency_code1,#cmb_hotel_id').select2();
$('#cmb_city_id1').select2({minimumInputLength: 1});
city_lzloading('#cmb_city_id1');
//**Hotel Name load start**//
function hotel_name_list_load(id){
  var city_id = $("#"+id).val();
  var base_url = $('#base_url').val();
  $.get( base_url+"view/hotels/master/b2b_tarrif/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_id1").html( data );
  });
}
$('#frm_tab1').validate({
	rules:{
		cmb_city_id1 : { required : true },
		hotel_id1 : { required : true },
	},
	submitHandler:function(form){
    var sq_countc = $('#sq_countc').val();
    var table_id = (sq_countc==0)?'table_hotel_tarrif1':'table_hotel_tarrif';
    var table = document.getElementById(table_id);
    var rowCount = table.rows.length;

    for(var i=0; i<rowCount; i++){
        var row = table.rows[i];           

        if(row.cells[0].childNodes[0].checked){
            var room_cat = row.cells[2].childNodes[0].value;
            var max_ooc = row.cells[3].childNodes[0].value;
            var from_date = row.cells[4].childNodes[0].value;
            var to_date = row.cells[5].childNodes[0].value;
            if(room_cat==''){
                error_msg_alert('Select Room Category in Row-'+(i+1));
                return false;
            }
            if(max_ooc==''){
                error_msg_alert('Enter Max occupancy in Row-'+(i+1));
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
        }
    }
    
	$('#tab1_head').addClass('done');
	$('#tab2_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab2').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
});
</script>

