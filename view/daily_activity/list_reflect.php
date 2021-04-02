<?php 
include "../../model/model.php";
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];


$query = "select * from daily_activity where 1 ";
if($from_date!="" && $to_date !=''){
  $from_date = date('Y-m-d',strtotime($from_date));
  $to_date = date('Y-m-d',strtotime($to_date));
  $query .=" and activity_date between '$from_date' and '$to_date'  ";
}
?>
  
    <table class="table table-hover mg_bt_10" id="acitvity_table" cellspacing="0" style="margin: 20px 0 !important;">
      <thead>
        <tr class="active table-heading-row">
          <th>S_No.</th>
          <th>User_Name</th>
          <th>Date</th>
          <th>Activity_type</th>
          <th>Time_taken</th>
          <th>Description</th>
        </tr>  
      </thead>  
      <tbody>
        <?php
        $count=0;
        $sq = mysql_query($query);
        while($row=mysql_fetch_assoc($sq))
        {
          $sq_emp  = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row[emp_id]'"));
          $count++;
         ?>
         <tr>
            <td><?php echo $count ?></td>
            <td><?= $sq_emp['first_name'].' '.$sq_emp['last_name']?></td>
            <td><?php echo date('d-m-Y',strtotime($row['activity_date'])); ?></td>
            <td><?php echo $row['activity_type']; ?></td>
            <td><?php echo $row['time_taken']; ?></td>
            <td><?php echo $row['description']; ?></td>
         </tr> 
         <?php 
        }  
        ?>
      </tbody>  
    </table>  
<script type="text/javascript">
 $('#acitvity_table').dataTable({
    "pagingType": "full_numbers"
  });
</script>