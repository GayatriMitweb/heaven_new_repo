<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT git_tours FROM `b2c_settings` where setting_id='1'"));
$git_tours = json_decode($query['git_tours']);
?>
<form id="section_package">
    <legend>Define Group Tours Date Rangewise</legend>
    <div class="row mg_bt_10"> <div class="col-md-12 no-pad">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_grp_packages_datewise')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_grp_packages_datewise');" title="Delete Row"><i class="fa fa-trash"></i></button>
        <div class="col-md-10 mg_tp_10"><label class="alert-danger">For saving packages keep checkbox selected!</label></div>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-12"> <div class="table-responsive">
    <table id="tbl_grp_packages_datewise" name="tbl_grp_packages_datewise" class="table border_0 table-hover">
        <?php
        if(sizeof($git_tours) == 0){ ?>
        <tr>
            <td><input id="chk_dest1" type="checkbox" checked></td>
            <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select style="width:100%;" class="form-control" id="cmb_tour_name-1" name="cmb_tour_name-1" onchange="tour_groups_reflect(this.id);" title="Tour Name"> 
                <option value="">Tour Name </option>
                <?php
                    $sq=mysql_query("select tour_id,tour_name from tour_master order by tour_name");
                    while($row=mysql_fetch_assoc($sq)){
                        echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }
                ?>
            </select></td>
            <td><select name="validity" id="validity-1" title="Select Validity" onchange="check_validity(this.id)">
                    <option value="">Select Validity</option>
                    <option value="Permanent">Permanent</option>
                    <option value="Period">Period</option>
                </select></td>
            <td><input type="text" placeholder="From Date" title="From Date" id="from_date-1"  class="form-control" onchange="get_to_date(this.id,'to_date-1')"/></td>
            <td><input type="text" placeholder="To Date" title="To Date" id="to_date-1"  class="form-control" onchange="validate_validDate('from_date-1',this.id)" /></td>
            <script>
                $('#dest_name-1').select2();
                $('#from_date-1,#to_date-1').datetimepicker({ timepicker:false, format:'d-m-Y' });
            </script>
        </tr>
        <?php
        }
        else{
        for($i=0;$i<sizeof($git_tours);$i++){

            $tour_id=$git_tours[$i]->tour_id;
            $sq_dest = mysql_fetch_assoc(mysql_query("select tour_id,tour_name from tour_master where tour_id='$tour_id'"));
            $package_id=$git_tours[$i]->package_id;
            $disabled = ($git_tours[$i]->validity != 'Period') ? 'readonly' : '';
        ?>
        <tr>
            <td><input id="chk_dest1<?=$i?>_u" type="checkbox" checked></td>
            <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select style="width:100%;" class="form-control" id="cmb_tour_name-1<?=$i?>_u" name="cmb_tour_name-1<?=$i?>_u" onchange="tour_groups_reflect(this.id);" title="Tour Name">
                <option value='<?= $sq_dest['tour_id']?>'><?= $sq_dest['tour_name'] ?></option>
                <option value="">Tour Name </option>
                <?php
                    $sq=mysql_query("select tour_id,tour_name from tour_master order by tour_name");
                    while($row=mysql_fetch_assoc($sq)){
                        echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }
                ?>
            </select></td>
            <td><select name="validity" id="validity-1<?=$i?>_u" title="Select Validity" onchange="check_validity(this.id)">
                    <option value="<?= $git_tours[$i]->validity ?>"><?= $git_tours[$i]->validity ?></option>
                    <option value="">Select Validity</option>
                    <option value="Permanent">Permanent</option>
                    <option value="Period">Period</option>
                </select></td>
            <td><input type="text" placeholder="From Date" title="From Date" id="from_date-1<?=$i?>_u"  class="form-control" onchange="get_to_date(this.id,'to_date-1<?=$i?>_u')" value="<?= $git_tours[$i]->from_date ?>" <?= $disabled ?>/></td>
            <td><input type="text" placeholder="To Date" title="To Date" id="to_date-1<?=$i?>_u"  class="form-control" onchange="validate_validDate('from_date-1<?=$i?>_u',this.id)" value="<?= $git_tours[$i]->to_date ?>" <?= $disabled ?> /></td>
        </tr>
        <script>
        $('#dest_name-1<?=$i?>_u').select2();
        $('#from_date-1<?=$i?>_u,#to_date-1<?=$i?>_u').datetimepicker({ timepicker:false, format:'d-m-Y' });
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

function check_validity(id){
    var id1 = $('#'+id).val();
    var offset = id.split('-');
    if(id1 === "Permanent"){
        $('#from_date-'+offset[1]).attr({ 'disabled': 'disabled' });
        $('#to_date-'+offset[1]).attr({ 'disabled': 'disabled' });
        $('#from_date-'+offset[1]).val('');
        $('#to_date-'+offset[1]).val('');
    }
    else{
        $('#from_date-'+offset[1]).removeAttr('readonly');
        $('#to_date-'+offset[1]).removeAttr('readonly');
        $('#from_date-'+offset[1]).removeAttr('disabled');
        $('#to_date-'+offset[1]).removeAttr('disabled');
    }
}

//function for valid date tariff
function validate_validDate (from, to) {

    var offset = to.split('-');
	var from_date = $('#from_date-' + offset[1]).val();
	var to_date = $('#' + to).val();

	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	var edate1 = to_date.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();
    
	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert('Date should not be greater than valid to date');
		$('#from_date-' + offset[1]).css({ border: '1px solid red' });
		$('#from_date-' + offset[1]).val('');
		$('#from_date-' + offset[1]).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#from_date-' + offset[1]).css({ border: '1px solid #ddd' });
		return true;
	}
	return true;
}
function tour_groups_reflect(cmb_tour_name){

    var tour_id = $("#"+cmb_tour_name).val(); 
    var offset = cmb_tour_name.split('-'); 
    $.get( "group_tours_datewise/tour_groups_reflect.php" , { tour_id : tour_id } , function ( data ) {
    $ ("#cmb_tour_group-"+offset[1]).html( data ) ;              
    });
}
//Get Date
function get_to_date (from_date, to_date) {

    var from_date1 = $('#' + from_date).val();
    
    var offset = from_date.split('-');
	if (from_date1 != '') {
		var edate = from_date1.split('-');
		e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
		var currentDate = new Date(new Date(e_date).getTime() + 24 * 60 * 60 * 1000);
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		if (day < 10) {
			day = '0' + day;
		}
		if (month < 10) {
			month = '0' + month;
		}
		$('#to_date-'+offset[1]).val(day + '-' + month + '-' + year);
	}
	else {
		$('#to_date-'+offset[1]).val('');
	}
}

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
    var table = document.getElementById("tbl_grp_packages_datewise");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
        
        var row = table.rows[i];
        var destination = row.cells[2].childNodes[0].value;
        // var package = row.cells[3].childNodes[0].value;
        var validity = row.cells[3].childNodes[0].value;
        var from_date = row.cells[4].childNodes[0].value;
        var to_date = row.cells[5].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){

            if(destination==""){ error_msg_alert("Select Destination at row "+(i+1)); return false; }
            // if(package==""){ error_msg_alert("Select Package at row "+(i+1)); return false;}
            if(validity==""){ error_msg_alert("Select validity at row "+(i+1)); return false; }
            if(validity == 'Period'){
                if(from_date==""){ error_msg_alert("Select from date at row "+(i+1)); return false;}
                if(to_date==""){ error_msg_alert("Select to date at row "+(i+1)); return false;}
            }

            images_array.push({          
                'tour_id':destination,
                'validity':validity,
                'from_date':from_date,
                'to_date' :to_date
            });
        }
    }

    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '12', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('12');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>