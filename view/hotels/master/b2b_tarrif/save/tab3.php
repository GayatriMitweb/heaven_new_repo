<form id="frm_tab4">
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
    <h5 class="booking-section-heading main_block text-center">Weekend Rates</h5>
      <div class="row mg_bt_10">
        <div class="col-md-12 text-right text_center_xs">
          <div class="col-md-6 text-left">
              <button type="button" class="btn btn-sm btnType st-custBtn" onclick="display_format_modal1();" data-toggle="tooltip" title="Download CSV"><i class="icon fa fa-download"></i>CSV Format</button>

              <div class="div-upload  mg_bt_20" id="div_upload_button2" data-toggle="tooltip" title="Upload CSV">
                <div id="b2btariff_csv_upload3" class="upload-button1"><span>CSV</span></div>
                <span id="cust_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="div_upload_button3" name="div_upload_button3">
              </div>
          </div>
          <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_hotel_weekend_tarrif','4')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
          <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_hotel_weekend_tarrif','4')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="table_hotel_weekend_tarrif" name="table_hotel_weekend_tarrif" class="table table-bordered no-marg pd_bt_51" style="min-width:1500px">
                <tr>
                    <td><input class="css-checkbox" id="chk_ticket3" type="checkbox"><label class="css-label" for="chk_ticket"> </label></td>
                    <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                    <td><select name="room_cat2" id="room_cat2" style="width:145px;" title="Room Category" class="form-control app_select2"><?php get_room_category_dropdown(); ?></select></td>
                    <td><input type="text" id="m_occupancy" name="m_occupancy" placeholder="*Max Occupancy" title="Max Occupancy" onchange="validate_balance(this.id)" style="width: 130px;"/></td>  
                    <td><select name="day" id="day" style="width:150px;" title="Weekend Day" class="form-control app_select2">
                      <option value=""> Select Weekend Day</option>
                      <option value="Friday">Friday</option>
                      <option value="Saturday">Saturday</option>
                      <option value="Sunday">Sunday</option></select></td>
                    <td style='display:none;'><input type="text" id="single_bed" name="single_bed" placeholder="Single Bed" title="Single Bed" onchange="validate_balance(this.id)" style="width: 120px;"/></td>
                    <td><input type="text" id="double_bed" name="double_bed" placeholder="Room Cost" title="Room Cost"  onchange="validate_balance(this.id)" style="width: 120px;"/></td>
                    <td style='display:none;'><input type="text" id="triple_bed" name="triple_bed" placeholder="Triple Bed" title="Triple Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td><input type="text" id="cwbed" name="cwbed" placeholder="Child With Bed" title="Child With Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td><input type="text" id="cwobed" name="cwobed" placeholder="Child Without Bed" title="Child Without Bed"  onchange="validate_balance(this.id)" style="width: 137px;" /></td>
                    <td style='display:none;'><input type="text" id="first_child" name="first_child" placeholder="First Child" title="First Child"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td style='display:none;'><input type="text" id="second_child" name="second_child" placeholder="Second Child" title="Second Child"  onchange="validate_balance(this.id)" style="width: 110px;" /></td>
                    <td><input type="text" id="with_bed" name="with_bed" placeholder="Extra Bed" title="Extra Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td style='display:none;'><input type="text" id="queen" name="queen" placeholder="Queen Bed" title="Queen Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td style='display:none;'><input type="text" id="king" name="king" placeholder="King Bed" title="King Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td style='display:none;'><input type="text" id="quad_bed" name="quad_bed" placeholder="Quad Bed" title="Quad Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td style='display:none;'><input type="text" id="twin" name="twin" placeholder="Twin Bed" title="Twin Bed"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td><input type="text" id="markup_per" name="markup_per" placeholder="Markup(%)" title="Markup(%)"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td><input type="text" id="flat_markup" name="flat_markup" placeholder="Markup" title="Markup"  onchange="validate_balance(this.id)" style="width: 120px;" /></td>
                    <td><select name="meal_plan" id="meal_plan" style="width: 110px" class="form-control app_select2" title="Meal Plan">
                    <?php get_mealplan_dropdown(); ?></td>
                    <td><input type="hidden" id="entry_id" name="entry_id" /></td>
                  </tr>
                </table>
          </div>
        </div>
      </div>
      <div class="row text-center mg_tp_20 mg_bt_150">
        <div class="col-xs-12">
          <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab3()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
          &nbsp;&nbsp;
          <button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
      </div>
