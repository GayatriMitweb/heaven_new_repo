<form id="frm_tab5">
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
        <h5 class="booking-section-heading main_block text-center">Offers/Coupon</h5>
            <div class="row text-right mg_bt_10">
                <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif_offer')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_hotel_tarrif_offer')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table_hotel_tarrif_offer" name="table_hotel_tarrif_offer" class="table table-bordered no-marg pd_bt_51" style="width:100%">
                    <tr>
                        <td><input class="css-checkbox" id="chk_offer" type="checkbox"><label class="css-label" for="chk_offer"> </label></td>
                        <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                        <td><select name="offer_type" id="offer_type" style="width: 150px" class="form-control app_select2">
                            <option value=''>Select Type</option>
                            <option value='Offer'>Offer</option>
                            <option value='Coupon'>Coupon</option></td>
                        <td><input type="text" id="from_date_h" class="form-control" name="from_date_h" placeholder="Valid From" title="Valid From" onchange="get_to_date(this.id,'to_date_h')" value="<?= date('d-m-Y') ?>" style="width: 130px;" /></td>
                        <td><input type="text" id="to_date_h" class="form-control" name="to_date_h" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date_h' ,'to_date_h')" value="<?= date('d-m-Y') ?>" style="width: 130px;" /></td>
                        <td><select name="amount_in" id="amount_in" style="width: 150px" class="form-control app_select2">
                            <option value=''>Amount In</option>
                            <option value='Flat'>Flat</option>
                            <option value='Percentage'>Percentage</option></select></td>
                        <td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 150px;"/></td>
                        <td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;"/></td>
                        <td><select name="agent_type" id="agent_type" title="Agent Type" style="width: 150px" class="form-control app_select2" multiple>
                            <option value=''>Agent Type</option>
                            <option value='Platinum'>Platinum</option>
                            <option value='Gold'>Gold</option>
                            <option value='Silver'>Silver</option></select></td>
                        <td><input type="hidden" id="entry_id" name="entry_id" /></td>                  
                    </table>
                </div>
            </div>
            </div>	

            <div class="row text-center mg_tp_20 mg_bt_150">
                <div class="col-xs-12">
                    <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab4()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-success" id="btn_price_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                </div>
            </div>
        </div>

</form>
<?= end_panel() ?>

<script>
$('#agent_type').select2();
$('#to_date_h,#from_date_h').datetimepicker({ timepicker:false, format:'d-m-Y' });

function switch_to_tab4(){ 
	$('#tab4_head').removeClass('active');
	$('#tab3_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab3').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
 }

