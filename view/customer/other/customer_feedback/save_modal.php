<?php 
include_once('../../../../model/model.php');

$customer_id = $_SESSION['customer_id'];
?>
<form id="frm_save">

  <input type="hidden" id="customer_id" name="customer_id" value="<?= $customer_id ?>">

  <div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 id="myModalLabel">Customer Feedback</h3>
        </div>
        <div class="modal-body">
          <div class="row ">
            <div class="col-md-4">
              <select name="booking_type" id="booking_type" title="Bopoking Type" onchange="customer_bookings_reflect(this.value)">
                      <option value="">Booking Type</option>
                      <option value="Group Booking">Group Booking</option>
                      <option value="Package Booking">Package Booking</option>
                  </select>
              </div>
              <div class="col-md-4">
                <select name="booking_id" id="booking_id" class="form-control" title="Select Booking" style="width:100%">
                    <option value="">Booking ID</option>
                </select>
              </div>
            </div>  

            <div class="row mg_tp_20">
              <div class="col-md-12">
                <h3 class="editor_title">1. Why did you choose us over other travel agencies?</h3>
                 <div class="panel panel-default panel-body app_panel_style">
                      <input type="radio" id="personal_experience" name="travel_agencies" value="Personal Experience"><label class="feedback_option_lable" for="personal_experience">Personal Experience</label>
                      <input type="radio" id="our_pricing" name="travel_agencies" value="Our Pricing"><label class="feedback_option_lable" for="our_pricing">Our Pricing</label>
                      <input type="radio" id="a_recommendation" name="travel_agencies" value="A recommendation"> <label class="feedback_option_lable" for="a_recommendation">A recommendation</label>
                      <input type="radio" id="advertising" name="travel_agencies" value="Advertising"><label class="feedback_option_lable" for="advertising">Advertising</label>
                      <input type="radio" id="reputation_of_agency" name="travel_agencies" value="Reputation of Agency"><label class="feedback_option_lable" for="reputation_of_agency">Reputation of Agency</label>
                 </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <h3 class="editor_title">2. How was our sales team to you?</h3>
                <div class="panel panel-default panel-body app_panel_style">
                  <input type="radio" id="professional" name="sales_team" value="Professional"><label class="feedback_option_lable" for="professional">Professional</label>
                  <input type="radio" id="friendly" name="sales_team" value="Friendly"><label class="feedback_option_lable" for="friendly">Friendly</label>
                  <input type="radio" id="catered_instinctively" name="sales_team" value="Catered Instinctively"><label class="feedback_option_lable" for="catered_instinctively">Catered Instinctively</label>
                  <input type="radio" id="informative" name="sales_team" value="Informative"><label class="feedback_option_lable" for="informative">Informative</label>
                  <input type="radio" id="none_of_these" name="sales_team" value="None of these" onchange="sales_team_comment_reflect()"><label class="feedback_option_lable" for="none_of_these">None of these</label>
                  <!-- <input type="text" name="sales_team_comment" id="sales_team_comment" class="mg_tp_10 hidden" placeholder="Add Comments" title="Add Comments"> -->
                </div>
              </div>
            </div>
          
            <div class="row">
              <div class="col-md-12">
              <h3 class="editor_title">3. Quality of Travel Services</h3>
              <div class="panel panel-default panel-body app_panel_style">
                <div class="col-md-12">
                   <h5>a) Were the vehicles exactly as requested ?</h5>
                   <div class="col-md-12">
                        <input type="radio" id="excellent" name="vehicles_requested" value="Excellent"><label class="feedback_option_lable" for="excellent">Excellent</label>
                        <input type="radio" id="good" name="vehicles_requested" value="Good"><label class="feedback_option_lable" for="good">Good</label>
                        <input type="radio" id="satisfactory" name="vehicles_requested" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory">Satisfactory</label>
                        <input type="radio" id="poor" name="vehicles_requested" value="Poor"><label class="feedback_option_lable" for="poor">Poor</label>
                        <input type="radio" id="unacceptable" name="vehicles_requested" value="Unacceptable"><label class="feedback_option_lable" for="unacceptable">Unacceptable</label>
                   </div>
                </div>
             
                <div class="col-md-12 mg_tp_10">
                  <h5>b) Were Pickups usually on time?</h5>
                     <div class="col-md-12">
                        <input type="radio" id="excellent1" name="pickup_time" value="Excellent"><label class="feedback_option_lable" for="excellent1">Excellent</label>
                        <input type="radio" id="good1" name="pickup_time" value="Good"><label class="feedback_option_lable" for="good1">Good</label>
                        <input type="radio" id="satisfactory1" name="pickup_time" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory1">Satisfactory</label>
                        <input type="radio" id="poor1" name="pickup_time" value="Poor"><label class="feedback_option_lable" for="poor1">Poor</label>
                        <input type="radio" id="unacceptable1" name="pickup_time" value="Unacceptable" ><label class="feedback_option_lable" for="unacceptable1">Unacceptable</label>
                      </div>
                </div>

                <div class="col-md-12 mg_tp_10">
                    <h5>c) Were the vehicles in clean, neat & good condition ?</h5>
                    <div class="col-md-12">
                          <input type="radio" id="excellent2" name="vehicles_condition" value="Excellent"><label class="feedback_option_lable" for="excellent2">Excellent</label>
                          <input type="radio" id="good2" name="vehicles_condition" value="Good"><label class="feedback_option_lable" for="good2">Good</label>
                          <input type="radio" id="satisfactory2" name="vehicles_condition" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory2">Satisfactory</label>
                          <input type="radio" id="poor2" name="vehicles_condition" value="Poor"><label class="feedback_option_lable" for="poor2">Poor</label>
                          <input type="radio" id="unacceptable2" name="vehicles_condition" value="Unacceptable"><label class="feedback_option_lable" for="unacceptable2">Unacceptable</label>
                     </div>
                </div>
             
                <div class="col-md-12 mg_tp_10">
                    <h5>d) Was the driver safe, polite, courteous and informative ?</h5>
                    <div class="col-md-12">
                        <input type="radio" id="excellent3" name="driver_info" value="Excellent"><label class="feedback_option_lable" for="excellent3">Excellent</label>
                        <input type="radio" id="good3" name="driver_info" value="Good"><label class="feedback_option_lable" for="good3">Good</label>
                        <input type="radio" id="satisfactory3" name="driver_info" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory3">Satisfactory</label>
                        <input type="radio" id="poor3" name="driver_info" value="Poor"><label class="feedback_option_lable" for="poor3">Poor</label>
                        <input type="radio" id="unacceptable4" name="driver_info" value="Unacceptable" ><label class="feedback_option_lable" for="unacceptable4">Unacceptable</label>
                    </div>
                </div>

                <div class="col-md-12 mg_tp_10">
                  <h5>e) Were the tickets, service vouchers issued in a timely manner ?</h5>
                  <div class="col-md-12">
                    <input type="radio" id="excellent5" name="ticket_info" value="Excellent"><label class="feedback_option_lable" for="excellent5">Excellent</label>
                    <input type="radio" id="good5" name="ticket_info" value="Good"><label class="feedback_option_lable" for="good5">Good</label>
                    <input type="radio" id="satisfactory5" name="ticket_info" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory5">Satisfactory</label>
                    <input type="radio" id="poor5" name="ticket_info" value="Poor"><label class="feedback_option_lable" for="poor5">Poor</label>
                    <input type="radio" id="unacceptable5" name="ticket_info" value="Unacceptable5"><label class="feedback_option_lable" for="unacceptable">Unacceptable</label>
                  </div>
                </div>
              </div>
            </div>
            </div>

             <div class="row">
                <div class="col-xs-12">
                    <h3 class="editor_title">4. Quality of Accomodation Services</h3>
                    <div class="panel panel-default panel-body app_panel_style">
                      <div class="col-md-12">
                        <h5>a) Were the hotels exactly as requested ?</h5>
                        <div class="col-md-12">
                          <input type="radio" id="yes" name="hotel_request" value="Yes"><label class="feedback_option_lable" for="yes">Yes</label>
                            <input type="radio" id="no" name="hotel_request" value="No"><label class="feedback_option_lable" for="no">No</label>
                        </div>
                      </div>
               
                        <div class="col-md-12 mg_tp_10">
                          <h5>b) How would you rate your accomodations for Hygiene & Cleanliness?</h5>
                             <div class="col-md-12">
                             <input type="radio" id="aexcellent6" name="ahotel_quality" value="Excellent"> <label class="feedback_option_lable" for="aexcellent6">Excellent</label>
                              <input type="radio" id="agood6" name="ahotel_quality" value="Good"><label class="feedback_option_lable" for="agood6">Good</label>
                              <input type="radio" id="asatisfactory6" name="ahotel_quality" value="Satisfactory"><label class="feedback_option_lable" for="asatisfactory6">Satisfactory</label>
                              <input type="radio" id="apoor6" name="ahotel_quality" value="Poor"><label class="feedback_option_lable" for="apoor6">Poor</label>
                              <input type="radio" id="aunacceptable6" name="ahotel_quality" value="Unacceptable"><label class="feedback_option_lable" for="aunacceptable6">Unacceptable</label>
                            </div>
                        </div>

                      <div class="col-md-12 mg_tp_10">
                         <h5>c) How was the quality & quanity of meal?</h5>
                         <div class="col-md-12">
                              <input type="radio" id="excellent6" name="hotel_quality" value="Excellent"> <label class="feedback_option_lable" for="excellent6">Excellent</label>
                              <input type="radio" id="good6" name="hotel_quality" value="Good"><label class="feedback_option_lable" for="good6">Good</label>
                              <input type="radio" id="satisfactory6" name="hotel_quality" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory6">Satisfactory</label>
                              <input type="radio" id="poor6" name="hotel_quality" value="Poor"><label class="feedback_option_lable" for="poor6">Poor</label>
                              <input type="radio" id="unacceptable6" name="hotel_quality" value="Unacceptable"><label class="feedback_option_lable" for="unacceptable6">Unacceptable</label>
                         </div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="editor_title">5. Quality of Sightseeing Services:</h3>
                    <div class="panel panel-default panel-body app_panel_style">
                      <div class="col-md-12">
                        <h5>a) Did you get all sightseeing as per itinerary ?</h5>
                         <div class="col-md-12">
                           <input type="radio" id="yes2" name="siteseen" value="Yes"><label class="feedback_option_lable" for="yes2">Yes</label>
                              <input type="radio" id="no2" name="siteseen" value="No"><label class="feedback_option_lable" for="no2">No</label>
                         </div>
                      </div>
               
                        <div class="col-md-12 mg_tp_10">
                          <h5>b) Did you get enough time on sightseeing ?</h5>
                           <div class="col-md-12">
                           <input type="radio" id="yes3" name="siteseen_time" value="Yes"><label class="feedback_option_lable" for="yes3">Yes</label>
                              <input type="radio" id="no3" name="siteseen_time" value="No"><label class="feedback_option_lable" for="no3">No</label>
                          </div>
                        </div>

                         <div class="col-md-12 mg_tp_10">
                          <h5>c) How was the knowledge & performance of the tour guide?</h5>
                           <div class="col-md-12">
                                <input type="radio" id="excellent7" name="tour_guide" value="Excellent"><label class="feedback_option_lable" for="excellent7">Excellent</label>
                                <input type="radio" id="good7" name="tour_guide" value="Good"><label class="feedback_option_lable" for="good7">Good</label>
                                <input type="radio" id="satisfactory7" name="tour_guide" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory7">Satisfactory</label>
                                <input type="radio" id="poor7" name="tour_guide" value="Poor"><label class="feedback_option_lable" for="poor7">Poor</label>
                                <input type="radio" id="unacceptable7" name="tour_guide" value="Unacceptable"><label class="feedback_option_lable" for="unacceptable7">Unacceptable</label>
                           </div>
                        </div>
                    </div>
                </div>
            </div>


             <div class="row">
                <div class="col-xs-12">
                    <h3 class="editor_title">6. Please answer the following few questions based on your experience using us:</h3>
                    <div class="panel panel-default panel-body app_panel_style">
                      <div class="col-md-12">
                        <h5>a) How did you find overall booking experience ?</h5>
                         <div class="col-md-12">
                           <input type="radio" id="excellent8" name="booking_experience" value="Excellent"><label class="feedback_option_lable" for="excellent8">Excellent</label>
                              <input type="radio" id="good8" name="booking_experience" value="Good"><label class="feedback_option_lable" for="good8">Good</label>
                              <input type="radio" id="satisfactory8" name="booking_experience" value="Satisfactory"><label class="feedback_option_lable" for="satisfactory8">Satisfactory</label>
                              <input type="radio" id="poor8" name="booking_experience" value="Poor"><label class="feedback_option_lable" for="poor8">Poor</label>
                              <input type="radio" id="unacceptable8" name="booking_experience" value="Unacceptable"><label class="feedback_option_lable" for="unacceptable8">Unacceptable</label>
                         </div>
                      </div>
               
                        <div class="col-md-12 mg_tp_10">
                          <h5>b) Would you travel again with us in the future? </h5>
                             <div class="col-md-12">
                             <input type="radio" id="yes4" name="travel_again" value="Yes"><label class="feedback_option_lable" for="yes4">Yes</label>
                                <input type="radio" id="no4" name="travel_again" value="No"><label class="feedback_option_lable" for="no4">No</label>
                            </div>
                        </div>

                         <div class="col-md-12 mg_tp_10">
                           <h5>c) Would you recommend us to people around you?</h5>
                           <div class="col-md-12">
                            <input type="radio" id="yes5" name="hotel_recommend" value="Yes"><label class="feedback_option_lable" for="yes5">Yes</label>
                            <input type="radio" id="no5" name="hotel_recommend" value="No"><label class="feedback_option_lable" for="no5">No</label> 
                           </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12">
                    <h3 class="editor_title">7. How satisfied were you with the level and quality of service surrounding your trip?</h3>
                   <div class="panel panel-default panel-body app_panel_style">
                     <div class="col-md-12">
                        <input type="radio" id="satisfied" name="quality_service" value="Satisfied"><label class="feedback_option_lable" for="satisfied">Satisfied</label>
                        
                        <input type="radio" id="kind_of_satisfied" name="quality_service" value="Kind of Satisfied"><label class="feedback_option_lable" for="kind_of_satisfied">Kind of Satisfied</label>
                        
                        <input type="radio" id="neither_satisfied_nor_dissatified" name="quality_service" value="Neither Satisfied nor dissatified"><label class="feedback_option_lable" for="neither_satisfied_nor_dissatified">Neither Satisfied nor dissatified</label>
                        
                        <input type="radio" id="dissatisfied" name="quality_service" value="Dissatisfied"><label class="feedback_option_lable" for="dissatisfied">Dissatisfied</label>
                        
                        <input type="text" id="add_comment" name="add_comment" placeholder="Add Comment" class="mg_tp_20"> 
                   </div>
                  </div>
                </div>
            </div>
              
              <div class="row mg_bt_20">
                  <div class="col-md-12">
                      <h3 class="editor_title">8. From your front door until your return, How would you rate your trip overall?</h3>
                       <div class="panel panel-default panel-body app_panel_style">
                         <div class="col-md-3">
                            <select name="trip_overall" style="width: 100%" id="trip_overall" title="Trip Overall"  >
                              <option value="">Select</option>
                              <?php 
                               for($i=1; $i<=5; $i++){
                                ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                                <?php
                              }
                              ?>
                            </select>
                        </div>
                       </div>
                  </div>
              </div>
             
             
            
            <div class="row text-center mg_tp_20">
              <div class="col-md-12">
                <button class="btn btn-sm btn-success" id="btn_submit"><i class="fa fa-paper-plane-o"></i>Submit</button>
              </div>
            </div>
            <br>
  

        </div>      
      </div>
    </div>
  </div>

