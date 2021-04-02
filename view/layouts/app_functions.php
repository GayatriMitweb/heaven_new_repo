<?php
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role']; 
if(isset($_SESSION['username']) && isset($_SESSION['itours_app'])){

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        
        if(empty($_GET)){

            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            
            $role = $_SESSION['role'];
            $role_id = $_SESSION['role_id'];
            $link = explode('view/', $actual_link);
            $link = $link[1];

            if($link!="dashboard/dashboard_main.php" && $link!="reports/reports_homepage.php" && $link!="layouts/reminders_home.php"){
                $access_count = mysql_num_rows( mysql_query("select * from user_assigned_roles where role_id='$role_id' and link='$link'") );
                if($access_count==0){
                  header("location:".BASE_URL);
                }  
                  
            }    

        }   

    }

}
else{
    header("location:".BASE_URL);  
}

function admin_header_scripts(){
    global $circle_logo_url;
?>
    <link rel="icon" href="<?= $circle_logo_url ?>" type="image/gif" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

    <!--========*****Header Stylsheets*****========-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/select2.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.wysiwyg.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.carousel.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-labelauty.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/menu-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/btn-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dynforms.vi.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/notification.php">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
    <?php 
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $link = explode('view/', $actual_link);
    $link = $link[1];
    if($link=="dashboard/dashboard_main.php"){
    ?>
        <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/dashboard.php">
        <?php
    }

    //Including modules css
    $dir_name =  dirname(dirname(dirname(__FILE__))).'/css/app/modules';
    $dir = $dir = new DirectoryIterator($dir_name);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
             ?>
             <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/modules/<?= $fileinfo->getFilename() ?>">   
             <?php
        }
    }
    ?>

    <!--========*****Header Scripts*****========-->
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.mCustomScrollbar.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.wysiwyg.js"></script>  
    <script src="<?php echo BASE_URL ?>js/script.js"></script>
    <script src="<?php echo BASE_URL ?>js/select2.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-labelauty.js"></script>
    <script src="<?php echo BASE_URL ?>js/responsive-tabs.js"></script>
    <script src="<?php echo BASE_URL ?>js/dynforms.vi.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/data_reflect.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/validation.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap-tagsinput.min.js"></script>  

