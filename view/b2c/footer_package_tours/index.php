<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT footer_holidays FROM `b2c_settings` where setting_id='1'"));
$footer_holidays = json_decode($query['footer_holidays']);
?>
<form id="section_package">
    <legend>Define Popular Tours for footer</legend>
    <div class="row mg_bt_10"> <div class="col-md-10 no-pad">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_dest_packages')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_dest_packages');" title="Delete Row"><i class="fa fa-trash"></i></button>
        <div class="col-md-10 mg_tp_10"><label class="alert-danger">For saving packages keep checkbox selected!</label></div>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-10"> <div class="table-responsive">
    <table id="tbl_dest_packages" name="tbl_dest_packages" class="table border_0 table-hover">
        <?php
        if(sizeof($footer_holidays)==0){ ?>
        <tr>
            <td><input id="chk_dest1" type="checkbox" checked></td>
            <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="dest_name-1" id="dest_name-1" onchange="package_dynamic_reflect(this.id)" style="width:100%" class="form-control app_select2">
                <option value="">*Select Destination</option>
                    <?php
                    $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
                    while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                    <?php } ?>
            </select></td>
            <td><select id="package-1" name="package-1" title="Select Package" class="form-control" style="width:100%">
                    <option value="">*Select Package</option>
                </select></td>
            <script>
            $('#dest_name-1').select2();
            </script>
        </tr>
        <?php
        }else{   
        for($i=0;$i<sizeof($footer_holidays);$i++){

            $dest_id=$footer_holidays[$i]->dest_id;
            $sq_dest = mysql_fetch_assoc(mysql_query("select dest_id,dest_name from destination_master where dest_id='$dest_id'"));
            $package_id=$footer_holidays[$i]->package_id;
            $sq_package = mysql_fetch_assoc(mysql_query("select package_id,package_name from custom_package_master where package_id='$package_id'"));
        ?>
        <tr>
            <td><input id="chk_dest1<?=$i?>_u" type="checkbox" checked></td>
            <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="dest_name-1<?=$i?>_u" id="dest_name-1<?=$i?>_u" onchange="package_dynamic_reflect(this.id)" style="width:100%" class="app_select2">
                <?php if($dest_id!='0'){?>
                    <option value="<?= $sq_dest['dest_id'] ?>"><?= $sq_dest['dest_name'] ?></option>
                <?php } ?>
                <option value="">*Select Destination</option>
                <?php
                    $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
                    while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                    <?php } ?>
            </select></td>
            <td><select id="package-1<?=$i?>_u" name="package-1<?=$i?>_u" title="Select Package" class="form-control" style="width:100%">
                    <?php if($package_id!='0'){?>
                        <option value="<?= $sq_package['package_id'] ?>"><?= $sq_package['package_name'] ?></option>
                    <?php } ?>
                    <option value="">*Select Package</option>
                </select></td>
        </tr>
        <script>
        $('#dest_name-1<?=$i?>_u').select2();
        </script>
        <?php } } ?>
    </table>
    </div> </div> </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
//Pacakges load
function package_dynamic_reflect(dest_name){
    var offset = dest_name.split('-');
	var dest_id = $("#"+dest_name).val();
    var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: 'package_tours/get_packages.php', 
		data: { dest_id : dest_id}, 
		success: function(result){
			$('#package-'+offset[1]).html(result);
		}
	});
}
$(function(){
$('#section_package').validate({
  rules:{
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = new Array();
    var table = document.getElementById("tbl_dest_packages");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
    var row = table.rows[i];
    var destination = row.cells[2].childNodes[0].value;
    var package = row.cells[3].childNodes[0].value;

    if(row.cells[0].childNodes[0].checked){
        if(destination==""){ error_msg_alert("Select Destination at row "+(i+1)); return false; }
        if(package==""){ error_msg_alert("Select Package at row "+(i+1)); return false;}
        images_array.push({          
            'dest_id':destination,
            'package_id':package
        });
    }
    }

    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '6', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('6');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>