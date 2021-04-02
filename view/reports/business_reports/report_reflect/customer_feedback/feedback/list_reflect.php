
<?php 
include "../../../../model/model.php";
$customer_id = $_GET['customer_id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

$query = "select * from customer_feedback_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($from_date!='' && $to_date!=''){
	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));

	$query .=" and created_at between '$from_date' and '$to_date'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
    
    <table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
        <thead>
            <tr class="table-heading-row">
                <th>S_No.</th>
                <th>Customer_Name</th>
                <th>CSAT</th> 
                <th>Experience</th>
                <th>Courtesy_Friendliness</th>
                <th>Communication_Skill</th>
                <th>Comments</th>
                <th>Satisfied_with_queries</th>
                <th>Comment_on_services</th>
                <th>Feedback_Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0; 
            $sq = mysql_query($query);
            while($row = mysql_fetch_assoc($sq)){
                $sq_query_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id ='$row[customer_id]'")); 
            ?>
                <tr>
                    <td><?= ++$count ?></td>
                    <td><?= $sq_query_cust['first_name'].' '.$sq_query_cust['last_name'] ?></td>
                    <td><?= $row['satisfaction_level'] ?></td>
                    <td><?= $row['knowledge_of_travel_products'] ?></td>
                    <td><?= $row['courtsey'] ?></td>
                    <td><?= $row['communication_skills'] ?></td>
                    <td><?= $row['comments'] ?></td>
                    <td><?= $row['satified_with_queries'] ?></td>
                    <td><?= $row['comment_on_services'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>                    
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

</div> </div> </div>
<script>
$('#tbl_list').dataTable({"pagingType": "full_numbers"});
</script>
