<?php
class basic_info_master{
    public function basic_info_save(){
		$p_gateway = json_encode($_POST['p_gateway']);
		$cred_array = json_encode($_POST['cred_array']);
		$sq_settings = mysql_num_rows(mysql_query("select * from b2b_settings_second"));
		if($sq_settings == '0'){
			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_settings_second"));
            $entry_id = $sq_max['max'] + 1;
            $sq_setting = mysql_query("insert into b2b_settings_second ( entry_id, payment_gateway,credentials) values ( '$entry_id', '$p_gateway','$cred_array','$bank_id')");
			if($sq_setting){
				echo "B2B Adavnce settings saved.";
				exit;
			}
			else{
				echo "error--Sorry, Settings are not saved!";
			}
        }else{
            $sq_setting = mysql_query("update b2b_settings_second set payment_gateway = '$p_gateway',credentials='$cred_array' where entry_id='1'");
			if($sq_setting){
				echo "B2B Adavnce settings updated.";
				exit;
			}
			else{
				echo "error--Sorry, Settings are not updated!";
			}
        }
    }
}
?>