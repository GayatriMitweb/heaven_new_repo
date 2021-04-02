<div class="row text-right">
    <div class="col-xs-12">
        <div class="col-md-6 text-left">
            <button type="button" class="btn btn-info btn-sm ico_left pull-left" style="margin-right:10px" onclick="display_format_modal();"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;CSV Format</button>
            <div class="div-upload  mg_bt_20" id="div_upload_button">
                  <div id="cust_csv_upload" class="upload-button1"><span>CSV</span></div>
                  <span id="cust_status" ></span>
                  <ul id="files" ></ul>
                  <input type="hidden" id="txt_cust_csv_upload_dir" name="txt_cust_csv_upload_dir">
            </div>
        </div>    
        <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10" onClick="addRow('tbl_member_dynamic_row')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
        <button type="button" class="btn btn-danger btn-sm ico_left mg_bt_10" onClick="deleteRow('tbl_member_dynamic_row')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>    
    </div>
</div>
    

<div class="row"> <div class="col-xs-12"> <div class="table-responsive">
<table id="tbl_member_dynamic_row" class="table table-bordered table-hover table-striped no-marg-sm" style="width:1504px">
<tr>
    <td><input class="css-checkbox" id="check-btn-member-1" type="checkbox" onchange="payment_details_reflected_data('tbl_member_dynamic_row');get_auto_values('txt_date','basic_amount','payment_mode','txt_tour_cost','markup','save')" checked ><label class="css-label" for="check-btn-member-1"></label>
    </td>

    <td><input type="text"  value="1" placeholder="Sr. No." style="width:50px" disabled/></td>
    
    <td><select id="cmb_m_honorific1" title="Honorific" name="cmb_m_honorific1">
            <option value="Mr"> Mr </option>
            <option value="Mrs"> Mrs </option>
            <option value="Mas"> Mas </option>
            <option value="Miss"> Miss </option>
            <option value="Smt"> Smt </option>
            <option value="Infant"> Infant </option>
        </select>
    </td>
    
    <td style="width: 129px;"><input type="text" id="txt_m_first_name1" title="First Name" name="txt_m_first_name1" onchange="fname_validate(this.id); payment_details_reflected_data('tbl_member_dynamic_row');" placeholder="*First Name" />
    </td>

    <td><input type="text" id="txt_m_middle_name1" title="Middle Name" name="txt_m_middle_name1" onchange=" fname_validate(this.id); payment_details_reflected_data('tbl_member_dynamic_row');" placeholder="Middle Name" />
    </td>

    <td style="width: 129px;"><input type="text" id="txt_m_last_name1" title="Last Name" name="txt_m_last_name1" onchange="fname_validate(this.id);payment_details_reflected_data('tbl_member_dynamic_row');" placeholder="Last Name" />
    </td>

    <td><select class="empty" id="cmb_m_gender1" title="Gender" name="cmb_m_gender1" style="width:60px;"> 
            <option value="Male"> M </option>
            <option value="Female"> F </option>
        </select>
    </td>

    <td><input type="text" id="m_birthdate1" name="m_birthdate1" title="Birthdate" onchange="calculate_age_member(this.id); payment_details_reflected_data('tbl_member_dynamic_row');" value="<?= date('d-m-Y',  strtotime(' -1 day'))?>" placeholder="*Birth Date" />
    </td>

    <td style="width: 100px;"><input type="text" id="txt_m_age1" name="txt_m_age1" title="Age(Y:M:D)" placeholder="*Age" onchange="payment_details_reflected_data('tbl_member_dynamic_row')" />
    </td>

    <td><select id="txt_m_adolescence1" name="txt_m_adolescence1" title="Adolescence" style="width:60px" disabled>
            <option value=""></option>
            <option value="Adult">A</option>
            <option value="Child With Bed">CB</option>
            <option value="Child Without Bed">CWB</option>
            <option value="Infant">I</option>
        </select>
    </td>  

    <td style="width: 139px;"><input type="text" id="txt_m_passport_no" name="txt_m_passport_no" placeholder="Passport No" title="Passport No" onchange="validate_passport(this.id);payment_details_reflected_data('tbl_member_dynamic_row')" style="text-transform: uppercase;"  disabled></td>

    <td style="width: 130px;"><input type="text" id="txt_m_passport_issue_date" name="txt_m_passport_issue_date" placeholder="Issue Date" title="Passport Issue Date" class="app_datepicker" onchange="checkPassportDate(this.id);payment_details_reflected_data('tbl_member_dynamic_row')" disabled></td>

    <td style="width: 132px;"><input type="text" id="txt_m_passport_expiry_date" name="txt_m_passport_expiry_date" placeholder="Expire Date" title="Passport Expire Date" class="app_datepicker" onchange="checkExpiryDate(this.id);payment_details_reflected_data('tbl_member_dynamic_row')" disabled></td>
    
