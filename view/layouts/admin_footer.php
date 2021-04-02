

</div>

<div id="div_customer_save_modal"></div>
<div id="div_city_save_modal"></div>
<div id="site_alert"></div>
<div id="vi_confirm_box"></div>
<div id="app_color_scheme_content"></div>
<div id="div_content_modal"></div>
<div id="div_itinerary_modal"></div>
<div id="vehicle_add_modal"></div>

<!-- Topbar Element -->
<div id="notification_block_bg_id" class="notification_bg"  onclick="display_notification()">
</div>

<!-- Notificatio Body -->
<div id="notification_block_body_id" class="notifications_body_block">
      <?php include_once("notifications/display_notification_modal.php")  ?>
 </div>


<script>
//**Sidebar toggle script start
$(function(){
	$('.sidebar_toggle_btn').click(function(){
		$('.sidebar_wrap, .app_content_wrap').toggleClass('toggle');
	});
	var width = $(window).width();
	if(width<992){
		$('.sidebar_wrap, .app_content_wrap').addClass('toggle');
	}else{
		$('.sidebar_wrap, .app_content_wrap').removeClass('toggle');
	}
});
$(window).resize(function(){
	var width = $(window).width();
	if(width<992){
		$('.sidebar_wrap, .app_content_wrap').addClass('toggle');
	}else{
		$('.sidebar_wrap, .app_content_wrap').removeClass('toggle');
	}
});
//**Sidebar toggle script end

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
</body>
</html>