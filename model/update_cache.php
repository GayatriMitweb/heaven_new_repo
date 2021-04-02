<?php
include 'model.php';
define('ROOT_DIR', realpath(__DIR__.'/..'));
$taxes_data = array();
$taxes_rules_data = array();
$other_rules_data = array();
$credit_card_data = array();
$new_array = array();

//Taxes
$result = mysql_query("SELECT * FROM tax_master");
while($row = mysql_fetch_array($result)) {
    $temp_array = array(
        'entry_id' => $row['entry_id'],
        'name' => $row['name'],
        'rate_in' => $row['rate_in'],
        'rate' => $row['rate'],
        'status' => $row['status']
    );
    array_push($taxes_data,$temp_array);
}
//Tax Rules
$result = mysql_query("SELECT * FROM tax_master_rules");
while($row = mysql_fetch_array($result)) {
    $temp_array = array(
        'rule_id' => $row['rule_id'],
        'entry_id' => $row['entry_id'],
        'name' => $row['name'],
        'validity' => $row['validity'],
        'from_date' => $row['from_date'],
        'to_date' => $row['to_date'],
        'ledger_id' => $row['ledger_id'],
        'travel_type' => $row['travel_type'],
        'calculation_mode' => json_encode($row['calculation_mode']),
        'target_amount' => $row['target_amount'],
        'applicableOn' => $row['applicableOn'],
        'conditions' => $row['conditions'],
        'status' => $row['status']
    );
    array_push($taxes_rules_data,$temp_array);
}

//Other Rules
$result = mysql_query("SELECT * FROM other_master_rules");
while($row = mysql_fetch_array($result)) {
    $temp_array = array(
        'rule_id' => $row['rule_id'],
        'rule_for' => $row['rule_for'],
        'name' => $row['name'],
        'type' => $row['type'],
        'validity' => $row['validity'],
        'from_date' => $row['from_date'],
        'to_date' => $row['to_date'],
        'ledger_id' => $row['ledger_id'],
        'travel_type' => $row['travel_type'],
        'fee' => $row['fee'],
        'fee_type' => $row['fee_type'],
        'target_amount' => $row['target_amount'],
        'conditions' => $row['conditions'],
        'status' => $row['status'],
        'apply_on'=>$row['apply_on']
    );
    array_push($other_rules_data,$temp_array);
}

//Credit card company
$result = mysql_query("SELECT * FROM credit_card_company where status='Active'");
while($row = mysql_fetch_array($result)) {
    $temp_array = array(
        'entry_id' => $row['entry_id'],
        'company_name' => $row['company_name'],
        'charges_in' => $row['charges_in'],
        'credit_card_charges' => $row['credit_card_charges'],
        'tax_charges_in' => $row['tax_charges_in'],
        'tax_on_credit_card_charges' => $row['tax_on_credit_card_charges'],
        'membership_details_arr' => json_encode($row['membership_details_arr']),
        'status' => $row['status']
    );
    array_push($credit_card_data,$temp_array);
}

array_push($new_array,array('taxes'=>$taxes_data,'tax_rules'=>$taxes_rules_data,'other_rules'=>$other_rules_data,'credit_card_data'=>$credit_card_data));

// store query result in cache_data.txt
$path = getcwd();
$path = explode('model',$path);
file_put_contents($path[0].'view/cache_data.txt', serialize(json_encode($new_array)));
$new_array = json_encode($new_array);

echo $new_array;
?>