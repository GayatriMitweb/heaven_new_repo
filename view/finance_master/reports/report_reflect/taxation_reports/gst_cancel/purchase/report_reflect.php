<?php include "../../../../../../../model/model.php";
include_once('../purchase/vendor_generic_functions.php');

$branch_status = $_POST['branch_status'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$taxation_id = '';
$array_s = array();
$temp_arr = array();
$tax_total = 0;
$query = "select * from vendor_estimate where status='Cancel' ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and purchase_date between '$from_date' and '$to_date' ";
}
include "../../../../../../../model/app_settings/branchwise_filteration.php";
$sq_setting = mysql_fetch_assoc(mysql_query("select * from app_settings where setting_id='1'"));

$count = 1;
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	$vendor_name = get_vendor_name($row_query['vendor_type'],$row_query['vendor_type_id']);
	$vendor_info = get_vendor_info($row_query['vendor_type'], $row_query['vendor_type_id']);
	$hsn_code = get_service_info($row_query['estimate_type']);

	$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$vendor_info[state_id]'"));
	$sq_supply = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_setting[state_id]'"));

	//Service tax
	$tax_per = 0;
	$service_tax_amount = 0;
	$tax_name = 'NA';
	if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
		$tax_name = '';
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
			$service_tax = explode(':',$service_tax_subtotal1[$i]);
			$service_tax_amount +=  $service_tax[2];
			$tax_name .= $service_tax[0] . $service_tax[1].' ';
			$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
		}
	}
	//Taxable amount
	$taxable_amount = ($service_tax_amount / $tax_per) * 100;
	$tax_total += $service_tax_amount;
	$temp_arr = array( "data" => array(
		(int)($count++),
		$row_query['estimate_type'] ,
		$hsn_code ,
		$vendor_name ,
		($vendor_info['service_tax'] == '') ? 'NA' : $vendor_info['service_tax'],
		($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
		$row_query['estimate_id'] ,
		get_date_user($row_query['purchase_date']) ,
		($vendor_info['service_tax'] == '') ? 'Unregistered' : 'Registered',
		($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'],
		$row_query['net_total'],
		number_format($taxable_amount,2),
		$tax_name,
		number_format($service_tax_amount,2),
		"0.00" ,
		"0.00",
		'',
		''
		), "bg" =>$bg);
	
	array_push($array_s,$temp_arr);
}
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
	
	'foot0' => 'Total TAX :'.number_format($tax_total,2),
	'col0' => 14,
	'class0' =>"info text-left",

	'foot1' => '',
	'col1' => 1,
	'class1' =>"info text-left",

	'foot2' => '',
	'col2' => 2,
	'class2' =>"info text-left",

	'foot3' => '',
	'col3' => 10,
	'class3' =>"info text-left"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
	