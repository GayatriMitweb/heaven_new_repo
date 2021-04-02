<?php
include "../../../model/model.php";

$payment_id = $_POST['payment_id'];

$sq_payment = mysql_fetch_assoc(mysql_query("select * from package_payment_master where payment_id='$payment_id'"));
$sq_tour = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$sq_payment[booking_id]'"));
$date = $sq_tour['booking_date'];
$yr = explode("-", $date);
$year =$yr[0];
$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_tour[customer_id]'"));

$bank_detail_state = ($sq_payment['payment_mode']=="Cash" || $sq_payment['payment_mode']=="Credit Note" || $sq_payment['payment_mode']=="Credit Card") ? "disabled" : "";

$travel_state = ($sq_payment['payment_for']=="Tour") ? "disabled" : "";
// 
?>

<input type="hidden" id="payment_id" name="payment_id" value="<?= $payment_id ?>">
<input type="hidden" id="payment_old_value" name="payment_old_value" value="<?php echo $sq_payment['amount'] ?>">



<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Receipt</h4>

      </div>

      <div class="modal-body">

        

        <form id="frm_update_payment">    

                

            <div class="row mg_bt_10">

                <div class="col-md-4">

                    <select id="booking_id" name="booking_id" style="width:100%" title="Booking ID" disabled>
                         <?php
                         if($sq_cust['type'] == 'Corporate'){ ?>
                           <option value="<?= $sq_payment['booking_id'] ?>"><?= get_package_booking_id($sq_payment['booking_id'],$year) .':'. $sq_cust['company_name'] ?></option>
                         <?php }else{ ?> 
                           <option value="<?= $sq_payment['booking_id'] ?>"><?= get_package_booking_id($sq_payment['booking_id'],$year) .':'. $sq_cust['first_name'].' '.$sq_cust['last_name'] ?></option>
                           <?php } ?>     
                        <?php get_package_booking_dropdown() ?>

                    </select>

                </div>

                <div class="col-md-4">

                    <input class="form-control" id="txt_payment_date" title="Payment Date" name="txt_payment_date" placeholder="*Date" value="<?php echo date("d-m-Y", strtotime($sq_payment['date'])) ?>" readonly />

                </div>    

                <div class="col-md-4">

                    <select class="form-control" id="cmb_payment_mode" title="Mode" disabled required onchange="payment_installment_enable_disable_fields()">

                        <option value="<?php echo $sq_payment['payment_mode'] ?>"><?php echo $sq_payment['payment_mode'] ?></option>

                        <?php get_payment_mode_dropdown() ?>

                    </select>

                </div>                    

            </div>



            <div class="row mg_bt_10">         

                <div class="col-md-4">

                    <input class="form-control" type="text" id="txt_amount" title="Amount" name="txt_amount" placeholder="Amount" onchange="validate_balance(this.id);get_credit_card_charges('identifier','cmb_payment_mode','txt_amount','credit_card_details1','credit_charges1');" value="<?php echo $sq_payment['amount'] ?>"/>

                </div>                  

                <div class="col-md-4">

                    <input class="form-control bank_suggest" type="text" id="txt_bank_name" title="Bank Name" name="txt_bank_name" placeholder="Bank Name" value="<?php echo $sq_payment['bank_name'] ?>" <?= $bank_detail_state ?> />

                </div>

                <div class="col-md-4">

                    <input class="form-control" type="text" id="txt_transaction_id"  name="txt_transaction_id" placeholder="Cheque No/ID" title="Cheque No / ID" onchange="validate_specialChar(this.id)" value="<?php echo $sq_payment['transaction_id'] ?>" <?= $bank_detail_state ?> />

                </div>                    

            </div>



            <div class="row">

              <!-- <div class="col-md-4">

                    <select class="form-control" id="cmb_payment_of_type" title="Receipt For" name="cmb_payment_of_type" required onchange="payment_installment_enable_disable_fields1(this.id)">

                        <option value="<?php echo $sq_payment['payment_for'] ?>"><?php echo $sq_payment['payment_for'] ?></option>

                        <option value="">Pay for</option>

                        <option value="Tour">Tour</option>

                        <option value="Travelling"> Travelling </option>                            

                    </select>

              </div>                     -->

              <!-- <div class="col-md-4">

                    <select class="form-control" id="cmb_travel_of_type" title="Type" name="cmb_travel_of_type" required <?= $travel_state ?>>

                    <?php if($sq_payment['travel_type'] != ''){ ?> }

                        <option value="<?php echo $sq_payment['travel_type'] ?>"><?php echo $sq_payment['travel_type'] ?></option>

                        <?php } ?>

                        <option value="">Travelling Type</option>

                        <option value="All"> All </option>
                        <option value="Train">Train</option>
                        <option value="Flight"> Flight </option>   
                        <option value="Cruise"> Cruise </option>                           

                    </select>     

                </div>   -->

                <div class="col-md-4">

                    <select name="bank_id" title="Bank Name" id="bank_id" <?= $bank_detail_state ?> disabled >

                    <?php 
                    if($sq_payment['bank_id'] != '0'){
                    $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment[bank_id]'"));
                    ?>
                    <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                    <?php } ?>
                    <?php get_bank_dropdown(); ?>

                    </select>

                </div>
                <?php if($sq_payment['payment_mode'] == 'Credit Card'){?>
                <!-- <div class="row mg_tp_10"> -->
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <input type="text" id="credit_charges1" name="credit_charges1" title="Credit card charges" value="<?=$sq_payment['credit_charges']?>" disabled>
                    <input type="hidden" id="credit_charges_old" name="credit_charges_old" title="Credit card charges" value="<?=$sq_payment['credit_charges']?>" disabled>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <input class="text" type="text" id="credit_card_details1" name="credit_card_details1" title="Credit card details"  value="<?= $sq_payment['credit_card_details'] ?>" disabled>
                  </div>
                <!-- </div> -->
                <?php } ?>

            </div>


            


            <div class="row text-center mg_tp_20">

                <div class="col-md-12">

                  <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>      

                </div>

            </div>



        </form>



        

      </div>

    </div>

  </div>

