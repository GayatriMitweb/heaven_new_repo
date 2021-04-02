<form id="frm_tour_master_save1"> 
<div class="app_panel">
<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
                <a>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </button>
          </div>
      </div>
    </div> 
    <div class="container">
      <div class="row mg_tp_20">
          <div class="col-md-3 col-sm-6 mg_bt_10 col-md-offset-2">
              <select id="cmb_tour_type" name="cmb_tour_type" class="form-control" title="Tour Type" onchange="incl_reflect(this.id);">
                <option value="">*Tour Type</option>
                <option value="Domestic">Domestic</option>
                <option value="International">International</option>
            </select>
          </div>   
          <div class="col-md-3 col-sm-6 mg_bt_10">
            <input class="form-control" type="text" onchange="fname_validate(this.id)" id="txt_tour_name" name="txt_tour_name" placeholder="*Tour Name" title="Tour Name"/>
          </div>
          <div class="col-md-3 col-sm-6 mg_bt_10 ">
            <select id="dest_name_s"  name="dest_name_s" title="Select Destination" class="form-control"  style="width:100%" required> 
                <option value="">*Destination</option>
                <?php 
                $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
                while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                <?php } ?>
            </select>
          </div>
          
      </div>  

      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">
      <div class="row mg_bt_10">
          <div class="col-md-12 text-right mg_tp_10">
              <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_tour_group')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
              <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_tour_group')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
          </div>
      </div>
      <legend>Tour Dates</legend>
      <div class="row">
          <div class="col-md-12">
              <div class="table-responsive">
              <table id="tbl_dynamic_tour_group" name="tbl_dynamic_tour_group" class="table border_0 no-marg" style="padding: 0 !important;">
                  <tr>
                      <td><input class="css-checkbox" id="chk_tour_group1" type="checkbox" checked><label class="css-label" for="chk_tour_group1"> <label></td>
                      <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                      <td><input type="text" id="txt_from_date1" name="txt_from_date1" placeholder="*From Date" title="From Date"  value="<?= date('d-m-Y')?>" onchange="get_to_date(this.id,'txt_to_date1')"></td>
                      <td><input type="text" id="txt_to_date1" name="txt_to_date1" placeholder="*To Date" title=" To Date" value="<?= date('d-m-Y')?>" onchange="generate_list();"></td>
                      <td><input type="text" id="txt_capacity1" name="txt_capacity1" class="form-control" placeholder="*Tour Capacity" onchange="validate_balance(this.id);validate_tourCapacity(this.id)" title="Tour Capacity" /></td>
                  </tr>                                
              </table>
              </div>
          </div>
      </div>      
      </div>
      <div class="row">
          <div class="col-md-12" id="div_list1">
          </div>
      </div>
      
      <div class="row">
          <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 
            <select name="active_flag" id="active_flag" title="Status" class="hidden">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>    
      </div>
      <div class="row mg_bt_10 mg_tp_20 text-center">
          <button class="btn btn-sm btn-info ico_right" id="btn_save">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
      </div>
    </div>
</div>
</form>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>
$('#dest_name_s').select2();
jQuery('#txt_from_date1, #txt_to_date1').datetimepicker({ timepicker:false, minDate:new Date(), format:"d-m-Y" });
generate_list();

$(function(){
  $('#frm_tour_master_save1').validate({
    rules:{
        cmb_tour_type : { required: true },
        txt_tour_name : { required: true },
        active_flag : { required : true },
        day_program : { required : true },
        special_attaraction : { required : true },
        overnight_stay : { required : true },
        dest_name_s : {required:true}
    },
    submitHandler:function(form){

        var valid_state = table_info_validate();
        var valid_state1 = table_date_validate();
        if((valid_state==false) || (valid_state1==false)){ return false; }

        $('#tab1_head').addClass('done');
        $('#tab2_head').addClass('active');
        $('.bk_tab').removeClass('active');
        $('#tab2').addClass('active');
        $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

        return false;

    }
  });
});

