<?php
$day_count = 0;
$sq_day_image = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_images where quotation_id='$quotation_id' and package_id='$package_id'"));
?>
<form id="frm_day_image_save">
<div class="app_panel">
<input type='hidden' id='delete_image_url' name='delete_image_url' value='<?= $sq_day_image['image_url'] ?>'>
<input type='hidden' id='image_url_id' name='image_url_id' value='<?= $sq_day_image['id'] ?>'>
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
          <div class="pull-right header_btn">
            <button data-target="#myModalHint" data-toggle="modal">
              <a title="Help">
                <i class="fa fa-question" aria-hidden="true"></i>
              </a>
            </button>
          </div>
      </div>
    </div> 
<!--=======Header panel end======-->
    <div class="container">

  <div class="row">
    <!-- Accordian content Start-->
    <div id="daywise_image_select1">
    </div>
  </div>
    <!-- Accordian Content End-->
  <div class="row mg_tp_20">
    <h4>Update uploaded Images</h4><hr>
    <div id="daywise_image_select"></div>
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

function load_images(image_url,package_id,id){
    var base_url = $("#base_url").val();
    var quotation_id = $('#quotation_id1').val();
    $.ajax({
      type:'post',
      url: 'load_images.php',
      data:{ image_url : image_url,package_id:package_id,id:id,quotation_id:quotation_id},
      success:function(result){
        $('#daywise_image_select1').html(result);
      }
  });    
}
load_images('<?= $sq_day_image['image_url'] ?>','<?= $package_id ?>','<?= $sq_day_image['id'] ?>');

function delete_image(package_id,day_id,url,id){
    var base_url = $("#base_url").val();
    $.ajax({
      type:'post',
      url: base_url+'controller/package_tour/quotation/quotation_daywise_images.php',
      data:{ package_id : package_id,day_id:day_id,url:url,id:id },
      success:function(result){
        $('#delete_image_url').val(result);
        load_images(result,package_id,id);
      }
  });    
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