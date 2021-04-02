
<?php
include_once("../../../model/model.php");
$financial_year_id = $_SESSION['financial_year_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
?>
<div class="col-md-12">
<div class="dashboard_table_body main_block">
    <div class="col-md-12 no-pad table_verflow">
    <div class="table-responsive">
        <table class="table table-hover" style="margin: 0 !important;border: 0;">
        <thead>
            <tr class="table-heading-row">
            <th>S_No.</th>
            <th>enquiry_id</th>
            <th>Customer_Name</th>
            <th>Tour_type</th>
            <th>Tour_Name</th>
            <th>Mobile</th>
            <th>Followup_D/T&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Allocate_To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Followup_Type</th>
            <th>History</th>
            <th>Followup_Update</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $count = 0;
            $rightnow = date('Y-m-d');
            $add7days = date('Y-m-d', strtotime('+7 days'));
            $query = "SELECT * FROM `enquiry_master` where status!='Disabled' and financial_year_id='$financial_year_id'";
            $sq_enquiries = mysql_query($query);
            while($row = mysql_fetch_assoc($sq_enquiries)){
                
            $date = $row['enquiry_date'];
            $yr = explode("-", $date);
            $year =$yr[0];
            if($from_date==''){
                $sq_fquery = "select * from enquiry_master_entries where entry_id =(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row[enquiry_id]') and followup_date between '$rightnow' and '$add7days'";
            }
            else{
                $from_date = get_datetime_db($from_date);
                $to_date = get_datetime_db($to_date);
                $sq_fquery = "select * from enquiry_master_entries where entry_id =(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row[enquiry_id]') and followup_date between '$from_date' and '$to_date'";
            }
            $sq3 = mysql_query($sq_fquery);
            while ($row_sq_4=mysql_fetch_assoc($sq3)){
                $count++;
                $assigned_emp_id = $row['assigned_emp_id'];
                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$assigned_emp_id'"));
                $enquiry_content = $row['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    if($enquiry_content_arr2['name']=="tour_name"){ $sq_c['tour_name'] = $enquiry_content_arr2['value']; }
                }
                $status_count = mysql_num_rows(mysql_query("select * from enquiry_master_entries where enquiry_id='$row[enquiry_id]' "));
                if($status_count>0){
                    $enquiry_status = mysql_fetch_assoc(mysql_query("select * from enquiry_master_entries where entry_id=(select max(entry_id) from enquiry_master_entries where enquiry_id='$row[enquiry_id]') "));
                    $bg = ($enquiry_status['followup_status']=='Converted') ? "success" : "";
                    $bg = ($enquiry_status['followup_status']=='Dropped') ? "danger" : $bg;
                    $bg = ($enquiry_status['followup_status']=='Active') ? "warning" : $bg;

                    if($enquiry_status_filter!=""){
                        if($enquiry_status['followup_status']!=$enquiry_status_filter){
                            continue;
                        }
                    }
                }
                else{
                    $bg = "";
                }
                $status_count1 = mysql_num_rows(mysql_query("select * from enquiry_master_entries where enquiry_id='$row[enquiry_id]' and followup_type='' "));
                if($status_count1==1){
                    $followup_date1 = $row['followup_date'];
                }
                else{
                    $enquiry_status1 = mysql_fetch_assoc(mysql_query("select * from enquiry_master_entries where entry_id=(select max(entry_id) from enquiry_master_entries where enquiry_id='$row[enquiry_id]') "));
                    $followup_date1 = $enquiry_status1['followup_date'];
                }
                if($enquiry_status['followup_type']!=''){
                   $status = $enquiry_status['followup_type'];
                   $back_color = 'background: #40dbbc !important';
                }else{
                   $status = 'Not Done';
                   $back_color = 'background: #ffc674 !important';
                }
            ?>
            <tr class="<?= $bg; ?>">
                <td><?php echo $count; ?></td>
                <td><?= get_enquiry_id($row['enquiry_id'],$year) ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo($row['enquiry_type']) ?></td>
                <td><?php echo($sq_c['tour_name']) ?></td>
                <td><?php echo $row['mobile_no']; ?></td>
                <td><?= get_datetime_user($followup_date1); ?></td>
                <td><?php echo $sq_emp['first_name'].' '.$sq_emp['last_name']; ?></td>
                <td><div style='<?=$back_color?>' class="table_side_widget_text widget_blue_text table_status"><?= $status ?></div></td>
                <td><button class="btn btn-info btn-sm" onclick="display_history('<?php echo $row['enquiry_id']; ?>');" title="History" ><i class="fa fa-history"></i></button></td>
                <td><button class="btn btn-info btn-sm" onclick="Followup_update('<?php echo $row['enquiry_id']; ?>');" title="Update Enquiry" target="_blank"><i class="fa fa-reply-all"></i></button></td>
            </tr>
            <?php
                }
            } ?>
        </tbody>
        </table>
    </div> 
    </div>
</div>