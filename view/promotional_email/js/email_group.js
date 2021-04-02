function email_group_edit_modal(email_group_id){

	$.post('email_group/email_group_edit_modal.php', { email_group_id : email_group_id }, function(data){
		$('#div_sms_group_edit_content').html(data);
	});

}