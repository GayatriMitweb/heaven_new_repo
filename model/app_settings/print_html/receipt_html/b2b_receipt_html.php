<?php  
//Generic Files
include "../../../model.php"; 
include "../print_functions.php";
require("../../../../classes/convert_amount_to_word.php");

$booking_id = $_GET['booking_id'];
$customer_id = $_GET['customer_id'];
$confirm_by = $_GET['confirm_by'];
$receipt_type = $_GET['receipt_type'];

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
$sq_role = mysql_fetch_assoc(mysql_query("select emp_id from roles where id='$confirm_by'"));

if($confirm_by=='' || $confirm_by==0){
	$booking_by = $app_name;
}
else{
	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$confirm_by'"));
	$booking_by = $sq_emp['first_name'].' '.$sq_emp['last_name'];
}
$sq_count = mysql_num_rows(mysql_query("SELECT * from b2b_payment_master where booking_id='$booking_id' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
if($sq_count>0){
$sq_payment = mysql_query("SELECT * from b2b_payment_master where booking_id='$booking_id' and (clearance_status!='Pending' or clearance_status!='Cancelled')");
    while($row_payment = mysql_fetch_assoc($sq_payment)){

        $amount_in_word = $amount_to_word->convert_number_to_words($row_payment['payment_amount']);
        //Header
        include "standard_header_html.php";
        ?>

        <section class="print_sec_bt_s main_block">
        <!-- invoice_receipt_body_table-->
        <div class="border_block inv_rece_back_detail">
            <div class="row">
            <div class="col-md-4"><p class="border_lt"><span class="font_5">RECEIPT ID : </span><?php echo $row_payment['payment_id']; ?></p></div>
            <div class="col-md-4"><p class="border_lt"><span class="font_5">AMOUNT : </span><?php echo $row_payment['payment_amount']; ?></p></div>
            <div class="col-md-4"><p class="border_lt"><span class="font_5">Date : </span><?php echo get_date_user($row_payment['payment_date']); ?></p></div>
            <div class="col-md-4"><p class="border_lt"><span class="font_5">Payment Mode : </span><?php echo $row_payment['payment_mode']; ?></p></div>
            <div class="col-md-4"><p class="border_lt"><span class="font_5">Cheque No/ID : </span><?php echo ($row_payment['transaction_id']=='')?'NA': $row_payment['transaction_id']; ?></p></div>
            </div>
        </div>
        </section>
        <?php 
        //Footer
        include "generic_footer_html.php"; 
    }?>
    </div>
<?php }
else{ ?>
<h3>No payment done yet....</h3>
<?php } ?>