$('#frm_tab5').validate({
	rules:{

	},
	submitHandler:function(form){
        var base_url = $('#base_url').val();
        //TAB-1
        var city_id = $('#cmb_city_id1').val();
        var hotel_id = $('#hotel_id1').val();
        var currency_id = $('#currency_code1').val();
        var taxation_type = $('#taxation_type').val();
        var taxation_id ='';
        var service_tax = $('#service_tax').val();
        
        //TAB-2
        var tab2_room_cat_array = new Array();
        var tab2_max_occ_array = new Array();
        var tab2_from_date_array = new Array();
        var tab2_to_date_array = new Array();
        var tab2_double_bed_array = new Array();
        var tab2_chwithbed_array = new Array();
        var tab2_chwobed_array = new Array();
        var tab2_extra_bed_array = new Array();
        var tab2_markup_per_array = new Array();
        var tab2_markup_cost_array = new Array();
        var tab2_meal_plan_array = new Array();
        var table = document.getElementById("table_hotel_tarrif1");
	    	var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){

			  var room_cat = row.cells[2].childNodes[0].value;
			  var max_occu = row.cells[3].childNodes[0].value;
			  var from_date = row.cells[4].childNodes[0].value;
			  var to_date = row.cells[5].childNodes[0].value;
			  var double_bed = row.cells[7].childNodes[0].value;
			  var chwithbed = row.cells[9].childNodes[0].value;
			  var chwobed = row.cells[10].childNodes[0].value;
			  var extra_bed = row.cells[13].childNodes[0].value;
			  var markup_per = row.cells[18].childNodes[0].value;
			  var markup_cost = row.cells[19].childNodes[0].value;
        var meal_plan = row.cells[20].childNodes[0].value;

              tab2_room_cat_array.push(room_cat);
              tab2_max_occ_array.push(max_occu);
              tab2_from_date_array.push(from_date);
              tab2_to_date_array.push(to_date);
              tab2_double_bed_array.push(double_bed);
              tab2_chwithbed_array.push(chwithbed);
              tab2_chwobed_array.push(chwobed);
              tab2_extra_bed_array.push(extra_bed);
              tab2_markup_per_array.push(markup_per);
              tab2_markup_cost_array.push(markup_cost);
              tab2_meal_plan_array.push(meal_plan);
          }
        }

        //TAB-3
        var tab3_room_cat_array = new Array();
        var tab3_max_occ_array = new Array();
        var tab3_from_date_array = new Array();
        var tab3_to_date_array = new Array();
        var tab3_double_bed_array = new Array();
        var tab3_chwithbed_array = new Array();
        var tab3_chwobed_array = new Array();
        var tab3_extra_bed_array = new Array();
        var tab3_markup_per_array = new Array();
        var tab3_markup_cost_array = new Array();
        var tab3_meal_plan_array = new Array();
        var table = document.getElementById("table_hotel_tarrif3");
	    	var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){

			  var room_cat = row.cells[2].childNodes[0].value;
			  var max_occu = row.cells[3].childNodes[0].value;
			  var from_date = row.cells[4].childNodes[0].value;
			  var to_date = row.cells[5].childNodes[0].value;
			  var double_bed = row.cells[7].childNodes[0].value;
			  var chwithbed = row.cells[9].childNodes[0].value;
			  var chwobed = row.cells[10].childNodes[0].value;
			  var extra_bed = row.cells[13].childNodes[0].value;
			  var markup_per = row.cells[18].childNodes[0].value;
			  var markup_cost = row.cells[19].childNodes[0].value;
              var meal_plan = row.cells[20].childNodes[0].value;

              tab3_room_cat_array.push(room_cat);
              tab3_max_occ_array.push(max_occu);
              tab3_from_date_array.push(from_date);
              tab3_to_date_array.push(to_date);
              tab3_double_bed_array.push(double_bed);
              tab3_chwithbed_array.push(chwithbed);
              tab3_chwobed_array.push(chwobed);
              tab3_extra_bed_array.push(extra_bed);
              tab3_markup_per_array.push(markup_per);
              tab3_markup_cost_array.push(markup_cost);
              tab3_meal_plan_array.push(meal_plan);
          }
        }

        //TAB-4
        var tab4_room_cat_array = new Array();
        var tab4_max_occ_array = new Array();
        var tab4_day_array = new Array();
        var tab4_double_bed_array = new Array();
        var tab4_chwithbed_array = new Array();
        var tab4_chwobed_array = new Array();
        var tab4_extra_bed_array = new Array();
        var tab4_markup_per_array = new Array();
        var tab4_markup_cost_array = new Array();
        var tab4_meal_plan_array = new Array();
        var table = document.getElementById("table_hotel_weekend_tarrif");
		    var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){

			  var room_cat = row.cells[2].childNodes[0].value;
			  var max_occu = row.cells[3].childNodes[0].value;
			  var day = row.cells[4].childNodes[0].value;
			  var double_bed = row.cells[6].childNodes[0].value;
			  var chwithbed = row.cells[8].childNodes[0].value;
			  var chwobed = row.cells[9].childNodes[0].value;
			  var extra_bed = row.cells[12].childNodes[0].value;
			  var markup_per = row.cells[17].childNodes[0].value;
			  var markup_cost = row.cells[18].childNodes[0].value;
        var meal_plan = row.cells[19].childNodes[0].value;

              tab4_room_cat_array.push(room_cat);
              tab4_max_occ_array.push(max_occu);
              tab4_day_array.push(day);
              tab4_double_bed_array.push(double_bed);
              tab4_chwithbed_array.push(chwithbed);
              tab4_chwobed_array.push(chwobed);
              tab4_extra_bed_array.push(extra_bed);
              tab4_markup_per_array.push(markup_per);
              tab4_markup_cost_array.push(markup_cost);
              tab4_meal_plan_array.push(meal_plan);
          }
        }
        
        //TAB-5
        var type_array = new Array();
        var from_date_array = new Array();
        var to_date_array = new Array();
        var offer_array = new Array();
        var agent_array = new Array();
        var coupon_code_array = new Array();
        var offer_amount_array = new Array();

        var table = document.getElementById("table_hotel_tarrif_offer");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
                var type = row.cells[2].childNodes[0].value;
                var from_date = row.cells[3].childNodes[0].value;
                var to_date = row.cells[4].childNodes[0].value;
                var offer_in = row.cells[5].childNodes[0].value;
                var coupon_code = row.cells[6].childNodes[0].value;
                var offer_amount = row.cells[7].childNodes[0].value;
                if(type==''){
                  error_msg_alert('Select Type in Row-'+(i+1));
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
                if(offer_in==''){
                  error_msg_alert('Select Amount-in in Row-'+(i+1));
                  return false;
                }
                if(type == 'Coupon'){
                  if(coupon_code==''){
                    error_msg_alert('Enter Coupon code in Row-'+(i+1));
                    return false;
                  }
                }
                if(offer_amount==''){
                  error_msg_alert('Select Offer Amount in Row-'+(i+1));
                  return false;
                }
                var agent_type = "";
                $(row.cells[8]).find('option:selected').each(function(){ agent_type += $(this).attr('value')+','; });
                agent_type = agent_type.trimChars(",");
                
              type_array.push(type);
              from_date_array.push(from_date);
              to_date_array.push(to_date);
              offer_array.push(offer_in);
              coupon_code_array.push(coupon_code);
              offer_amount_array.push(offer_amount);
              agent_array.push(agent_type);
          }
        }

      $('#btn_price_save').button('loading');
	  	$.ajax({
			type:'post',
			url: base_url+'controller/vendor/hotel_pricing/b2b_hotel_tarrif_save.php',
			data:{  city_id : city_id,hotel_id : hotel_id,currency_id:currency_id,taxation_type:taxation_type,taxation_id:taxation_id,   
              service_tax : service_tax,
              tab2_room_cat_array:tab2_room_cat_array,tab2_max_occ_array:tab2_max_occ_array,tab2_from_date_array:tab2_from_date_array,tab2_to_date_array:tab2_to_date_array,tab2_double_bed_array:tab2_double_bed_array,tab2_chwithbed_array:tab2_chwithbed_array,tab2_chwobed_array:tab2_chwobed_array,tab2_extra_bed_array:tab2_extra_bed_array,tab2_markup_per_array:tab2_markup_per_array,tab2_markup_cost_array:tab2_markup_cost_array,tab2_meal_plan_array:tab2_meal_plan_array,
              tab3_room_cat_array:tab3_room_cat_array,tab3_max_occ_array:tab3_max_occ_array,tab3_from_date_array:tab3_from_date_array,tab3_to_date_array:tab3_to_date_array,tab3_double_bed_array:tab3_double_bed_array,tab3_chwithbed_array:tab3_chwithbed_array,tab3_chwobed_array:tab3_chwobed_array,tab3_extra_bed_array:tab3_extra_bed_array,tab3_markup_per_array:tab3_markup_per_array,tab3_markup_cost_array:tab3_markup_cost_array,tab3_meal_plan_array:tab3_meal_plan_array,
              tab4_room_cat_array:tab4_room_cat_array,tab4_max_occ_array:tab4_max_occ_array,tab4_day_array:tab4_day_array,tab4_double_bed_array:tab4_double_bed_array,tab4_chwithbed_array:tab4_chwithbed_array,tab4_chwobed_array:tab4_chwobed_array,tab4_extra_bed_array:tab4_extra_bed_array,tab4_markup_per_array:tab4_markup_per_array,tab4_markup_cost_array:tab4_markup_cost_array,tab4_meal_plan_array:tab4_meal_plan_array,
              type_array:type_array,from_date_array:from_date_array,to_date_array:to_date_array,offer_array:offer_array,coupon_code_array:coupon_code_array,offer_amount_array:offer_amount_array,agent_array:agent_array},
			success:function(result){
          $('#btn_price_save').button('reset');
          var msg = result.split('--');
          if(msg[0]=="error"){
              error_msg_alert(msg[1]);
          }
          else{
            $('#vi_confirm_box').vi_confirm_box({
                false_btn: false,
                message: result,
                true_btn_text:'Ok',
                callback: function(data1){
                    if(data1=="yes"){
                      window.location.href = base_url+'view/hotels/master/index.php?activeid=3';
                    }
                }
            });
          }
        }
    }); 
}
});
</script>