</form>

<script>
function customer_bookings_reflect(booking_type){
    var customer_id = $('#customer_id').val();  
    $.post('booking_reflect.php', { booking_type, customer_id}, function(data){
      $('#booking_id').html(data);
    }); 
  }
$('#save_modal').modal('show');
function sales_team_comment_reflect(){
    var sales_team = $('input[name="sales_team"]:checked').attr('id')
    
        if(sales_team=='none_of_these')
        {
          $('#sales_team_comment').removeClass('hidden');
        }
}
$('#frm_save').validate({
  rules:{
          trip_overall : { required : true },
          booking_id : { required : true },
          booking_type : { required : true },
  },
  submitHandler:function(){
      var booking_type = $('#booking_type').val();
      var booking_id = $('#booking_id').val();
      
        var sales_team1 = $('input[name="sales_team"]:checked').attr('id')
    
        if(sales_team1=='none_of_these')
        {
          var sales_team_comment = $('#sales_team_comment').val();
        }
        var customer_id = $('#customer_id').val();
        var sales_team = $('input[name="sales_team"]:checked').val();

         if (!$('input[name="travel_agencies"]').is(':checked')) {
          error_msg_alert("Please select feedback for Travel Agencies");
          return false;
        }
        
         if (!$('input[name="sales_team"]').is(':checked')) {
          error_msg_alert("Please select feedback for sales team");
          return false;
        }
        
         if (!$('input[name="vehicles_requested"]').is(':checked')) {
          error_msg_alert("Please select feedback for Vehicles Requested");
          return false;
        }
         if (!$('input[name="sales_team"]').is(':checked')) {
          error_msg_alert("Please select feedback for sales team");
          return false;
        }
         if (!$('input[name="pickup_time"]').is(':checked')) {
          error_msg_alert("Please select feedback for Pickup Time");
          return false;
        }
         if (!$('input[name="vehicles_condition"]').is(':checked')) {
          error_msg_alert("Please select feedback for Vehicles Condition");
          return false;
        }
         if (!$('input[name="driver_info"]').is(':checked')) {
          error_msg_alert("Please select feedback for Driver Info");
          return false;
        }
         if (!$('input[name="ticket_info"]').is(':checked')) {
          error_msg_alert("Please select feedback for Ticket Info");
          return false;
        }
         if (!$('input[name="hotel_request"]').is(':checked')) {
          error_msg_alert("Please select feedback for Hotel Request");
          return false;
        }
         if (!$('input[name="ahotel_quality"]').is(':checked')) {
          error_msg_alert("Please select feedback for Hotel Clean");
          return false;
        }
         if (!$('input[name="hotel_quality"]').is(':checked')) {
          error_msg_alert("Please select feedback for Hotel Quality");
          return false;
        }
         if (!$('input[name="siteseen"]').is(':checked')) {
          error_msg_alert("Please select feedback for Siteseen");
          return false;
        }
         if (!$('input[name="siteseen_time"]').is(':checked')) {
          error_msg_alert("Please select feedback for Siteseen Time");
          return false;
        }
         if (!$('input[name="tour_guide"]').is(':checked')) {
          error_msg_alert("Please select feedback for Tour Guide");
          return false;
        }
         if (!$('input[name="booking_experience"]').is(':checked')) {
          error_msg_alert("Please select feedback for Booking Experience");
          return false;
        }
         if (!$('input[name="travel_again"]').is(':checked')) {
          error_msg_alert("Please select feedback for Travel Again");
          return false;
        }
         if (!$('input[name="hotel_recommend"]').is(':checked')) {
          error_msg_alert("Please select feedback for Hotel Recommend");
          return false;
        }
         if (!$('input[name="quality_service"]').is(':checked')) {
          error_msg_alert("Please select feedback for Qualityz Service");
          return false;
        }
        var travel_agencies = $('input[name="travel_agencies"]:checked').val();
        var vehicles_requested = $('input[name="vehicles_requested"]:checked').val();
        var pickup_time =  $('input[name="pickup_time"]:checked').val();
        var vehicles_condition = $('input[name="vehicles_condition"]:checked').val();
        var driver_info =  $('input[name="driver_info"]:checked').val();
        var ticket_info = $('input[name="ticket_info"]:checked').val();
        var hotel_request = $('input[name="hotel_request"]:checked').val();
        var hotel_clean = $('input[name="ahotel_quality"]:checked').val();
        var hotel_quality = $('input[name="hotel_quality"]:checked').val();
        var siteseen = $('input[name="siteseen"]:checked').val();
        var siteseen_time = $('input[name="siteseen_time"]:checked').val();
        var tour_guide = $('input[name="tour_guide"]:checked').val();
        var booking_experience = $('input[name="booking_experience"]:checked').val();
        var travel_again = $('input[name="travel_again"]:checked').val();  
        var hotel_recommend = $('input[name="hotel_recommend"]:checked').val();
        var quality_service = $('input[name="quality_service"]:checked').val();
        var trip_overall = $('#trip_overall').val();
        var add_comment = $('#add_comment').val();

        $('#btn_submit').button('loading');

        $.ajax({
                  type : 'post',
                  url : base_url()+'controller/customer/customer_feedback.php',
                  data: { customer_id : customer_id, sales_team : sales_team, travel_agencies : travel_agencies, vehicles_requested : vehicles_requested, pickup_time : pickup_time, vehicles_condition : vehicles_condition, driver_info : driver_info, ticket_info : ticket_info, hotel_request : hotel_request, hotel_clean : hotel_clean, hotel_quality : hotel_quality, siteseen : siteseen, siteseen_time : siteseen_time, tour_guide : tour_guide, booking_experience : booking_experience, travel_again : travel_again, hotel_recommend : hotel_recommend, quality_service : quality_service, trip_overall : trip_overall , sales_team_comment : sales_team_comment, add_comment : add_comment, booking_type : booking_type, booking_id : booking_id},
                  success:function(result){
                    $('#btn_submit').button('reset');
                      $('#save_modal').modal('hide');
                      list_reflect();
                      msg_alert(result);
                  }
        });


  }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>