function sms_group_edit_modal(sms_group_id){

	$.post('sms_group/sms_group_edit_modal.php', { sms_group_id : sms_group_id }, function(data){
		$('#div_sms_group_edit_content').html(data);
	});

}