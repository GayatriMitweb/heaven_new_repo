<?php 
include "../../../model/model.php";
$booking_id = $_POST['id'];
$tour_type = $_POST['tour_type'];
$contact_no = $_POST['contact_no'];
$emp_id = $_POST['emp_id'];
$name = $_POST['name'];

global $encrypt_decrypt, $secret_key;
$contact_no = $encrypt_decrypt->fnDecrypt($contact_no, $secret_key);

$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
?>

<div class="modal fade profile_box_modal" id="view_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Client Feedback</h4>
         </div>
        <div class="modal-body profile_box_padding">
        <form id="frm_emquiry_save">
            <input type="hidden" id="booking_id" name="booking_id" value="<?= $booking_id ?>">
            <input type="hidden" id="mobile_no" name="mobile_no" value="<?= $contact_no ?>">
            <input type="hidden" id="tour_type" name="tour_type" value="<?= $tour_type ?>">
            <input type="hidden" id="name" name="name" value="<?= $name ?>">
            <div class="row mg_bt_20">
            <div class="col-md-12 col-sm-6 mg_bt_10_sm_xs">
                <h3 class="editor_title">Draft</h3>
                <textarea class="feature_editor" id="draft" name="draft" placeholder="draft" title="draft" rows="4"></textarea>
            </div> 
            </div>
            <div class="row text-center mg_tp_20">
              <div class="col-md-12">
                <button class="btn btn-success" id="btn_form_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>  
              </div>             
            </div>
        </form>
        <div>
    </div>
  </div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#view_modal').modal('show');
$(function(){
$('#frm_emquiry_save').validate({
  rules:{
    draft : { draft : true },
  },
  submitHandler:function(form){
    var base_url = $('#base_url').val();
    var draft = $('#draft').val();
    var enquiry_id = $('#booking_id').val();
    var mobile_no = $('#mobile_no').val();
  
    $('#btn_form_send').button('loading'); 
    $.ajax({
      type:'post',
      url: base_url+'controller/dashboard_sms_send.php',
      data:{ draft : draft,enquiry_id : enquiry_id,mobile_no : mobile_no},
      success: function(message){
          msg_alert(message);
          $('#btn_form_send').button('reset'); 
          $('#view_modal').modal('hide');               
      }  
    });
    web_whatsapp_open(mobile_no);
  }
});
});
function web_whatsapp_open(mobile_no){
  var name = $('#name').val();
  var link = 'https://web.whatsapp.com/send?phone='+mobile_no+'&text=Hello%20Dear%20'+encodeURI(name)+',%0aWe%20hope%20that%20you%20are%20enjoying%20your%20trip.%20It%20will%20be%20a%20great%20source%20of%20input%20from%20you,%20if%20you%20can%20share%20your%20tour%20feedback%20with%20us,%20so%20that%20we%20can%20serve%20you%20even%20better.%0aThank%20you.';
  window.open(link);
}
</script>