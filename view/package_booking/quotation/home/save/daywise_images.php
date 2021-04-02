<form id="frm_day_image_save">
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
    <!-- Accordian content Start-->
    <div id="daywise_image_select">
    </div>
    <!-- Accordian Content End-->
  </div>
	<div class="row text-center mg_tp_20">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="back_to_tab_d()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-info btn-sm ico_right" id="day_next">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>

<?= end_panel() ?>
<script>
function back_to_tab_d(){
  $('#tab_daywise_head').removeClass('active');
	$('#tab2_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab2').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

$('#frm_day_image_save').validate({
  rules:{
  },
  submitHandler:function(form){
    
    $('#tab_daywise_head').addClass('done');
    $('#tab3_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab3').addClass('active');
    $('html, body').animate({scrollTop : $('.bk_tab_head').offset().top}, 200);
  }
});
</script>