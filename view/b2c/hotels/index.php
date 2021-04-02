<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT popular_hotels FROM `b2c_settings` where setting_id='1'"));
$popular_hotels = json_decode($query['popular_hotels']);
?>
<form id="section_hotels">
    <legend>Define Top Tour Hotels</legend>
    <div class="row mg_bt_10"> <div class="col-md-10 no-pad">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_hotels')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_hotels');" title="Delete Row"><i class="fa fa-trash"></i></button>
        <div class="col-md-10 mg_tp_10"><label class="alert-danger">For saving hotels keep checkbox selected!</label></div>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-10"> <div class="table-responsive">
    <table id="tbl_hotels" name="tbl_hotels" class="table border_0 table-hover no-marg">
        <?php
        if(sizeof($popular_hotels) == 0){?>
            <tr>
                <td><input id="chk_city1" type="checkbox" checked></td>
                <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><select name="city_name-1" id="city_name-1" class="city_name" onchange="hotel_names_load(this.id)" style="width:100%" class="form-control">
                </select></td>
                <td><select id='hotel_name-1' name='hotel_name-1' class="form-control">
                    <option value="">Hotel Name</option>
                </select></td>
            </tr>
            <script>
            </script>
        <?php
        }else{
            for($i=0;$i<sizeof($popular_hotels);$i++){
                $city_id=$popular_hotels[$i]->city_id;
                $sq_city = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$city_id'"));
                $hotel_id=$popular_hotels[$i]->hotel_id;
                $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$hotel_id'"));
            ?>
            <tr>
                <td><input id="chk_city1<?=$i?>_u" type="checkbox" checked></td>
                <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><select name="city_name-1<?=$i?>_u" id="city_name-1<?=$i?>_u" class="city_name" onchange="hotel_names_load(this.id)" style="width:100%" class="form-control">
                        <?php if($city_id!=''){ ?>
                        <option value="<?= $sq_city['city_id'] ?>" selected="selected"><?= $sq_city['city_name'] ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><select id='hotel_name-1<?=$i?>_u' name='hotel_name-1<?=$i?>_u' class="form-control">
                    <?php if($hotel_id!=''){ ?>
                    <option value="<?= $sq_hotel['hotel_id'] ?>"><?= $sq_hotel['hotel_name'] ?></option>
                    <?php } ?>
                    <option value="">Hotel Name</option>
                </select></td>
            </tr>
            <?php }
        } ?>
    </table>
    <script>
        city_lzloading('.city_name');
    </script>
    </div> </div> </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
//Hotel list load
function hotel_names_load (id,offset) {
    var offset = id.split('-');
	var base_url = $('#base_url').val();
	var city_id = $('#' + id).val();
	$.post(base_url + 'Tours_B2B/view/hotel/inc/hotel_list_load.php', { city_id: city_id }, function (data) {
		$('#hotel_name-'+offset[1]).html(data);
	});
}
$(function(){
$('#section_hotels').validate({
  rules:{
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = new Array();
    var table = document.getElementById("tbl_hotels");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
    var row = table.rows[i];
    var city = row.cells[2].childNodes[0].value;
    var hotel = row.cells[3].childNodes[0].value;

    if(row.cells[0].childNodes[0].checked){
        if(city==""){ error_msg_alert("Select City at row "+(i+1)); return false; }
        if(hotel==""){ error_msg_alert("Select Hotel at row "+(i+1)); return false;}
        images_array.push({
            'city_id':city,
            'hotel_id':hotel
        });
    }
    }
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '3', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('3');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>