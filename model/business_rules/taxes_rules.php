    <?php
class taxes_rules_master{
    function save(){

        $entry_id = $_POST['entry_id'];
        $name = $_POST['name'];
        $validity = $_POST['validity'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $ledger = $_POST['ledger'];
        $travel_type = $_POST['travel_type'];
        $calc_mode = $_POST['calc_mode'];
        $target_amount = $_POST['target_amount'];
        $applicableOn = $_POST['applicableOn'];
        
        $cond_arr = json_encode($_POST['cond_arr']);

        begin_t();
        $created_at = date('Y-m-d');
        $from_date = get_date_db($from_date);
        $to_date = get_date_db($to_date);

        $sq_max = mysql_fetch_assoc(mysql_query("select max(rule_id) as max from tax_master_rules"));
        $rule_id = $sq_max['max'] + 1;
        $sq = mysql_query("INSERT INTO `tax_master_rules`(`rule_id`, `entry_id`, `name`, `validity`, `from_date`, `to_date`, `ledger_id`, `travel_type`, `calculation_mode`, `target_amount`, `conditions`,`applicableOn`,`status`,`created_at`) VALUES ('$rule_id','$entry_id','$name','$validity','$from_date','$to_date','$ledger','$travel_type','$calc_mode','$target_amount','$cond_arr','$applicableOn','Active','$created_at')");

        if($sq){
            commit_t();
            echo "Tax rule saved successfully!";
            exit;
        }else{
            rollback_t();
            echo "error--Tax rule not saved!";
            exit;
        }
    }

    function clone_rule(){
        $rule_id = $_POST['rule_id'];
        $cols=array();
        $created_at = date('Y-m-d');

        $result = mysql_query("SHOW COLUMNS FROM tax_master_rules"); 
        while ($r=mysql_fetch_assoc($result)) {
            $cols[]= $r["Field"];
        }
   
       $result = mysql_query("SELECT * FROM tax_master_rules WHERE rule_id='$rule_id'");
       while($r=mysql_fetch_array($result)) {
   
               $insertSQL = "INSERT INTO tax_master_rules (".implode(", ",$cols).") VALUES (";
               $count=count($cols);
   
               foreach($cols as $counter=>$col) {
   
                   if($col=='rule_id'){
                       $sq_max = mysql_fetch_assoc(mysql_query("select max(rule_id) as max from tax_master_rules"));
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
        $tentry_id = $_POST['tentry_id'];
        
        $name = $_POST['name'];
        $validity = $_POST['validity'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $ledger = $_POST['ledger'];
        $travel_type = $_POST['travel_type'];
        $calc_mode = $_POST['calc_mode'];
        $target_amount = $_POST['target_amount'];
        $applicableOn = $_POST['applicableOn'];
        $status = $_POST['status'];
        
        $cond_arr = json_encode($_POST['cond_arr']);

        begin_t();
        $created_at = date('Y-m-d');
        $from_date = get_date_db($from_date);
        $to_date = get_date_db($to_date);
        
        $sq = mysql_query("UPDATE tax_master_rules set entry_id='$tentry_id',name='$name',validity='$validity',from_date='$from_date',to_date='$to_date',ledger_id='$ledger',travel_type='$travel_type',calculation_mode='$calc_mode',target_amount='$target_amount',applicableOn='$applicableOn',conditions='$cond_arr',status='$status' where rule_id='$rule_id'");

        if($sq){
            commit_t();
            echo "Tax rule updated successfully!";
            exit;
        }else{
            rollback_t();
            echo "error--Tax rule not updated!";
            exit;
        }
    }
}