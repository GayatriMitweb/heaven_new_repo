<?php include "../../../../../model/model.php"; ?>

<div id="app_report_content_parrent">
  <table class="table table-bordered" id="tbl_supplier_list" style="margin: 0 0 !important;">

      <thead>

        <tr class="table-heading-row">

          <th></th>

          <th>Supplier_Name</th>

          <th>Topup_Amount</th>

          <th>Balance_Amount</th>

        </tr>

      </thead>

      <tbody>

          <?php 

          $topup_amount = 0;

          $count = 0;

          $total_balance_amount = 0;

          $total_topup = 0;

          $sq_query = mysql_query("select * from ticket_vendor ");



                while($row_query = mysql_fetch_assoc($sq_query))

                {

                  $count++;

                                 

                    $sq_supplier = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as total_amount from flight_supplier_payment where supplier_id='$row_query[vendor_id]' and (clearance_status!='Pending' and clearance_status!='Cancelled')"));

                    if ($sq_supplier['total_amount']!=0) {

                    $topup_amount = $sq_supplier['total_amount'];

                    $sq_q1 = mysql_fetch_assoc(mysql_query("select sum(net_total) as total_booking from vendor_estimate where vendor_type_id='$row_query[vendor_id]' and vendor_type='Ticket Vendor'"));

                    $sq_q2 = mysql_fetch_assoc(mysql_query("select sum(refund_net_total) as cancel_booking from vendor_estimate where vendor_type_id='$row_query[vendor_id]' and vendor_type='Ticket Vendor'"));



                    $booking_amount = $sq_q1['total_booking'] - $sq_q2['cancel_booking'];
                    $balance_amount = $topup_amount - $booking_amount;
                    $total_topup = $total_topup + $topup_amount;
                    $total_balance_amount = $total_balance_amount + $balance_amount;
                    ?>



        <tr>

                    <td>
                      <label class="tbl_radio_btn_body">
                        <input type="radio" id="report_name_rd_c" name="report_name_rd_c" onclick="display_airline_summary(<?php echo $row_query['vendor_id']; ?>);">
                         <span class="tbl_radio_btn" id="radio_span"><i class="fa fa-check"></i></span>&nbsp;&nbsp;
                      </label>
                     
                    </td>
                    <td><?php echo $row_query['vendor_name']; ?></td>

                    <td><?php echo number_format($topup_amount,2); ?></td>

                    <td><?php echo number_format($balance_amount,2); ?></td>



        </tr>
         
         <?php
                    }
                }

          ?>


      </tbody>

      <tfoot>

        <tr class="active">

          <th></th>

          <th></th>

          <th><?php echo "Total Topup : ".number_format($total_topup,2); ?></th>

          <th><?php echo "Total Balance : ".number_format($total_balance_amount,2); ?></th>

        </tr>

      </tfoot>

    </table>
</div>
    <div id="app_report_content_s"></div>
<script type="text/javascript">
  $('input').click(function () {
        $('input:not(:checked)').parent().removeClass("tbl_span_check");
        $('input:checked').parent().addClass("tbl_span_check");
    });

function display_airline_summary(supplier_id)
{
  $.get( "reports_content/group_tour/display_airline_summary_report/display_airline_summary_report.php" , { supplier_id : supplier_id } , function ( data ) {
          $ ("#app_report_content_s").html( data ) ;
  } ) ; 
}
</script>
