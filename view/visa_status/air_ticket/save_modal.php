<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<!-- Save Modal -->
<div class="modal fade" id="send_modal1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Visa Status</h4>
      </div>
      <div class="modal-body">
        <form id="frm_air_send">
            <div class="row mg_bt_20">             
            <input type="hidden" name="booking_type" id="booking_type" value="flight_booking"/>
              <div class="col-sm-4">
                    <select name="flight_id_filter" id="flight_id_filter" style="width:100%" title="Booking ID" onchange="load_passenger(this.id,'flight_booking','flight_status_div')">
                      <option value="">*Booking ID</option>
                      <?php
                      $query = "select * from ticket_master where 1";
                      if($branch_status=='yes' && $role!='Admin'){ 
                        $query .= " and branch_admin_id = '$branch_admin_id'";
                        } 
                      $query .= " order by ticket_id desc";
                      $sq_ticket = mysql_query($query);
                      while($row_ticket = mysql_fetch_assoc($sq_ticket)){
                        $booking_date = $row_ticket['created_at'];
                        $yr = explode("-", $booking_date);
                        $year =$yr[0];
                        $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
                        ?>
                        <option value="<?= $row_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($row_ticket['ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
              </div>
              <div class="col-sm-4">
                <select id="cmb_traveler_id3" name="cmb_traveler_id" title="Passenger Name" style="width:100%;" title="Passenger" onchange="load_visa_status(this.id,'2')">
                    <option value="">*Passenger Name</option>
                </select>
              </div>
              <div class="col-md-4">
                  <select id="doc_status2" name="doc_status2" title="Select Status" class="form-control" style="width: 100%">
                    <option value="">*Select Status</option>
                  </select>
              </div>
          </div>
          <div class="row mg_tp_20">
              <div class="col-md-12">
              <h3 class="editor_title">Description</h3>
                 <textarea name="comment" placeholder="Description" title="Description" id="comment" class="feature_editor form-control" style="width: 100%"></textarea>
              </div>
          </div>
          <div class="row mg_tp_20 text-center">
              <div class="col-md-4 col-md-offset-4">
               <button id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
              </div>
          </div>
        </form>
      </div>
</div>
</div>
</div>

<div id="flight_status_div" class="main_block"></div>

<script>
$('#send_modal1').modal('show');
$('#cmb_traveler_id3,#flight_id_filter').select2();
$(function(){
  $('#frm_air_send').validate({
    rules:{
            flight_id_filter:{ required:true },
            cmb_traveler_id : { required:true },
            doc_status2 : { required:true },
    },

    submitHandler:function(form){    
    var booking_type = $('#booking_type').val();
    var doc_status = $('#doc_status2').val();
    var traveler_id = $('#cmb_traveler_id3').val();
    var visa_id = $('#flight_id_filter').val();
    var comment = $('#comment').val();

    $('#btn_save').button('loading');

    $.ajax({
      type: 'post',
      url: base_url()+'controller/visa_status/visa_status_save.php',
      data:{ booking_type : booking_type, doc_status : doc_status, traveler_id :traveler_id,booking_id : visa_id,comment : comment},
      success: function(result){
        $('#send_modal1').modal('hide');
        $('#btn_save').button('reset');
        reset_form('frm_air_send');
        msg_alert(result);
      }
    });
   }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>