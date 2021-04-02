<?php 
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$role_id= $_SESSION['role_id'];
?>
<form id="frm_tab1">
<div class="app_panel"> 
<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
        <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
                <a title="Next"><i class="fa fa-arrow-right"></i></a>
            </button>
          </div>
        </div>
    </div> 
<!--=======Header panel end======-->

    <div class="container">
        <h5 class="booking-section-heading main_block text-center">Tariff for Hotel</h5>
        <div class="app_panel_content Filter-panel mg_bt_20">
            <div class="row mg_bt_10">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <select id="cmb_city_id1" name="cmb_city_id1" onchange="hotel_name_list_load(this.id)" class="city_master_dropdown" style="width:100%" title="Select City Name" required>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <select id="hotel_id1" name="hotel_id1" style="width:100%" title="Select Hotel Name" data-toggle="tooltip" required>
                        <option value="">*Select Hotel</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="currency_code" id="currency_code1" title="Currency" style="width:100%" data-toggle="tooltip" required>
                        <option value=''>Select Currency</option>
                        <?php
                        $sq_currency = mysql_query("select * from currency_name_master order by currency_code");
                        while($row_currency = mysql_fetch_assoc($sq_currency)){
                        ?>
                        <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <h5 class="booking-section-heading main_block text-center">Hotel Seasonal Tariff</h5>
        <div class="row mg_bt_10">
            <div class="col-md-12 text-right text_center_xs">
                <div class="col-md-6 text-left">
                    <button type="button" class="btn btn-sm btnType st-custBtn" onclick="seasonal_csv();" data-toggle="tooltip" title="Download CSV"><i class="icon fa fa-download"></i>CSV Format</button>

                    <div class="div-upload  mg_bt_20" data-toggle="tooltip" title="Upload CSV" id="div_upload_button1">
                        <div id="b2btariff_csv_upload" role='button' class="upload-button1"><span>CSV</span></div>
                        <span id="cust_status" ></span>
                        <ul id="files" ></ul>
                        <input type="hidden" id="hotel_tarrif_upload" name="hotel_tarrif_upload">
                    </div>
                </div>
                <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_tarrif1','1')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_hotel_tarrif1','1')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table_hotel_tarrif1" name="table_hotel_tarrif" class="table table-bordered table-hover table-striped pd_bt_51 no-marg" style="width: 1400px;">
                        <tr>
                        <td><input class="css-checkbox" id="chk_ticket1" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
                        <?php include 'hotel_tarrif_list.php';?>
                    </table>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-12 mg_tp_20 mg_bt_150">
                <button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
            </div>
        </div>
</form>
<?= end_panel() ?>

<script>
$('#currency_code1,#hotel_id1').select2();
city_lzloading('#cmb_city_id1');
function seasonal_csv(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/hotel_b2btariff_import-seasonal.csv";
}

//**Hotel Name load start**//
function hotel_name_list_load(id){
  var city_id = $("#"+id).val();
  var base_url = $('#base_url').val();
  $.get( base_url+"view/hotels/master/b2b_tarrif/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_id1").html( data );
  });
}

hotel_tarrif_save1();
function hotel_tarrif_save1(){
    var type="hotel_tariff_list";
	var btnUpload=$('#b2btariff_csv_upload');
    var status=$('#cust_status');
    new AjaxUpload(btnUpload, {
      action: '../upload_tariff_csv.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         if(!confirm('Do you want to import this file?')){
            return false;
         }
         if (! (ext && /^(csv)$/.test(ext))){ 
            error_msg_alert('Only CSV files are allowed');
            return false;
         }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
        } else{
          document.getElementById("hotel_tarrif_upload").value = response;
          status.text('Uploading...');
          hotel_tarrif1();
          status.text('');
          
        }
      }
    });
}

function hotel_tarrif1(){
    var cust_csv_dir = document.getElementById("hotel_tarrif_upload").value;
	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/hotel/b2btariff_csv_save.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){
            var pass_arr = JSON.parse(result);
            if(pass_arr[0]['room_cat']!=''){
                var table = document.getElementById("table_hotel_tarrif1");
                if(table.rows.length == 1){
                    for(var k=1; k<table.rows.length; k++){
                            document.getElementById("table_hotel_tarrif1").deleteRow(k);
                    }
                }else{
                    while(table.rows.length > 1){
                            document.getElementById("table_hotel_tarrif1").deleteRow(k);
                            table.rows.length--;
                    }
                }
                for(var i=0; i<pass_arr.length; i++){
                    var row = table.rows[i];
                    row.cells[2].childNodes[0].value = pass_arr[i]['room_cat'];
                    row.cells[3].childNodes[0].value = pass_arr[i]['max_occ'];
                    row.cells[4].childNodes[0].value = pass_arr[i]['from_date'];
                    row.cells[5].childNodes[0].value = pass_arr[i]['to_date'];
                    row.cells[7].childNodes[0].value = pass_arr[i]['double_bed'];
                    row.cells[9].childNodes[0].value = pass_arr[i]['cwbed'];
                    row.cells[10].childNodes[0].value = pass_arr[i]['cwobed'];			
                    row.cells[13].childNodes[0].value = pass_arr[i]['with_bed'];
                    row.cells[18].childNodes[0].value = pass_arr[i]['markup_per'];
                    row.cells[19].childNodes[0].value = pass_arr[i]['flat_markup'];				
                    row.cells[20].childNodes[0].value = pass_arr[i]['meal_plan'];

                    if(i!=pass_arr.length-1){
                        if(table.rows[i+1]==undefined){
                            addRow('table_hotel_tarrif1','1');
                        }
                    }
                    $(row.cells[2].childNodes[0]).trigger('change');
                    $(row.cells[20].childNodes[0]).trigger('change');
                }
            }else{
                error_msg_alert('No Records in CSV!'); return false;
            }
        }
    });
}

function switch_to_tab1(){ 
	$('#tab2_head').removeClass('active');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

$('#to_date,#from_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#frm_tab1').validate({
	rules:{
	},
	submitHandler:function(form){
		var base_url = $('#base_url').val();

		var table = document.getElementById("table_hotel_tarrif1");
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