</tr>

</table>    
</div> </div> </div>
<script type="text/javascript">
function checkExpiryDate (id) {
	var idate = document.getElementById(id).value;
    var today = new Date().getTime(),
        idate = idate.split("-");

    idate = new Date(idate[2], idate[1] - 1, idate[0]).getTime();
    if( (today - idate) < 0){
    }
    else{
        error_msg_alert(" Expiry date should not be past date");
		$('#'+id).css({'border':'1px solid red'});  
			document.getElementById(id).value="";
			$('#'+id).focus();
			g_validate_status = false;
		return false;    }
}
function checkPassportDate (id) {
	var date = document.getElementById(id).value;

	if (date == '') {
		alert('Please enter the Date..!!');
		return false;
	}
	else if (!date.match(/^(0[1-9]|[12][0-9]|3[01])[\- \/.](?:(0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$/)) {
		alert('date format is wrong');
		return false;
	}

	var today = new Date();
	date = Date.parse(date);
	if (today <= date) {
        error_msg_alert(" Date cannot be future date");
      $('#'+id).css({'border':'1px solid red'});  
        document.getElementById(id).value="";
        $('#'+id).focus();
        g_validate_status = false;
      return false;		
	}
}
cust_csv_upload();
function cust_csv_upload()
{   
    var type="passenger_list";
    var btnUpload=$('#cust_csv_upload');
    var status=$('#cust_status');
    new AjaxUpload(btnUpload, {
      action: 'tab_1/upload_passenger_csv.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         if(!confirm('Do you want to import this file?')){
            return false;
          }

         if (! (ext && /^(csv)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only excel sheet files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_cust_csv_upload_dir").value = response;
          cust_csv_save();
        }
      }
    });

}

function cust_csv_save()
{
    var cust_csv_dir = document.getElementById("txt_cust_csv_upload_dir").value;
    var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/group_tour/booking/passenger_csv_save.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){
            //msg_alert(result);            
           //passenger_list_reflect();
           var table = document.getElementById("tbl_member_dynamic_row");            
            var pass_arr = JSON.parse(result);
            for(var i=0; i<pass_arr.length; i++){
               
                var row = table.rows[i]; 
                row.cells[2].childNodes[0].value = pass_arr[i]['m_honorific'];
                row.cells[3].childNodes[0].value = pass_arr[i]['m_first_name'];
                row.cells[4].childNodes[0].value = pass_arr[i]['m_middle_name'];
                row.cells[5].childNodes[0].value = pass_arr[i]['m_last_name'];
                row.cells[6].childNodes[0].value = pass_arr[i]['m_gender'];
                row.cells[7].childNodes[0].value = pass_arr[i]['m_birth_date1'];
                row.cells[8].childNodes[0].value = pass_arr[i]['m_age'];
                row.cells[9].childNodes[0].value = pass_arr[i]['m_adolescence'];
                row.cells[10].childNodes[0].value = pass_arr[i]['m_passport_no'];
                row.cells[11].childNodes[0].value = pass_arr[i]['m_passport_issue_date1'];
                row.cells[12].childNodes[0].value = pass_arr[i]['m_passport_expiry_date1'];

                calculate_age_member(row.cells[7].childNodes[0].id);
                tour_type_reflect('cmb_tour_name');
                if(pass_arr[i]['m_passport_no'] != 'Na')
                {
                    $('#txt_m_passport_no'+(i+1)).removeAttr("disabled");
                    $('#txt_m_passport_issue_date'+(i+1)).removeAttr("disabled");
                    $('#txt_m_passport_expiry_date'+(i+1)).removeAttr("disabled");
                }  
                if(i!=pass_arr.length-1){
                    if(table.rows[i+1]==undefined){
                        addRow('tbl_member_dynamic_row');     
                    }                   
                }        

            }
            $('#txt_stay_total_seats').val(pass_arr.length);
        }
    });
}
function display_format_modal()
{
    var base_url = $('#base_url').val();
     window.location = base_url+"images/csv_format/passenger_list.csv";
}
function passenger_list_reflect()
{
    $.post('tab_1/passenger_list_reflect.php',{  }, function(data){
        $('#passenger_list').html(data);
    });
}
</script>
<script src="../js/tab_1_member_info_sec.js"></script>