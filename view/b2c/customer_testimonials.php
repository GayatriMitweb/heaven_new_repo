<?php
include '../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT customer_testimonials FROM `b2c_settings` where setting_id='1'"));
$customer_testimonials = json_decode($query['customer_testimonials']);
?>
<form id="section_ctm">
    <legend>Define Customer Testimonials</legend>
    <div class="row mg_bt_10"> <div class="col-md-12 no-pad">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_customer_tm')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_customer_tm');" title="Delete Row"><i class="fa fa-trash"></i></button>
        <div class="col-md-10 mg_tp_10"><label class="alert-danger">For saving customer keep checkbox selected!</label></div>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-12"> <div class="table-responsive">
    <table id="tbl_customer_tm" name="tbl_customer_tm" class="table border_0 table-hover no-marg">
        <?php
        if(sizeof($customer_testimonials) == 0){ ?>
            <tr>
                <td><input id="chk_ctm" type="checkbox" checked></td>
                <td><input maxlength="10" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" style="width:50px" disabled /></td>
                <td><input type="text" name="name" placeholder="Customer Name" class="form-control"/></td>
                <td><input type="text" name="designation" placeholder="Desingation" class="form-control" /></td>
                <td><textarea name="testm" placeholder="Testimonial(Upto 200 chars)" class="form-control" id="testm" onchange="validate_char_size('testm',200);" ></textarea></td>
            </tr>
        <?php
        }else{
            for($i=0;$i<sizeof($customer_testimonials);$i++){
                ?>
                <tr>
                    <td><input id="chk_city<?= ($i) ?>" type="checkbox" checked></td>
                    <td><input maxlength="15" value="<?= ($i+1) ?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                    <td><input type="text" name="name<?= ($i) ?>" placeholder="Customer Name" class="form-control" id="name<?= ($i) ?>" value="<?=$customer_testimonials[$i]->name ?>"/></td>
                    <td><input type="text" name="designation<?= ($i) ?>" placeholder="Desingation" class="form-control" id="designation<?= ($i) ?>" value="<?=$customer_testimonials[$i]->designation ?>" /></td>
                    <td><textarea name="testm" placeholder="Testimonial(Upto 200 chars)" id="testm<?= ($i) ?>" class="form-control" onchange="validate_char_size(this.id,200);" ><?=$customer_testimonials[$i]->testm ?></textarea></td>
                </tr>
            <?php }
        }?>
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

$(function(){
$('#section_ctm').validate({
  rules:{
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = new Array();
    var table = document.getElementById("tbl_customer_tm");
    var rowCount = table.rows.length;
    var count = 0;
    for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        if(row.cells[0].childNodes[0].checked) count++;
    }
    if(parseInt(count)>10){
        error_msg_alert("Can not enter more than 10 customers!"); return false;
    }
    for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        var name = row.cells[2].childNodes[0].value;
        var designation = row.cells[3].childNodes[0].value;
        var testm = row.cells[4].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){
            if(name==""){ error_msg_alert("Enter customer name at row "+(i+1)); return false; }
            if(designation==""){ error_msg_alert("Enter designation "+(i+1)); return false;}
            if(testm==""){ error_msg_alert("Enter testimonial "+(i+1)); return false;}
            
            var flag1 = validate_char_size(row.cells[4].childNodes[0].id,200);
            if(!flag1){
                return false;
            }
            images_array.push({
                'name':name,
                'designation':designation,
                'testm':testm
            });
        }
    }
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '8', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('8');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>