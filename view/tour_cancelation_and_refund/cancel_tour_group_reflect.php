<?php include "../../model/model.php";
$tour_id = $_GET['tour_id'];
$sq =mysql_query("select * from tour_groups where tour_id='$tour_id' ");
if($tour_id!= ''){
?>
<div class="row mg_tp_20"> 
<div class=" col-md-12 no-pad">
<div class="table-responsive">
<table class="table table-bordered table-hover text-center" id="tbl_report_content">
<thead>
<tr class="table-heading-row">
	<th class="text-center">S_No.</th>
	<th class="text-center">From_Date</th>
	<th class="text-center">To_Date</th>
	<th class="text-center">Cancel_Tour</th>
</tr>
<thead>	
<tbody>
<?php
$count=0;
$disabled_count = 0;
while($row=mysql_fetch_assoc($sq))
{
   if($row['status']=="Cancel")
	{
	   $status = "disabled"; 
	   $check = "checked";
	   $disabled_count ++;
	}    
	else
	{
		$status = "";
		$check = "";
	}
  $count++;

  $from_date =get_date_user($row['from_date']);
  $to_date =get_date_user($row['to_date']);

?>


<tr <?php if($status=="disabled"){ ?> class="danger" <?php }?>>
	<td><?php echo $count ?></td>
	<td><?php echo $from_date ?></td>
	<td><?php echo $to_date ?></td>
	<td><input class="css-checkbox" type="checkbox" id="chk_tour_group<?php echo $count ?>" value="<?php echo $row['group_id'] ?>" <?php echo $status." ".$check ?>>   <label for="chk_tour_group<?php echo $count ?>" class="css-label"></label> </td>
</tr>  
<?php
}
?>
<tbody>	
</table> 
</div>
<input type="hidden" id="tour_count" value="<?= $count ?>">
<input type="hidden" id="disabled_count" value="<?= $disabled_count ?>">
	<div class="row text-center mg_tp_20"> <div class="col-md-12">
		<button class="btn btn-danger btn-sm ico_left" id="btn_cancel_tour_group" onclick="cancel_tour_group()"><i class="fa fa-ban"></i>&nbsp;&nbsp;CANCEL TOUR</button>
	</div> </div>
   </div>
</div>  
<?php }?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
$(document).ready(function(){
  $("input[type='radio'], input[type='checkbox']").labelauty({ label: false, maximum_width: "20px" });
});
</script>