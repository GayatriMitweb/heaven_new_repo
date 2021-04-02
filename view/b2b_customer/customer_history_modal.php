<?php
include "../../model/model.php";

$customer_id = $_POST['customer_id'];
?>
<div class="modal fade" id="customer_history_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Outstanding Summary</h4>
      </div>
      <div class="modal-body">
  
        <form id="frm_customer_history">
          <input type="hidden" id="customer_id" name="customer_id" value="<?= $customer_id ?>">
          <div class="col-md-4 col-sm-6 col-xs-12 col-md-offset-2 mg_bt_10">
            <input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date">
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date">
          </div>

        <div class="row text-center">
          <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="btn_history"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button>
          </div>
        </div>

        </form>

      </div>     
    </div>
  </div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
  $('#customer_history_modal').modal('show');
  $('#from_date,#to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
  $(function(){

	$('#frm_customer_history').validate({
	  rules:{
	      from_date : { required : true },
        to_date : { required : true },
	  },
	  submitHandler:function(form){

	  	  var customer_id = $('#customer_id').val();
	      var from_date = $('#from_date').val();
	      var to_date = $('#to_date').val();
        var base_url = $('#base_url').val();
        $('#btn_history').button('loading');
	      
	      $.ajax({
	        type: 'post',
	        url: base_url+'view/customer_master/customer_history_print.php',
	        data:{ customer_id : customer_id, from_date : from_date, to_date : to_date },
	        success: function(result){
            msg_alert(result);
	          $('#customer_history_modal').modal('hide');
	        }
	      });
	  }
	});

  });
</script>