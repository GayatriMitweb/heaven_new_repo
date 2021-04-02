<?php
include '../../model/model.php';
$condition = $_POST['condition'];
if($condition == "1"){
    $html = get_states_dropdown();
    echo $html;
}
else if($condition == "5"){
    $html = get_all_suppliers();
    echo $html;
}
else if($condition == "6"){
    $html = get_customer_type_dropdown();
    echo $html;
}
else if($condition == "7"){
    $role = $_SESSION['role'];
    $branch_admin_id = $_SESSION['branch_admin_id'];
    $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='customer_master/index.php'"));
    $branch_status = $sq['branch_status'];
    $html = '<option value=""></option>';
    if($branch_status=='yes' && $role!='Admin'){
        $sq_query = mysql_query("select * from customer_master where active_flag!='Inactive' and branch_admin_id='$branch_admin_id' order by customer_id desc");
        while($row_cust = mysql_fetch_assoc($sq_query))
        { 
            if($row_cust['type']=='Corporate'||$row_cust['type']=='B2B'){ ?>
            <option value="<?php  echo $row_cust['company_name']; ?>"><?php  echo $row_cust['company_name']; ?></option>      
            <?php }
            else{ ?> 
            <option value="<?php  echo $row_cust['first_name'].' '.$row_cust['last_name']; ?>"><?php  echo $row_cust['first_name'].' '.$row_cust['last_name']; ?></option>      
            <?php 
            }
        }
    }
    else{ ?>    
     <?php   $sq_query = mysql_query("select * from customer_master where active_flag!='Inactive' order by customer_id desc");
        while($row_cust = mysql_fetch_assoc($sq_query))
        {
            if($row_cust['type']=='Corporate'||$row_cust['type']=='B2B'){ ?>
            <option value="<?php  echo $row_cust['company_name']; ?>"><?php  echo $row_cust['company_name']; ?></option>      
            <?php }
            else{ ?>
            <option value="<?php  echo $row_cust['first_name'].' '.$row_cust['last_name']; ?>"><?php  echo $row_cust['first_name'].' '.$row_cust['last_name']; ?></option>      
            <?php 
            }
        }
    }
    echo $html;
}
else if($condition == "12"){
    $html = $sq_airline = mysql_query("select * from airline_master where active_flag!='Inactive' order by airline_name asc");
    while($row_airline = mysql_fetch_assoc($sq_airline)){
        ?>
        <option value="<?= $row_airline['airline_name'].' ('.$row_airline['airline_code'].')' ?>"><?= $row_airline['airline_name'].' ('.$row_airline['airline_code'].')' ?></option>
        <?php
    }
    echo $html;
}
?>