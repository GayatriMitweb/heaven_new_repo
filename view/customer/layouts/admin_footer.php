
</div>

<div id="site_alert"></div>

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