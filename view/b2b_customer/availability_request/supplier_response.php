<?php
include "../../../model/model.php";
$request_id = base64_decode($_GET['request_id']);
$hotel_id = base64_decode($_GET['hotel_id']);
$sq_req = mysql_fetch_assoc(mysql_query("select response,response_received from hotel_availability_request where request_id='$request_id'"));
$response = ($sq_req['response'] == "") ? json_encode(array()) : $sq_req['response'];
$response_received = ($sq_req['response_received'] == "") ? json_encode(array()) : $sq_req['response_received'];
?>
<head>

	<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

    <!--========*****Header Stylsheets*****========-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/select2.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.wysiwyg.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.carousel.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-labelauty.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/menu-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/btn-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dynforms.vi.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
            
	<link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.mCustomScrollbar.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.wysiwyg.js"></script> 
    <script src="<?php echo BASE_URL ?>js/script.js"></script>
    <script src="<?php echo BASE_URL ?>js/select2.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-labelauty.js"></script>
    <script src="<?php echo BASE_URL ?>js/responsive-tabs.js"></script>
    <script src="<?php echo BASE_URL ?>js/dynforms.vi.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/data_reflect.js"></script>
    <script src="<?php echo BASE_URL ?>js/app/validation.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap-tagsinput.min.js"></script>  

</head>
<div class="modal fade" id="ressave_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document" style="width:65%">
    <div class="modal-content">
      <div class="modal-header">
		   
	  	<h4 class="modal-title" id="myModalLabel">Hotel Availabilty Response</h4>
		  </div>
      <div class="modal-body" style='padding:10px !important;'>
        <section id="sec_ticket_save" name="">

            <form id="formresponse">
                <div class="row mg_tp_10">
                    <div class="col-md-12 col-sm-12 mg_tp_20 text-center">
                        <input class="btn-radio" type="radio" id="available" name="status" value='Available'> <label for="available">Available</label>&nbsp;&nbsp;&nbsp;
                        <input class="btn-radio" type="radio" id="notavailable" name="status" value='Not Available'> <label for="notavailable">Not Available</label>
                    </div>
                    <div class="col-md-4 col-sm-6 mg_tp_20">
                        <input type="text" id="confirmation_no" name="confirmation_no" placeholder="Hotel Confirmation No" />
                    </div>
                    <div class="col-md-4 col-sm-6 mg_tp_20">
                        <input type="text" id="updated_by" name="updated_by" placeholder="*Updated By" required/>
                    </div>
                    <div class="col-md-4 col-sm-6 mg_tp_20">
                        <textarea class="form-control" type="text" id="note" name="note" placeholder="Note" title="Note" data-toggle="tooltip" rows="1"></textarea>
                    </div>
                </div>
                <div class="row mg_tp_20 text-center">
                    <div class="col-xs-12">
                    <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
                    </div>
                </div>

                <input type="hidden" id="request_id" value="<?= $request_id ?>"/>
                <input type="hidden" id="hotel_id" value="<?= $hotel_id ?>"/>
                <input type="hidden" id="response" value='<?= $response ?>'/>
                <input type="hidden" id="response_received" value='<?= $response_received ?>'/>
                
            </form>   
		</section>
      </div>  
    </div>
  </div>
</div>
<div id="site_alert"></div>

<script>
$('#ressave_modal').modal('show');
$(function(){
    $('#formresponse').validate({
        rules:{
        },
        submitHandler:function(form){
        var base_url = $('#base_url').val();
        var hotel_id = $('#hotel_id').val();
        var request_id = $('#request_id').val();
        var response_received = [];
        response_received = JSON.parse($('#response_received').val());
        
        if(response_received.length !== 0 && response_received.includes(hotel_id)){
          error_msg_alert("Hotel Availability Status already saved. Please email in case any change.");
          return false;
        }else{
          response_received.push(hotel_id);
        }
        var response = JSON.parse($('#response').val());
        var note = $('#note').val();
        var updated_by = $('#updated_by').val();
        var confirmation_no = $('#confirmation_no').val();
        var check_status = [];
        var response_arr = [];

        $('input[name="status"]:checked').each(function () {
            check_status.push($(this).val());
        });
        if(check_status.length==0){
            error_msg_alert('Please select hotel availability status!');
            return false;
        }

        response_arr.push({
        'id':hotel_id,
        'status':check_status[0],
        'options':[],
        'note':note,
        'updated_by':updated_by,
        'confirmation_no':confirmation_no
        });
        const final_result = (response === null) ? response_arr : [...response, ...response_arr];
        $('#btn_save').button('loading');
        $.ajax({
        type:'post',
        url: '../../../controller/b2b_customer/availability_request/supplier_response.php',
        data:{ hotel_id : hotel_id,request_id : request_id, response_arr : final_result,aresponse : response_arr,response_received:response_received},
        success: function(message){
            var message1 = message.trim();
            if(message1[0] == 'error'){
              error_msg_alert(message1[1]);
              $('#btn_save').button('reset');
            }
            else{
              success_msg_alert(message);
              $('#ressave_modal').modal('hide');
              setInterval(() => {
                window.close();
              },2500);
            }
        }
        });
    }
    });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>