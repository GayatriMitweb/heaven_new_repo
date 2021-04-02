<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT popular_activities FROM `b2c_settings` where setting_id='1'"));
$popular_activities = json_decode($query['popular_activities']);
?>
<form id="section_activities">
    <legend>Define Top Tour Activities</legend>
    <div class="row mg_bt_10"> <div class="col-md-10 no-pad">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_activities')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_activities');" title="Delete Row"><i class="fa fa-trash"></i></button>
        <div class="col-md-10 mg_tp_10"><label class="alert-danger">For saving activities keep checkbox selected!</label></div>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-10"> <div class="table-responsive">
    <table id="tbl_activities" name="tbl_activities" class="table border_0 table-hover no-marg">
        <?php
        if(sizeof($popular_activities)==0){
        ?>
            <tr>
                <td><input id="chk_city1" type="checkbox" checked></td>
                <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><select name="city_name-1" id="city_name-1" class="city_name_u" onchange="excursion_dynamic_reflect(this.id)" style="width:100%" class="form-control app_select2">
                        <?php if($city_id!=''){ ?>
                        <option value="<?= $sq_city['city_id'] ?>" selected="selected"><?= $sq_city['city_name'] ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><select id="exc-1" name="exc-1" class="form-control" style="width:100%">
                        <?php if($popular_activities[$i]->exc_id !=''){ ?>
                        <option value="<?= $popular_activities[$i]->exc_id ?>"><?= $popular_activities[$i]->exc_id ?></option>
                        <?php } ?>
                        <option value="">*Select Excursion</option>
                    </select></td>
            </tr>
        <?php }
        else{
            for($i=0;$i<sizeof($popular_activities);$i++){
                $city_id=$popular_activities[$i]->city_id;
                $exc_id=$popular_activities[$i]->exc_id;
                $sq_city = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$city_id'"));
                $sq_ex = mysql_fetch_assoc(mysql_query("select entry_id,excursion_name from excursion_master_tariff where entry_id='$exc_id'"));
            ?>
            <tr>
                <td><input id="chk_city1<?=$i?>_u" type="checkbox" checked></td>
                <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><select name="city_name-1<?=$i?>_u" id="city_name-1<?=$i?>_u" class="city_name_u" onchange="excursion_dynamic_reflect(this.id)" style="width:100%" class="form-control app_select2">
                        <?php if($city_id!=''){ ?>
                        <option value="<?= $sq_city['city_id'] ?>" selected="selected"><?= $sq_city['city_name'] ?></option>
                        <?php } ?>
                    </select>
                </select></td>
                <td><select id="exc-1<?=$i?>_u" name="exc-1<?=$i?>_u" class="form-control" style="width:100%">
                        <?php if($sq_ex['entry_id'] !=''){ ?>
                        <option value="<?= $sq_ex['entry_id'] ?>"><?= $sq_ex['excursion_name'] ?></option>
                        <?php } ?>
                        <option value="">*Select Excursion</option>
                    </select></td>
            </tr>
            <?php }
            } ?>
    </table>
    <script>
        city_lzloading('.city_name_u');
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
//Excursion load
function excursion_dynamic_reflect(city_name){
    
    var offset = city_name.split('-');
	var city_id = $("#"+city_name).val();
    var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: 'activities/get_excursions.php', 
		data: { city_id : city_id}, 
		success: function(result){
			$('#exc-'+offset[1]).html(result);
		}
	});
}
$(function(){
$('#section_activities').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = new Array();
    var table = document.getElementById("tbl_activities");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
    var row = table.rows[i];
    var city = row.cells[2].childNodes[0].value;
    var exc = row.cells[3].childNodes[0].value;

    if(row.cells[0].childNodes[0].checked){
        if(city==""){ error_msg_alert("Select City at row "+(i+1)); return false; }
        if(exc==""){ error_msg_alert("Select Excursion at row "+(i+1)); return false;}
        images_array.push({
            'city_id':city,
            'exc_id':exc
        });
    }
    }
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '4', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('4');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>