<?php
}
function get_cache_data(){

    if (file_exists(BASE_URL.'view/cache.txt')) {
        $modified_time = filemtime(BASE_URL.'view/cache.txt');
    }else{
        $modified_time = time()-1*86400001;
    }
    $taxes_data = array();
    $taxes_rules_data = array();
    $other_rules_data = array();
    $credit_card_data = array();
    $new_array = array();
    if ($modified_time < time()-1*86400000) {
        
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
        file_put_contents(BASE_URL.'view/cache.txt', serialize(json_encode($new_array)));
        $new_array = json_encode($new_array);
    }
    else {
        $new_array = unserialize(file_get_contents(ROOT_DIR.'\cache_data.txt'));
    }
    return $new_array;
}
function topbar_icon_list()
{
    global $app_version;
    $username = $_SESSION['username'];  
    $login_id = $_SESSION['login_id'];
    $emp_id = $_SESSION['emp_id'];

    $financial_year_id = $_SESSION['financial_year_id']; 

    $sq_finacial_year = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id='$financial_year_id'"));  

    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));

    if($sq_emp['first_name']==''){
        $emp_name = 'Admin';
    }
    else{
        $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name'];
    }
     
    if($sq_emp['photo_upload_url']!=""){
        $newUrl1 = preg_replace('/(\/+)/','/',$sq_emp['photo_upload_url']);
        $user_id = BASE_URL.str_replace('../', '', $newUrl1);
    }
    elseif($sq_emp['first_name']=='' or $sq_emp['first_name']!=''){
        $user_id = BASE_URL.'images/logo-circle.png';
    }
    /////////////////////////////////////Notification Start////////////////////////////////////////////
    $role = $_SESSION['role'];
    $role_id = $_SESSION['role_id'];
    $branch_admin_id = $_SESSION['branch_admin_id'];
    $eq_temp = 0;
    $sq_enquiry_g = mysql_fetch_assoc(mysql_query("select * from generic_count_master"));
    if($role=='Admin'){
        ///////////Enquiry///////////
        $query ="select enquiry_id from enquiry_master where status!='Disabled'";
        $sq_enquiry1 = mysql_query($query);
        while($row_enq = mysql_fetch_assoc($sq_enquiry1)){
            $sq_enquiry_entry = mysql_fetch_assoc(mysql_query("select followup_status from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));
            if($sq_enquiry_entry['followup_status']=="Converted"){
              $eq_temp = $eq_temp + 1;
            }
        }
        //app_setting e_count
        $enq_result = $sq_enquiry_g['a_enquiry_count'];
        $temp_enq = $sq_enquiry_g['a_temp_enq_count'];
        
        $enq_result = $eq_temp - $temp_enq + $enq_result;
        $temp_enq = $eq_temp;
        $sq_log1 = mysql_query("update generic_count_master set a_enquiry_count='$enq_result', a_temp_enq_count ='$temp_enq' where id='1'");

        ///////////////Task///////////////////
        $query = "select * from tasks_master where task_status='Completed'";
        $sq_task = mysql_num_rows(mysql_query($query));
        $task_temp = $sq_task;
        //app_setting e_count
        $task_result = $sq_enquiry_g['a_task_count'];
        $temp_task = $sq_enquiry_g['a_temp_task_count'];
        
        $task_result1 = $task_temp - $temp_task + $task_result;
        $temp_task = $task_temp;
        $final_result = $enq_result + $task_result1;
        if($final_result < 0 ) { $final_result = 0; }
        $sq_log2 = mysql_query("update generic_count_master set a_task_count='$task_result1', a_temp_task_count ='$temp_task' where id='1'");

        ///////////////Leave///////////////////
        $query = "select * from leave_request where status=''";
        $sq_leave = mysql_num_rows(mysql_query($query));
        $leave_temp = $sq_leave;
         //app_setting e_count
        $leave_result = $sq_enquiry_g['a_leave_count'];
        $temp_leave = $sq_enquiry_g['a_temp_leave_count'];
        
        $leave_result1 = $leave_temp- $temp_leave + $leave_result;
        $temp_leave = $leave_temp;
        //echo $leave_temp.'-'.$temp_leave.' +'. $leave_result;

        $final_result = $enq_result +  $task_result1+ $leave_result1;
        if($final_result < 0 ) { $final_result = 0; }
        $sq_log3 = mysql_query("update generic_count_master set a_leave_count='$leave_result1', a_temp_leave_count ='$temp_leave' where id='1'");
    }
    elseif($role=='Branch Admin'){
        $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='attractions_offers_enquiry/enquiry/index.php'"));
        $branch_status = $sq['branch_status'];
        ///////////Enquiry///////////
        $query ="select * from enquiry_master where 1 and status!='Disabled'";
        if($branch_status=='yes'){
            $query .= " and branch_admin_id = '$branch_admin_id'";
        }
        $sq_enquiry = mysql_query($query);
        while($row_enq = mysql_fetch_assoc($sq_enquiry)){
            $sq_enquiry_entry = mysql_fetch_assoc(mysql_query("select followup_status from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]' )"));
            if($sq_enquiry_entry['followup_status']=="Converted"){
               $eq_temp = $eq_temp + 1;
            }
        }
        //app_setting e_count
        $sq_enquiry1= mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
        $enq_result = $sq_enquiry1['enquiry_count'];
        $temp_enq = $sq_enquiry1['temp_enq_count'];

        $enq_result = $eq_temp - $temp_enq + $enq_result;
        $temp_enq = $eq_temp;
        $sq_log = mysql_query("update emp_master set enquiry_count='$enq_result', temp_enq_count ='$temp_enq' where emp_id='$emp_id'");

        // ///////////////Task///////////////////
        $task_result = 0;
        $temp_task = 0;
        $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='tasks/index.php'"));
        $branch_status1 = $sq['branch_status'];
        $query = "select * from tasks_master where task_status='Completed'";
        if($branch_status1=='yes'){
            $query .= " and branch_admin_id = '$branch_admin_id'";
        }
        $sq_task = mysql_num_rows(mysql_query($query));
        $task_temp = $sq_task;
        //app_setting e_count
        $sq_taskc= mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
        $task_result = $sq_taskc['task_count'];
        $temp_task = $sq_taskc['temp_task_count'];

        $task_result1 = $task_temp - $temp_task + $task_result;
        $temp_task1 = $task_temp;
        $final_result = $enq_result + $task_result1;
        if($final_result < '0' ) { $final_result = 0; }
        $sq_log = mysql_query("update emp_master set task_count='$task_result1', temp_task_count ='$temp_task1' where emp_id='$emp_id'");

        /////////Leave////////////////
        $leave_result = 0;
        $temp_leave = 0;
        $q1 = "select x.* from (
            (select * from leave_request where status='' and emp_id in(select emp_id from emp_master where branch_id='$branch_admin_id'))
            UNION ALL
            (SELECT * from leave_request where status!='' and emp_id='$emp_id'))x";
        $sq_leave = mysql_num_rows(mysql_query($q1));
        $leave_temp = $sq_leave;
        //app_setting e_count
        $sq_leavec= mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
        $leave_result = $sq_leavec['leave_count'];
        $temp_leave = $sq_leavec['temp_leave_count'];

        $leave_result1 = $leave_temp - $temp_leave  + $leave_result;
        $temp_leave1 = $leave_temp;
        $final_result = $enq_result + $leave_result1 + $task_result1;

        if($final_result < 0 ) { $final_result = 0; }
        $sq_log = mysql_query("update emp_master set leave_count='$leave_result1', temp_leave_count ='$temp_leave1' where emp_id='$emp_id'");
    }
    else{
        /////////////Enquiry//////////
        $sq_enquiry = mysql_query("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$emp_id' ");

        while($row_enq = mysql_fetch_assoc($sq_enquiry)){
            $eq_temp = $eq_temp + 1;
        }
         //app_setting e_count
        $sq_enquiry2 = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
        $enq_result = $sq_enquiry2['enquiry_count'];
        $temp_enq = $sq_enquiry2['temp_enq_count'];
        
        $enq_result = $eq_temp - $temp_enq + $enq_result;
        $temp_enq = $eq_temp;

        $sq_log = mysql_query("update emp_master set enquiry_count='$enq_result', temp_enq_count ='$temp_enq' where emp_id='$emp_id'");
  
        /////////////Task////////////
        $task_result = 0;
        $temp_task = 0;
        if($role_id==2 || $role_id==3 || $role_id==4 || $role_id==7){
            $sq_task = mysql_num_rows(mysql_query("select * from tasks_master where task_status='Created' and emp_id='$emp_id'"));
        }
        else{
            $sq_task = mysql_num_rows(mysql_query("select * from tasks_master where task_status='Created'"));
        }
        $task_temp = $sq_task;
        //app_setting e_count
        $sq_taskc= mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
        $task_result = $sq_taskc['task_count'];
        $temp_task = $sq_taskc['temp_task_count'];

        $task_result1 = $task_temp - $temp_task + $task_result;
        $temp_task1 = $task_temp;
        $final_result = ($role_id==6 || $role_id==7) ? ($task_result1) : ($enq_result + $task_result1);
        if($final_result < '0' ) { $final_result = 0; }
        $sq_log = mysql_query("update emp_master set task_count='$task_result1', temp_task_count ='$temp_task1' where emp_id='$emp_id'");

        /////////Leave////////////////
        $leave_result = 0;
        $temp_leave = 0;
        $query = "select * from leave_request where 1 ";
        if($role_id==2 || $role_id==3 || $role_id==4 || $role_id==7){
            $query .= " and status!='' and emp_id='$emp_id'";
        }else{
            if($role_id==6){
                $query .= " and status = '' ";
                $query .= " or request_id in(select request_id from leave_request where emp_id='$emp_id' and status!='')";
                if($branch_status1=='yes'){
                    $query .=" and branch_admin_id='$branch_admin_id'";
                }
            }else{
                $query .= " and status !='' and emp_id in(select emp_id from emp_master where branch_id='$branch_admin_id')";
            }
        }
        $sq_leave = mysql_num_rows(mysql_query($query));
        $leave_temp = $sq_leave;
        //app_setting e_count
        $sq_leavee = mysql_query("select * from leave_request where status!='' and emp_id='$emp_id'");
        $sq_leavec= mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
        $leave_result = $sq_leavec['leave_count'];
        $temp_leave = $sq_leavec['temp_leave_count'];

        $leave_result1 = $leave_temp - $temp_leave  + $leave_result;
        $temp_leave1 = $leave_temp;
        $final_result = ($role_id==6 || $role_id==7) ? ($leave_result1 + $task_result1) : ($enq_result + $leave_result1 + $task_result1);
        if($final_result < 0 ) { $final_result = 0; }
        $sq_log = mysql_query("update emp_master set leave_count='$leave_result1', temp_leave_count ='$temp_leave1' where emp_id='$emp_id'");
    }
    ?>
    <input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>">
    <li class="notifications_body">
         <a class="btn app_btn_out" data-toggle="tooltip" title="Dashboard" data-placement="bottom" href="<?php echo BASE_URL ?>view/dashboard/dashboard_main.php"><i class="fa fa-tachometer"></i><pre class="xs_show">Dashboard</pre></a>
    </li>
    <li class="logged_user_body text_center_sm_xs">
        <div class="logged_user" onclick="display_image1()">
            <span class="logged_user_id">
             <img src="<?php echo $user_id ?>" class="img-responsive" ></span>
            <span class="logged_user_name"><?= $emp_name ?></span>
        </div>
        <div id="profile_pic_block_id" class="profile_pic_block">
          <?php include_once("display_image_modal1.php")  ?>
        </div>
    </li>
    <?php if($role_id<9){ ?>
    <li class="notifications_body">
         <a class="btn app_btn_out" data-toggle="tooltip" title="Notifications" data-placement="bottom" onclick="enquiry_count_update('enquiry');display_notification();"><i class="fa fa-bell-o"></i><pre class="xs_show">Notification</pre></a>
    </li>
    <?php } ?>
    <li class="financial_yr">
        <a class="btn app_btn_out" data-toggle="tooltip" title="Financial Year" data-placement="bottom" ><i class="fa fa-code-fork"></i><span class="">&nbsp;&nbsp;<?php echo get_date_user($sq_finacial_year['from_date']).' - '.get_date_user($sq_finacial_year['to_date']); ?></span></a>
    </li>  

    <li>
        <a class="btn app_btn_out" onclick="user_logout()" data-toggle="tooltip" title="Sign out" data-placement="bottom"><i class="fa fa-power-off"></i><pre class="xs_show">Sign Out</pre></a>
        <input type="hidden" id="login_id1" name="login_id1" value="<?= $login_id ?>">   
    </li>
    <?php
}

