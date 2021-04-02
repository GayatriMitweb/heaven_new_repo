    <?php
class other_rules_master{
    function save(){

        $rule_for = $_POST['rule_for'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $validity = $_POST['validity'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $ledger = $_POST['ledger'];
        $fee = $_POST['amount'];
        $fee_type = $_POST['amount_in'];
        $travel_type = $_POST['travel_type'];
        $apply_on = $_POST['apply_on'];
        $target_amount = $_POST['target_amount'];
        
        $cond_arr = json_encode($_POST['cond_arr']);

        begin_t();
        $created_at = date('Y-m-d');
        $from_date = get_date_db($from_date);
        $to_date = get_date_db($to_date);

        $sq_max = mysql_fetch_assoc(mysql_query("select max(rule_id) as max from other_master_rules"));
        $rule_id = $sq_max['max'] + 1;
        $sq = mysql_query("INSERT INTO `other_master_rules`(`rule_id`,`rule_for`, `name`,`type`, `validity`, `from_date`, `to_date`, `ledger_id`, `travel_type`,`apply_on`, `fee`,`fee_type`, `target_amount`, `conditions`, `status`,`created_at`) VALUES ('$rule_id','$rule_for','$name','$type','$validity','$from_date','$to_date','$ledger','$travel_type','$apply_on','$fee','$fee_type','$target_amount','$cond_arr','Active','$created_at')");

        if($sq){
            commit_t();
            echo "Other rule saved successfully!";
            exit;
        }else{
            rollback_t();
            echo 'error--Other rule not saved!';
            exit;
        }
    }

    function clone_rule(){
        
        $rule_id = $_POST['rule_id'];
        $cols=array();
        $created_at = date('Y-m-d');

        $result = mysql_query("SHOW COLUMNS FROM other_master_rules"); 
        while ($r=mysql_fetch_assoc($result)) {
            $cols[]= $r["Field"];
        }
        $result = mysql_query("SELECT * FROM other_master_rules WHERE rule_id='$rule_id'");
        while($r=mysql_fetch_array($result)) {

                $insertSQL = "INSERT INTO other_master_rules (".implode(", ",$cols).") VALUES (";
                $count=count($cols);

                foreach($cols as $counter=>$col) {

                    if($col=='rule_id'){
                        $sq_max = mysql_fetch_assoc(mysql_query("select max(rule_id) as max from other_master_rules"));
                        $package_max = $sq_max['max']+1;
                        $insertSQL .= "'".$package_max."'";	
                    }
                    else if($col == 'created_at'){
                        $insertSQL .= "'".$created_at."'";
                    }
                    else{
                        $insertSQL .= "'".$r[$col]."'";
                    }
                    if ($counter<$count-1) {$insertSQL .= ", ";}
                }
                $insertSQL .= ")";
                mysql_query($insertSQL);
        }
        echo "Tax rule copied successfully!";
        exit;
    }

    function update(){
        $rule_id = $_POST['rule_id'];
        
        $rule_for = $_POST['rule_for'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $validity = $_POST['validity'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $ledger = $_POST['ledger'];
        $fee = $_POST['amount'];
        $fee_type = $_POST['amount_in'];
        $travel_type = $_POST['travel_type'];
        $apply_on = $_POST['apply_on'];
        $target_amount = $_POST['target_amount'];
        $status = $_POST['status'];
        
        $cond_arr = json_encode($_POST['cond_arr']);

        begin_t();
        $created_at = date('Y-m-d');
        $from_date = get_date_db($from_date);
        $to_date = get_date_db($to_date);
        
        $sq = mysql_query("update other_master_rules set rule_for='$rule_for',name='$name',validity='$validity',from_date='$from_date',to_date='$to_date',ledger_id='$ledger',travel_type='$travel_type',apply_on='$apply_on',type='$type',fee='$fee',fee_type='$fee_type',target_amount='$target_amount',conditions='$cond_arr',status='$status' where rule_id='$rule_id'");

        if($sq){
            commit_t();
            echo "Other rule updated successfully!";
            exit;
        }else{
            rollback_t();
            echo "error--Other rule not updated!";
            exit;
        }
    }
}