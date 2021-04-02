<?php
$sq_tab5 = mysql_query("select * from hotel_offers_tarrif where hotel_id='$hotel_id'");
$sq_count5 = mysql_num_rows(mysql_query("select * from hotel_offers_tarrif where hotel_id='$hotel_id'"));
?>
<form id="frm_tab5">
<input type="hidden" value='<?=$sq_count5 ?>' id="sq_count5" name="sq_count5"/>
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
        <?php if($sq_count5 == 0){ ?>
            <div class="row text-right mg_bt_10">
            <div class="col-md-12 text-right text_center_xs">
                <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif_offer')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_hotel_tarrif_offer')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div>
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
                        <td><input type="text" id="from_date_h1" class="form-control" name="from_date_h1" placeholder="Valid From" title="Valid From" onchange="get_to_date('from_date_h1' , 'to_date_h1');" value="<?= date('d-m-Y') ?>" style="width: 130px;" /></td>
                        <td><input type="text" id="to_date_h1" class="form-control" name="to_date_h1" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date_h1' ,'to_date_h1')" value="<?= date('d-m-Y') ?>" style="width: 130px;" /></td>
                        <td><select name="amount_in" id="amount_in" style="width: 150px" class="form-control app_select2">
                            <option value=''>Amount In</option>
                            <option value='Flat'>Flat</option>
                            <option value='Percentage'>Percentage</option></select></td>
                        <td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 150px;"/></td>
                        <td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;"/></td>
                        <td><select name="agent_type" id="agent_type" style="width: 150px" class="form-control app_select2" title="Agent Type" multiple>
                            <option value=''>Agent Type</option>
                            <option value='Platinum'>Platinum</option>
                            <option value='Gold'>Gold</option>
                            <option value='Silver'>Silver</option></select></td>
                        <td><input type="hidden" id="entry_id" name="entry_id" /></td>
                    </tr>
                    <script>
                    $('#to_date_h1,#from_date_h1').datetimepicker({ timepicker:false, format:'d-m-Y' });
                    </script>
                    </table>
                </div>
            </div>
            </div>
		<?php }
		else{ ?>
		<div class="row mg_bt_10">
			<div class="col-md-12 text-right text_center_xs">
				<button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif_offer')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
			</div>
		</div>
		<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
			<table id="table_hotel_tarrif_offer" name="table_hotel_tarrif_offer" class="table table-bordered no-marg pd_bt_51" style="min-width:1500px">
			<?php
				$count = 1;
				while($row_tab5 = mysql_fetch_assoc($sq_tab5)){ ?>
                    <tr>
                        <td><input class="css-checkbox" id="chk_offer<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_offer"> </label></td>
                        <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                        <td><select name="offer_type" id="offer_type" style="width: 150px" class="form-control app_select2">
							<option value='<?= $row_tab5['type']?>'><?= $row_tab5['type']?></option>
                            <option value=''>Select Type</option>
                            <option value='Offer'>Offer</option>
                            <option value='Coupon'>Coupon</option></td>
                        <td><input type="text" id="from_date_h<?= $count ?>-u" class="form-control" name="from_date_h<?= $count ?>-u" placeholder="Valid From" title="Valid From" onchange="get_to_date(this.id,'to_date_h<?= $count ?>-u')" value='<?= get_date_user($row_tab5['from_date']) ?>' style="width: 130px;" /></td>
                        <td><input type="text" id="to_date_h<?= $count ?>-u" class="form-control" name="to_date_h" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date_h<?= $count ?>-u' ,'to_date_h<?= $count ?>-u')"  value='<?= get_date_user($row_tab5['to_date']) ?>' style="width: 130px;" /></td>
                        <td><select name="amount_in" id="amount_in" style="width: 150px" class="form-control app_select2">
							<option value='<?= $row_tab5['offer']?>'><?= $row_tab5['offer']?></option>
                            <option value=''>Amount In</option>
                            <option value='Flat'>Flat</option>
                            <option value='Percentage'>Percentage</option></select></td>
                        <td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 150px;" value="<?= $row_tab5['coupon_code']?>"/></td>
                        <td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;" value="<?= $row_tab5['offer_amount']?>"/></td>
                        <td><select name="agent_type" id="agent_type" style="width: 150px" class="form-control app_select2" multiple>
                            <?php 
                                $agent_type = explode(',', $row_tab5['agent_type']);
                            ?>
							<?php $sel = (in_array("Platinum", $agent_type)) ? "selected" : "" ?>
                            <option value='Platinum' <?= $sel ?>>Platinum</option>
							<?php $sel = (in_array("Gold", $agent_type)) ? "selected" : "" ?>
                            <option value='Gold' <?= $sel ?>>Gold</option>
							<?php $sel = (in_array("Silver", $agent_type)) ? "selected" : "" ?>
                            <option value='Silver' <?= $sel ?>>Silver</option></select></td>
                        <td><input type="hidden" id="entry_id" name="entry_id" value='<?= $row_tab5['entry_id']?>' /></td>
                    </tr>
                    <script>
                        $('#agent_type').select2();
                        $('#to_date_h<?= $count ?>-u,#from_date_h<?= $count ?>-u').datetimepicker({ timepicker:false, format:'d-m-Y' });
                    </script>
                <?php $count++; } ?>
                </table>
                </div>
            </div>
            </div>
            <?php } ?>

            <div class="row text-center mg_tp_20 mg_bt_150">
                <div class="col-xs-12">
                    <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab4()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
                    &nbsp;&nbsp;
                    <button class="btn btn-sm btn-success" id="btn_price_update"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Update</button>
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
        var pricing_id = $('#pricing_id').val();
        var city_id = $('#cmb_city_id1').val();
        var hotel_id = $('#hotel_id1').val();
        var currency_id = $('#currency_code1').val();
        var taxation_type = $('#taxation_type1').val();
        var taxation_id = $('#taxation_id1').val();
        var service_tax = $('#service_tax1').val();
        
        var sq_countc = $('#sq_countc').val();
        var sq_count3 = $('#sq_count3').val();
        var sq_count4 = $('#sq_count4').val();
        var sq_count5 = $('#sq_count5').val();

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
        var tab2_entry_id_array = new Array();
        var tab2_checked_id_array = [];
        var table_id = (sq_countc==0)?'table_hotel_tarrif1':'table_hotel_tarrif';
        var table = document.getElementById(table_id);
		
		var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];

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
        	  var entry_id = row.cells[21].childNodes[0].value;

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
			  tab2_entry_id_array.push(entry_id);
              tab2_checked_id_array.push(row.cells[0].childNodes[0].checked);
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
        var tab3_entry_id_array = new Array();
        var tab3_checked_id_array = [];
        var table_id = (sq_count3==0)?'table_hotel_tarrif3':'table_hotel_tarrif_update';
        var table = document.getElementById(table_id);
	    var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];

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
              var entry_id = row.cells[21].childNodes[0].value;

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
			  tab3_entry_id_array.push(entry_id);
              tab3_checked_id_array.push(row.cells[0].childNodes[0].checked);
        }

        //TAB-4
        var tab4_room_cat_array = new Array();
        var tab4_max_occ_array = new Array();
        var tab4_day_array = new Array();
        var tab4_double_bed_array = new Array();
        var tab4_chwithbed_array = new Array();
        var tab4_chwobed_array = new Array();
        var tab4_extra_bed_array = new Array();
        var tab4_markup_cost_array = new Array();
        var tab4_markup_per_array = new Array();
        var tab4_meal_plan_array = new Array();
        var tab4_entry_id_array = new Array();
        var tab4_checked_id_array = [];
        var table = document.getElementById("table_hotel_weekend_tarrif");
		var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
            var row = table.rows[i];

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
            var entry_id = row.cells[20].childNodes[0].value;

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
            tab4_entry_id_array.push(entry_id);
            tab4_checked_id_array.push(row.cells[0].childNodes[0].checked);
        }
        
        //TAB-5
        var type_array = new Array();
        var from_date_array = new Array();
        var to_date_array = new Array();
        var offer_array = new Array();
        var agent_array = new Array();
        var coupon_code_array = new Array();
        var offer_amount_array = new Array();
        var tab5_entry_id_array = new Array();
        var tab5_checked_id_array = [];

        var table = document.getElementById("table_hotel_tarrif_offer");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
            var type = row.cells[2].childNodes[0].value;
            var from_date = row.cells[3].childNodes[0].value;
            var to_date = row.cells[4].childNodes[0].value;
            var offer_in = row.cells[5].childNodes[0].value;
            var coupon_code = row.cells[6].childNodes[0].value;
            var offer_amount = row.cells[7].childNodes[0].value;
            var entry_id = row.cells[9].childNodes[0].value;
            if(type=='' && row.cells[0].childNodes[0].checked){
                error_msg_alert('Select Type in Row-'+(i+1));
                return false;
            }
            if(from_date=='' && row.cells[0].childNodes[0].checked){
                error_msg_alert('Select Valid From Date in Row-'+(i+1));
                return false;
            }
            if(to_date=='' && row.cells[0].childNodes[0].checked){
                error_msg_alert('Select Valid To Date in Row-'+(i+1));
                return false;
            }
            if(offer_in=='' && row.cells[0].childNodes[0].checked){
                error_msg_alert('Select Amount-in in Row-'+(i+1));
                return false;
            }
            if(type == 'Coupon' && row.cells[0].childNodes[0].checked){
                if(coupon_code==''){
                error_msg_alert('Enter Coupon code in Row-'+(i+1));
                return false;
                }
            }
            if(offer_amount=='' && row.cells[0].childNodes[0].checked){
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
            tab5_entry_id_array.push(entry_id);
            tab5_checked_id_array.push(row.cells[0].childNodes[0].checked);
		}
		
        $('#btn_price_update').button('loading');
		$.ajax({
			type:'post',
			url: base_url+'controller/vendor/hotel_pricing/b2b_hotel_tarrif_update.php',
			data:{  sq_countc:sq_countc,sq_count3:sq_count3,sq_count4:sq_count4,sq_count5:sq_count5,pricing_id:pricing_id,city_id :
                    city_id,hotel_id : hotel_id,currency_id:currency_id,taxation_type:taxation_type,taxation_id:taxation_id,service_tax : service_tax,
					tab2_room_cat_array:tab2_room_cat_array,tab2_max_occ_array:tab2_max_occ_array,tab2_from_date_array:tab2_from_date_array,tab2_to_date_array:tab2_to_date_array,tab2_double_bed_array:tab2_double_bed_array,tab2_chwithbed_array:tab2_chwithbed_array,tab2_chwobed_array:tab2_chwobed_array,tab2_extra_bed_array:tab2_extra_bed_array,tab2_markup_per_array:tab2_markup_per_array,tab2_markup_cost_array:tab2_markup_cost_array,tab2_meal_plan_array:tab2_meal_plan_array,
					tab2_entry_id_array:tab2_entry_id_array,tab2_checked_id_array:tab2_checked_id_array,
					tab3_room_cat_array:tab3_room_cat_array,tab3_max_occ_array:tab3_max_occ_array,tab3_from_date_array:tab3_from_date_array,tab3_to_date_array:tab3_to_date_array,tab3_double_bed_array:tab3_double_bed_array,tab3_chwithbed_array:tab3_chwithbed_array,tab3_chwobed_array:tab3_chwobed_array,tab3_extra_bed_array:tab3_extra_bed_array,tab3_markup_per_array:tab3_markup_per_array,tab3_markup_cost_array:tab3_markup_cost_array,tab3_meal_plan_array:tab3_meal_plan_array,
					tab3_entry_id_array:tab3_entry_id_array,tab3_checked_id_array:tab3_checked_id_array,
                    tab4_room_cat_array:tab4_room_cat_array,tab4_max_occ_array:tab4_max_occ_array,tab4_day_array:tab4_day_array,tab4_double_bed_array:tab4_double_bed_array,tab4_chwithbed_array:tab4_chwithbed_array,tab4_chwobed_array:tab4_chwobed_array,tab4_extra_bed_array:tab4_extra_bed_array,tab4_markup_per_array:tab4_markup_per_array,tab4_markup_cost_array:tab4_markup_cost_array,tab4_meal_plan_array:tab4_meal_plan_array,tab4_entry_id_array:tab4_entry_id_array,tab4_checked_id_array:tab4_checked_id_array,
                    type_array:type_array,from_date_array:from_date_array,to_date_array:to_date_array,offer_array:offer_array,coupon_code_array:coupon_code_array,offer_amount_array:offer_amount_array,agent_array:agent_array,tab5_entry_id_array:tab5_entry_id_array,tab5_checked_id_array:tab5_checked_id_array},
			success:function(result){
                $('#btn_price_update').button('reset');
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