function fullwidth_header_scripts(){
    global $circle_logo_url;
?>
    <link rel="icon" href="<?= $circle_logo_url ?>" type="image/gif" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--========*****Header Stylsheets*****========-->
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/select2.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.wysiwyg.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-labelauty.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/menu-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/btn-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/notification.php">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/fullwidth_app.php">

    <?php 
    //Including modules css
    $dir_name =  dirname(dirname(dirname(__FILE__))).'/css/app/modules';
    $dir = $dir = new DirectoryIterator($dir_name);
    foreach ($dir as $fileinfo){
        if (!$fileinfo->isDot()){
        ?>
        <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/modules/<?= $fileinfo->getFilename() ?>">   
        <?php
        }
    }
    ?>

    <!--========*****Header Scripts*****========-->
    <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.mCustomScrollbar.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.wysiwyg.js"></script> 
    <script src="<?php echo BASE_URL ?>js/select2.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/responsive-tabs.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery-labelauty.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/data_reflect.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/validation.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap-tagsinput.min.js"></script>  
<?php
}

?>
<div id="div_modal"></div>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
function user_logout(){
    var login_id = $('#login_id1').val();
    var base_url = $('#base_url').val();

    $.post(base_url+'controller/login/user_logout.php', { login_id : login_id }, function(data){
        if(data=="valid"){ 
            localStorage.setItem("reminder", true);       
            window.location.href = base_url+"index.php";
        }
    });
}

function display_image1(){
  $("#profile_pic_block_id").toggleClass('profile_pic_block_display');
}

function display_notification(){
    $("#notification_block_bg_id").toggle();
    $("#notification_block_body_id").slideToggle();
}

function enquiry_count_update(task){
    var base_url = $('#base_url').val();
    $.post(base_url+'controller/login/notification/enquiry_count_update.php', { type : task }, function(data){
        $('#enquiry_count11').html(data);
    });
}

</script>