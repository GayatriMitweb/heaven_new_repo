<form id="frm_tab_2">
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
<!--=======Header panel end======-->
  <div class="container">

      <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_20">
          <select name="day_name" id="day_name"></select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_20">
          
          <select id="dest_name2" name="dest_name" title="Select Destination" onchange="image_list_reflect(this.value)" class="form-control" style="width:100%"> 

              <option value="">Select Destination</option>

              <?php 

              $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 

                  while($row_dest = mysql_fetch_assoc($sq_query)){ ?>

                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>

                <?php } ?>

          </select>

        </div>
        <div class="col-md-2">
              <input type="button" class="btn btn-sm btnType" id="btn_image_save" onclick="daywise_image_prepare()" autocomplete="off" data-original-title="save" title="save" value="Save">
        </div>
      </div>

      <div id="image_div"></div>         

      <div class="row text-center mg_tp_20">
        <div class="col-md-12">
          <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()" ><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
          &nbsp;&nbsp;
          <button class="btn btn-sm btn-info ico_right" id="btn_quotation_save">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
      </div>
      <input type="hidden" id="daywise_url" name="daywise_url"/>
  </div>
</div>          
</form>
<script>

function daywise_image_prepare(){

  $('#btn_image_save').button('loading');
  var day = $('#day_name').val();
  var daywise_url = $('#daywise_url').val();

  var radioValue = $("input[name=image_check]:checked").val();
  if(typeof radioValue === 'undefined'){
      error_msg_alert("Select one daywise image!");
      $('#btn_image_save').button('reset');
      return false;
  }
  else{
      daywise_url += day+'='+radioValue+',';
      $('#btn_image_save').button('reset');
      msg_alert("Image Saved");
  }
  $('#daywise_url').val(daywise_url);
  return false;
}
    $('#btn_quotation_save').click(function(){
        var dateParts = $('#txt_from_date1').val().split("-");
        var dateParts1 = $('#txt_to_date1').val().split("-");
        const f_date = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);
        const t_date = new Date(+dateParts1[2], dateParts1[1] - 1, +dateParts1[0]);
        const diffTime = Math.abs(t_date - f_date);
        const total_days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        $('#day_name').empty();
        for (var days = 0; days <= total_days; days++){
            var days_in = days;++days_in;
            var newOption = new Option("Day -"+days_in,days_in , false, false);
            $('#day_name').append(newOption).trigger('change');
        }
    });
    function image_list_reflect(dest_name2)

{

  var dest_id = $('#dest_name2').val();



  $.post('../inc/image_list_reflect.php', {dest_id : dest_id}, function(data){

        $('#image_div').html(data);

    });

}
$(function(){
  $('#frm_tab_2').validate({
    rules:{
        
    },
    submitHandler:function(form){

        var daywise_url = $('#daywise_url').val();

      $('#tab3_head').addClass('done');
      $('#tab4_head').addClass('active');
      $('.bk_tab').removeClass('active');
      $('#tab4').addClass('active');
      $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
      return false;

    }
  });
});
function switch_to_tab2(){

  $('#tab3_head').removeClass('active');
	$('#tab2_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab2').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}
</script>