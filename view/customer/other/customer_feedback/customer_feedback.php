<?php 
include_once('../../../../model/model.php');
include_once('../../layouts/admin_header.php');

$customer_id = $_SESSION['customer_id'];
?>

<!--////////////***************************************Actual Form content start**********************************************/////////////////-->

<div class="app_panel_head main_block" style="border-bottom: 1px solid #dddddd8f;">
      <h2 class="pull-left">Customer Feedback</h2>
</div>
<div class="header_bottom main_block">
  <div class="row mg_tp_10">
      <div class="col-md-12 text-right">
          <button class="btn btn-info btn-sm ico_left" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Feedback</button> 
      </div>
  </div>
</div>

<div id="div_modal" class="customer_feedback main_block"></div>
<div id="div_content" class="customer_feedback main_block"></div>
<div id="div_view" class="customer_feedback main_block"</div>

<?= end_panel() ?>

<script>
    function save_modal()
    {
        $.post('save_modal.php',{}, function(data){
            $('#div_modal').html(data);
        });
    }
    function list_reflect()
    {
        $.post('list_reflect.php',{}, function(data){
            $('#div_content').html(data);
        });
    }
    list_reflect();
    $(function(){
        $('#frm_customer_feedback').validate({
            rules:{
                title:{ required:true },
                feedback:{ required:true },
            },
            submitHandler:function(form){
                var base_url = $('#base_url').val();
                var title = $('#title').val();
                var feedback = $('#feedback').val();
                var customer_id = $('#customer_id').val();

                $.post(base_url+'controller/customer/customer_feedback.php', { customer_id : customer_id, title : title, feedback : feedback }, function(data){
                    reset_form('frm_customer_feedback');
                    msg_alert(data);
                    $('#customer_feedback_modal').modal('hide');
                });
            }
        });
    });
    function view_modal(feedback_id){
        $.post('view/index.php', { feedback_id : feedback_id }, function(data){
            $('#div_view').html(data);
        }); 
    }
   
</script>


<!--////////////***************************************Actual Form content end**********************************************/////////////////-->
<?php 
include_once('../../layouts/admin_footer.php');
?>