function table_info_validate()
{
  g_validate_status = true; 
  var validate_message = "";


//Tour group table
var from_date = new Array();
var to_date = new Array();
var capacity = new Array();

var table = document.getElementById("tbl_dynamic_tour_group");
var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
      if(row.cells[0].childNodes[0].checked)
      {
        var from_date1 = row.cells[2].childNodes[0].value;         
        var to_date1 = row.cells[3].childNodes[0].value;         
        var capacity1 = row.cells[4].childNodes[0].value;   

        if(from_date1=="" || to_date1=="" ){  
          error_msg_alert('From date and To Date is required in row'+(i+1));
          return false; 
        }
        if(capacity1=="" ){  
          error_msg_alert('Tour Capacity is required in row'+(i+1));
          return false; 
        }
        var edate = from_date1.split('-');
        e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
        var edate1 = to_date1.split('-');
        e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

        var from_date_ms = new Date(e_date).getTime();
        var to_date_ms = new Date(e_date1).getTime();
    
        if (from_date_ms > to_date_ms) {
          error_msg_alert('Date should not be greater than valid to date at row '+(i+1));
          return false;
        }
        from_date.push(from_date1);
        to_date.push(to_date1);
        capacity.push(capacity1);    
      }   
  }

  var tour_count = 0;
  var table = document.getElementById("tbl_dynamic_tour_group");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
      if(row.cells[0].childNodes[0].checked){
        tour_count++;
      }
  }
  if(tour_count==0){
    error_msg_alert('Atleast add one Tour'); return false;
  }


  //Special attraction table
  var table = document.getElementById("dynamic_table_list_group");
  var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++)
    {
      var row = table.rows[i]; 
      var special_attaraction = row.cells[1].childNodes[0].value;         
      var day_program = row.cells[2].childNodes[0].value;         
      var overnight_stay = row.cells[3].childNodes[0].value;  
        if(special_attaraction=="" ){  
          error_msg_alert('Special Attraction is required in row'+(i+1));
          return false; 
        }
        if(day_program=="" ){  
          error_msg_alert('Day Program is required in row'+(i+1));
          return false; 
        }
        if(overnight_stay=="" ){  
          error_msg_alert('Overnight Stay is required in row'+(i+1));
          return false; 
        }
    }
}
/////////////********** Tour Master Information Save end**********/////////////

function table_date_validate(){
  g_validate_status = true; 
  var validate_message = "";

  var table = document.getElementById("tbl_dynamic_tour_group");
  var rowCount = table.rows.length;

  for(var i=0; i<rowCount; i++)
  {
      var row = table.rows[i];    
      if(row.cells[0].childNodes[0].checked){
           var from_date1 = row.cells[2].childNodes[0].value;
           var to_date1 = row.cells[3].childNodes[0].value;
           if(i!=0){   
              var row1 = table.rows[i-1];  
              if(row1.cells[0].childNodes[0].checked)
              { 
                var from_date2 = row1.cells[2].childNodes[0].value;
                var to_date2 = row1.cells[3].childNodes[0].value;
                 if((from_date1 == from_date2) && (to_date1 == to_date2))
                 {
                    error_msg_alert("Tour Dates can't be same at row"+(i+1)+"<br>");            
                    g_validate_status = false;    
                 }
              }
           }
      }
  }
  if(validate_message!="") { 

      $('#site_alert').vialert({ 
          type:"error",
          message:validate_message,
          delay:10000,
      });      
  }
  if(g_validate_status==false){ return false; }
}
function generate_list()
{
    var from_date = $("#txt_from_date1").val();
    var to_date = $("#txt_to_date1").val();

    var edate = from_date.split('-');
    e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
    var edate1 = to_date.split('-');
    e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

    var from_date_ms = new Date(e_date).getTime();
    var to_date_ms = new Date(e_date1).getTime();

    if (from_date_ms > to_date_ms) {
      error_msg_alert('Date should not be greater than valid to date');
      $('#div_list1').html('');
      return false;
    }else{
      $.post('../inc/generate_program_list.php', {from_date : from_date,to_date : to_date }, function(data){
          $('#div_list1').html(data);
      });
    }
}
function incl_reflect(cmb_tour_type)
{
  var tour_type = $("#"+cmb_tour_type).val();
  $.post('../inc/inclusion_reflect.php', {tour_type : tour_type }, function(data){
        var incl_arr = JSON.parse(data); 
         
        var $iframe = $('#inclusions-wysiwyg-iframe');
          $iframe.ready(function() {
            $iframe.contents().find("body").append(incl_arr['includes']);
        });

        var $iframe1 = $('#exclusions-wysiwyg-iframe');
          $iframe1.ready(function() {
            $iframe1.contents().find("body").append(incl_arr['excludes']);
        });
    });
}
</script>