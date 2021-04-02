/////////////********** Refund Canceled traveler save start**********************************************************************
$(function(){
    $('#frm_traveler_refund').validate({
        rules:{
                txt_unique_timestamp : { required: true },
                txt_tourwise_traveler_id : { required: true },
                txt_total_refund_cost_c : { required: true, number:true },
                cmb_refund_mode : { required: true },
                refund_date : { required : true },
                bank_name : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
                transaction_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
                bank_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
                traveler_id : { required: true },
        },
        submitHandler:function(form){
              var unique_timestamp = $('#txt_unique_timestamp').val();
              var base_url = $('#base_url').val();
              var tourwise_id = $('#txt_tourwise_traveler_id').val();

              var total_refund = $("#txt_total_refund_cost_c").val();
              var refund_mode = $("#cmb_refund_mode").val();
              var refund_date = $('#refund_date').val();
              var transaction_id = $('#transaction_id').val();
              var bank_name = $('#bank_name').val();
              var bank_id = $('#bank_id').val();
              var remaining = $('#remaining').val();
              
              var traveler_id_arr = $("#traveler_id").val();

              var traveler_count = $("#traveler_id :selected").length;  
              if(traveler_count==0) { alert('Please select at least one traveler.'); return false; }  
              if(typeof($("#ref_amt")) != "undefined" && (Number($("#ref_amt").val()) ==  Number($('#refund_amount').val()))){
                error_msg_alert("Refund Already Fully Paid"); return false;
              }
              else if(Number(total_refund) > Number(remaining))
              { error_msg_alert("Amount can not be greater than total refund amount"); return false; }

              $('#group_refund').button('loading');
              $.post(base_url+'controller/group_tour/traveler_cancelation_and_refund/refund_canceled_traveler_save_c.php', { unique_timestamp : unique_timestamp, tourwise_id : tourwise_id, total_refund : total_refund, refund_mode : refund_mode, refund_date : refund_date, transaction_id : transaction_id, bank_name : bank_name, bank_id : bank_id, 'traveler_id_arr[]' : traveler_id_arr }, function(data) {
                  msg_alert(data);
                  reset_form('frm_traveler_refund');
                  $.post('refund_canceled_traveler_summary_tbl.php', { cmb_tourwise_traveler_id : tourwise_id }, function(data) {
                      $('#refund_canceled_traveler_summary_tbl').html(data);
                      $('#group_refund').button('reset');
                  });
              } );

        }

    });

});
/////////////********** Refund Canceled traveler save end**********************************************************************