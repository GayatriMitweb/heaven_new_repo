<?php include "../../../../../model/model.php"; 
$count=0;
$tourist_id = $_GET['tourist_id'];
 
$traveler_id_arr = array();
$branch_status = $_GET['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$query = "select * from travelers_details where 1 and status='Active' and traveler_id='$tourist_id'";
/*if($tourist_id != ''){
  $query .= " and traveler_id='$tourist_id' ";
}
*/if($branch_status=='yes' && $role=='Branch Admin'){
    $query .=" and branch_admin_id = '$branch_admin_id'";
}
 
$sq = mysql_query($query); 
?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table trable-hover" id="repeated_table" style="margin: 20px 0 !important;">
<thead>
<tr class="table-heading-row">
  <th>Sr._No.</th>
  <th>Passenger_Name</th>
  <th>Birth_Date</th>
  <th>Gender</th>
  <th>Repeated_Count</th>
  <th>Details</th>
</tr>
</thead>
<tbody>
<?php
if($row = mysql_fetch_assoc($sq))
{
  $repeated_count = mysql_num_rows(mysql_query("select traveler_id from travelers_details where first_name='$row[first_name]' and middle_name='$row[middle_name]' and last_name='$row[last_name]' and birth_date='$row[birth_date]' and status='Active' "));

  $sq1 = mysql_query("select * from travelers_details where first_name='$row[first_name]' and middle_name='$row[middle_name]' and last_name='$row[last_name]' and birth_date='$row[birth_date]' and status='Active' ");
  while($row1 = mysql_fetch_assoc($sq1))
  {
    array_push($traveler_id_arr, $row1['traveler_group_id']);
  }
  $traveler_id_arr=implode(",",$traveler_id_arr); 

  ?>
    <tr>
      <td><?php echo $count++; ?></td>
      <td><?php echo $row['first_name']." ".$row['last_name'] ?></td>
      <td><?php echo date("d-m-Y", strtotime($row['birth_date'])); ?></td>
      <td><?php echo $row['gender'] ?></td>
      <td><?php echo $repeated_count ?></td>
      <td><button id="btn_group_id" value="<?php echo $traveler_id_arr ?>" class="btn btn-info btn-sm" onclick="travelers_details(this.id)"><i class="fa fa-eye"></i></button></td>
     </tr>  
  <?php
}

?>  
</tbody>
</table>
</div>  </div> </div>
</div>
<script>
paginate_table(repeated_table);
</script>

<div id="travelr_details_popup"></div>
                     
<script>
  function travelers_details(id)
  {
    var base_url = $('#base_url').val();
    var traveler_group_id = $("#"+id).val();
    $.get(base_url+'view/reports/repeater_tourist_report_filter_popup.php', { traveler_group_id : traveler_group_id }, function(data){
        $('#travelr_details_popup').html(data);
    });
  } 
</script>