</div>



<script>

$('#booking_id').select2();

$( "#txt_payment_date" ).datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#update_modal').modal('show');



$('#frm_update_payment').validate({

  rules:{

          txt_payment_date:{ required : true },

          cmb_payment_mode:{ required : true },

          txt_amount:{ required : true },



          txt_bank_name : { required : function(){  if($('#cmb_payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },

          txt_transaction_id : { required : function(){  if($('#cmb_payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     

          bank_id : { required : function(){  if($('#cmb_payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },          

  },

  submitHandler:function(form){



      var payment_id = $('#payment_id').val();

      var booking_id = $('#booking_id').val();

      var payment_date = $("#txt_payment_date").val();   

      var payment_mode = $("#cmb_payment_mode").val();

      var payment_amount = $("#txt_amount").val();  

      var bank_name = $("#txt_bank_name").val();

      var transaction_id = $("#txt_transaction_id").val();  

      var payment_for = $("#cmb_payment_of_type").val(); 

      var p_travel_type = $("#cmb_travel_of_type").val();

      var bank_id = $('#bank_id').val();
      var payment_old_value = $('#payment_old_value').val();

      var credit_charges = $('#credit_charges1').val();
      var credit_card_details = $('#credit_card_details1').val();
      var credit_charges_old = $('#credit_charges_old').val();
      
      if(!check_updated_amount(payment_old_value,payment_amount)){
        error_msg_alert("You can update receipt to 0 only!");
        return false;
      }

      // if(payment_for=='Travelling'){  

      //   if(p_travel_type=="" ){

      //     error_msg_alert("Please select travelling type.");

      //     $('#cmb_travel_of_type').focus();

      //     return false;

      //   }

      // }



      // if(payment_for=="Tour"){ p_travel_type = ""; }

      if(payment_mode=="cash"){ bank_name = ""; transaction_id = ""; }



      $('#btn_update').button('loading');

              

        $.post( 

           base_url()+"controller/package_tour/payment/package_tour_payment_master_update_c.php",

           { payment_id : payment_id, booking_id : booking_id, payment_date : payment_date, payment_mode : payment_mode, payment_amount : payment_amount, bank_name : bank_name, transaction_id : transaction_id, payment_for : payment_for, p_travel_type : p_travel_type, bank_id : bank_id, payment_old_value : payment_old_value,credit_charges:credit_charges,credit_card_details:credit_card_details,credit_charges_old:credit_charges_old },

           function(data) {       

               $('#update_modal').modal('hide');             

               msg_alert(data);

               list_reflect();

               $('#btn_update').button('reset');

           });





  }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>