</form>
<?= end_panel() ?>

<script>
$('#to_date,#from_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#room_cat2').select2();

function display_format_modal1(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/hotel_b2btariff_import-weekend.csv";
}

hotel_tarrif_save3();
function hotel_tarrif_save3(){
    var type="hotel_tariff_list";
	  var btnUpload=$('#b2btariff_csv_upload3');
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
          document.getElementById("div_upload_button3").value = response;
          status.text('Uploading...');
          hotel_tarrif3();
          status.text('');          
        }
      }
    });
}

function hotel_tarrif3(){
    var cust_csv_dir = document.getElementById("div_upload_button3").value;
  	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/hotel/b2btariff_weekendrates.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){

          var pass_arr = JSON.parse(result);
          if(pass_arr.length != 0){
            var table = document.getElementById("table_hotel_weekend_tarrif");
            if(table.rows.length == 1){
              for(var k=1; k<table.rows.length; k++){
                  document.getElementById("table_hotel_weekend_tarrif").deleteRow(k);
              }
            }
            else{
              while(table.rows.length > 1){
                  document.getElementById("table_hotel_weekend_tarrif").deleteRow(k);
                  table.rows.length--;
              }
            }

            for(var i=0; i<pass_arr.length; i++){
                var row = table.rows[i];
                row.cells[2].childNodes[0].value = pass_arr[i]['room_cat'];
                row.cells[3].childNodes[0].value = pass_arr[i]['max_occ'];
                row.cells[4].childNodes[0].value = pass_arr[i]['day'];
                row.cells[6].childNodes[0].value = pass_arr[i]['double_bed'];
                row.cells[8].childNodes[0].value = pass_arr[i]['cwbed'];
                row.cells[9].childNodes[0].value = pass_arr[i]['cwobed'];			
                row.cells[12].childNodes[0].value = pass_arr[i]['with_bed'];
                row.cells[17].childNodes[0].value = pass_arr[i]['markup_per'];
                row.cells[18].childNodes[0].value = pass_arr[i]['flat_markup'];				
                row.cells[19].childNodes[0].value = pass_arr[i]['meal_plan'];
                if(i!=pass_arr.length-1){
                    if(table.rows[i+1]==undefined){
                        addRow('table_hotel_weekend_tarrif');
                    }
                }
            $(row.cells[2].childNodes[0]).trigger('change');
            $(row.cells[4].childNodes[0]).trigger('change');
            $(row.cells[19].childNodes[0]).trigger('change');
            }
          }else{
              error_msg_alert('No Records in CSV!'); return false;
          }
        }
    });
}

function switch_to_tab3(){ 
	$('#tab3_head').removeClass('active');
	$('#tab2_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab2').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
 }

$('#frm_tab4').validate({
	rules:{

	},
	submitHandler:function(form){
		var base_url = $('#base_url').val();
    
		var table = document.getElementById("table_hotel_weekend_tarrif");
		var rowCount = table.rows.length;

    for(var i=0; i<rowCount; i++){
      var row = table.rows[i];           
      if(row.cells[0].childNodes[0].checked){
        var room_cat = row.cells[2].childNodes[0].value;
        var max_occ = row.cells[3].childNodes[0].value;
        var day = row.cells[4].childNodes[0].value;
        if(room_cat==''){
          error_msg_alert('Select Room Category in Row-'+(i+1));
          return false;
        }
        if(max_occ==''){
          error_msg_alert('Enter Max occupancy in Row-'+(i+1));
          return false;
        }
        if(day==''){
          error_msg_alert('Select Weekend Day in Row-'+(i+1));
          return false;
        }
      }
    }

	  $('#tab3_head').addClass('done');
		$('#tab4_head').addClass('active');
		$('.bk_tab').removeClass('active');
		$('#tab4').addClass('active');
		$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
});
</script>