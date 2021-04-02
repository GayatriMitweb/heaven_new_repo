function sms_message_edit_modal(sms_message_id){

	$.post('messages/message_edit_modal.php', { sms_message_id : sms_message_id }, function(data){
		$('#div_sms_message_edit_content').html(data);
	});

}

function sms_message_send(sms_message_id, offset){

	var sms_group_id = $('#sms_group_id_'+offset).val();

	var base_url = $('#base_url').val();

	$.ajax({
		type:'post',
		url:base_url+'controller/promotional_sms/messages/sms_message_send.php',
		data:{ sms_message_id : sms_message_id, sms_group_id : sms_group_id },
		success:function(result){
			msg_alert(result);
			sms_message_list_reflect();
		}
	});

}

function sms_message_log_modal(sms_message_id){
	$.post('messages/sms_message_log_modal.php', { sms_message_id : sms_message_id }, function(data){
		$('#div_sms_message_log_content').html(data);
	});
}