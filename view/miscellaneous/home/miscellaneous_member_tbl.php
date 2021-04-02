<tr>
    <td><input class="css-checkbox" id="chk_visa<?= $offset ?>1" type="checkbox" checked><label class="css-label" for="chk_visa<?= $offset ?>1"> <label></td>
    <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
    <td><input type="text" id="first_name<?= $offset ?>1" name="first_name<?= $offset ?>1" onchange="fname_validate(this.id)" placeholder="*First Name" title="First Name"/></td>
    <td><input type="text" id="middle_name<?= $offset ?>1" onchange="fname_validate(this.id)" name="middle_name<?= $offset ?>1" placeholder="Middle Name" title="Middle Name"/></td>
    <td><input type="text" id="last_name<?= $offset ?>1" name="last_name<?= $offset ?>1" onchange="fname_validate(this.id)" placeholder="Last Name" title="Last Name"/></td>
    <td><input type="text" id="birth_date<?= $offset ?>1" name="birth_date<?= $offset ?>1" placeholder="Birth Date" title="Birth Date" class="app_datepicker" value="<?= date('d-m-Y',  strtotime(' -1 day')) ?>" onchange="checkPassportDate(this.id);adolescence_reflect(this.id)"/></td>
    <td ><input type="text" id="adolescence<?= $offset ?>1" name="adolescence<?= $offset ?>1" placeholder="Adolescence" title="Adolescence" disabled/></td>
    <td><input type="text" id="passport_id<?= $offset ?>1" name="passport_id<?= $offset ?>1" onchange="validate_passport(this.id)" placeholder="Passport ID" title="Passport ID" style="text-transform: uppercase;"/></td>
    <td><input type="text" id="issue_date<?= $offset ?>1" name="issue_date<?= $offset ?>1"  placeholder="Issue Date" class="app_datepicker" title="Issue Date" value="<?= date('d-m-Y')?>" onchange="checkPassportDate(this.id);"></td>
    <td><input type="text" id="expiry_date<?= $offset ?>1" name="expiry_date<?= $offset ?>1" class="app_datepicker" value="<?= date('d-m-Y') ?>"  placeholder="Expire Date" title="Expire Date" onchange="validate_issueDate('issue_date<?= $offset ?>1',this.id)"/ ></td>
</tr>

<script>
var date = new Date();
var yest = date.setDate(date.getDate()-1);
var tom = date.setDate(date.getDate()+1);

    $('#visa_country_name<?= $offset ?>1').select2();
    //$('#issue_date1').datetimepicker({ timepicker:false, maxDate:yest,format:'d-m-Y' });
    $('#birth_date1,#issue_date1').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });



function checkPassportDate(id){
    var idate = document.getElementById(id).value;
    var today = new Date().getTime(),
        idate = idate.split("-");

    idate = new Date(idate[2], idate[1] - 1, idate[0]).getTime();
   
    if((today - idate) < 0 )
    {
      error_msg_alert(" Date cannot be future date");
     $('#'+id).css({'border':'1px solid red'});  
        document.getElementById(id).value="";
        $('#'+id).focus();
         g_validate_status = false;
       return false;
    }
}


  function validate_issueDate (from, to) {
	  var from_date = $('#'+from).val(); 
    var to_date = $('#'+to).val(); 

    var parts = from_date.split('-');
    var date = new Date();
    var new_month = parseInt(parts[1])-1;
    date.setFullYear(parts[2]);
    date.setDate(parts[0]);
    date.setMonth(new_month);

    var parts1 = to_date.split('-');
    var date1 = new Date();
    var new_month1 = parseInt(parts1[1])-1;
    date1.setFullYear(parts1[2]);
    date1.setDate(parts1[0]);
    date1.setMonth(new_month1);

    var one_day=1000*60*60*24;

    var from_date_ms = date.getTime();
    var to_date_ms = date1.getTime();

    if(from_date_ms>to_date_ms ){
      error_msg_alert(" Date should be greater than passport issue date");
      $('#'+to).css({'border':'1px solid red'});  
        document.getElementById(to).value="";
        $('#'+to).focus();
        g_validate_status = false;
      return false;
    } 
  }
</script>