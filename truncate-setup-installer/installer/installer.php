<?php
$database_name = $_POST['database_name'];
$username = $_POST['username'];
$password = $_POST['password'];

$conn = new mysqli('localhost', $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table_exclude = array('state_and_cities', 'user_assigned_roles', 'roles', 'role_master', 'travel_station_master', 'bus_master', 'tour_budget_type', 'bank_name_master', 'bank_list_master', 'city_master', 'currency_name_master', 'vendor_type_master', 'estimate_type_master', 'airport_list_master', 'references_master', 'country_state_list', 'country_list_master','email_template_master','gallary_master','destination_master','airline_master','airport_master','visa_crm_master','visa_type_master','sac_master','state_master','generic_count_master','office_expense_type','branch_assign','ledger_master','group_master','head_master','subgroup_master','cms_master','cms_master_entries','fixed_asset_master','app_settings','modulewise_video_master','meal_plan_master','room_category_master','hotel_type_master','b2b_settings','b2b_settings_second','vehicle_type_master','default_package_images','tax_conditions','other_charges_master', 'ticket_master_airfile', 'ticket_entries_airfile', 'ticket_trip_entries_airfile','video_itinerary_master','b2b_transfer_master');

$sq_list_table = $conn->query("show tables");

while($row = $sq_list_table->fetch_assoc()){

	$table_name = $row['Tables_in_'.$database_name];

	if( !in_array($table_name, $table_exclude) ){
		$query = $conn->query("truncate $table_name");	
	}	

}

$query = $conn->query("delete from role_master where role_id not in ('1', '2', '3','4','5','6','7')");
$query = $conn->query("delete from references_master where reference_id not in ('1', '2', '3','4','5','6','7','8')");
$query = $conn->query("delete from roles where id!='1'");
$query = $conn->query("update generic_count_master set a_enquiry_count = '0', a_temp_enq_count='0', a_task_count='0', a_temp_task_count='0', invoice_format='Standard', a_temp_leave_count='0',a_leave_count='0',b_temp_task_count='0',b_task_count='0',b_temp_enq_count='0',b_enquiry_count='0' where id='1'");

$query = $conn->query("delete from office_expense_type where expense_type_id >= '21'");
$query = $conn->query("delete from ledger_master where ledger_id >= '232'");
$query = $conn->query("delete from group_master where group_id >= '22'");
$query = $conn->query("delete from head_master where head_id >= '14'");
$query = $conn->query("delete from subgroup_master where subgroup_id >= '112'");
$query = $conn->query("delete from gallary_master where entry_id >= '759'");
$query = $conn->query("delete from sac_master where entry_id >= '14'");
$query = $conn->query("delete from visa_type_master where entry_id >= '12'");
$query = $conn->query("delete from b2b_transfer_master where entry_id>'5'");

$app_date=date('Y');
$query = $conn->query("update app_settings set app_version = '$app_date' where setting_id='1'");

$conn->close();


function deleteDirectory($dirPath) {
    if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object !="..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
    reset($objects);
    rmdir($dirPath);
    }
}

//Truncate uploads directory
$path = "..".DIRECTORY_SEPARATOR ."..".DIRECTORY_SEPARATOR ."uploads";
$dir = new DirectoryIterator($path);
foreach ($dir as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        $new_dir = $path.DIRECTORY_SEPARATOR.$fileinfo->getFilename();
        deleteDirectory($new_dir);
    }
}
unlink('../../view/cache_data.txt');
echo "All data is truncated";
?>