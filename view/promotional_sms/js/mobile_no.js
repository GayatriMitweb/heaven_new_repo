function mobile_no_edit_modal(mobile_no_id){
	$.post('mobile_no/mobile_no_edit_modal.php', { mobile_no_id : mobile_no_id }, function(data){
		$('#div_mobile_no_edit_content').html(data);
	});

}
