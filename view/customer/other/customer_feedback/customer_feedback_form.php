<?php
include "../../../../model/model.php";
$customer_id = $_GET['customer_id'];
$booking_id = $_GET['booking_id']; 
$tour_name = $_GET['tour_name'];
 
?>
<head>

  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

   <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.wysiwyg.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
            
  <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.wysiwyg.js"></script>

</head>
<div class="container">
    <div class="app_panel_head text-center mg_tp_20">
      <h2>Feedback Information</h2>
    </div>
    <form id="frm_save" class="mg_tp_20">
		<input type="hidden" id="customer_id" name="customer_id" value="<?= $customer_id ?>" >
		<input type="hidden" id="booking_id" name="booking_id" value="<?= $booking_id ?>" >
		<input type="hidden" id="tour_name" name="tour_name" value="<?= $tour_name ?>" >
	    <div class="row mg_tp_20">
	        <div class="answer_wrap">
	          <div class="col-md-12">
	            <h4>1. Why did you choose us over other travel agencies?</h4>
	           <div class="col-md-12">
	                <input type="radio" id="personal_experience" name="travel_agencies" value="Personal Experience"><label for="personal_experience">Personal Experience</label>
	                <input type="radio" id="our_pricing" name="travel_agencies" value="Our Pricing"><label for="our_pricing">Our Pricing</label>
	                <input type="radio" id="a_recommendation" name="travel_agencies" value="A recommendation"> <label for="a_recommendation">A recommendation</label>
	                <input type="radio" id="advertising" name="travel_agencies" value="Advertising"><label for="advertising">Advertising</label>
	                <input type="radio" id="reputation_of_agency" name="travel_agencies" value="Reputation of Agency"><label for="reputation_of_agency">Reputation of Agency</label>
	           </div>
	          </div>
	   
	            <div class="col-md-12 mg_tp_10">
	              <h4>2. How was our sales team to you?</h4>
	                 <div class="col-md-12">
	                <input type="radio" id="professional" name="sales_team" value="Professional"><label for="professional">Professional</label>
	                <input type="radio" id="friendly" name="sales_team" value="Friendly"><label for="friendly">Friendly</label>
	                <input type="radio" id="catered_instinctively" name="sales_team" value="Catered Instinctively"><label for="catered_instinctively">Catered Instinctively</label>
	                <input type="radio" id="informative" name="sales_team" value="Informative"><label for="informative">Informative</label>
	                <input type="radio" id="none_of_these" name="sales_team" value="None of these" onchange="sales_team_comment_reflect()"><label for="none_of_these">None of these</label></br>
	              <input type="text" name="sales_team_comment" id="sales_team_comment" class="mg_tp_10 hidden" placeholder="Add Comments" title="Add Comments">
	           </div>
	            </div>
	        </div>
	    </div>
	  
	    <div class="row mg_bt_20">
	        <div class="answer_wrap">
	            <h4>3. Quality of Accomodation Services</h4>
	          <div class="col-md-12">
	            <h4>a) Were the vehicles exactly as requested ?</h4>
	           <div class="col-md-12">
	                <input type="radio" id="excellent" name="vehicles_requested" value="Excellent"><label for="excellent">Excellent</label>
	                <input type="radio" id="good" name="vehicles_requested" value="Good"><label for="good">Good</label>
	                <input type="radio" id="satisfactory" name="vehicles_requested" value="Satisfactory"><label for="satisfactory">Satisfactory</label>
	                <input type="radio" id="poor" name="vehicles_requested" value="Poor"><label for="poor">Poor</label>
	                <input type="radio" id="unacceptable" name="vehicles_requested" value="Unacceptable"><label for="unacceptable">Unacceptable</label>
	           </div>
	          </div>
	   
	            <div class="col-md-12 mg_tp_10">
	              <h4>b) Were Pickups usually on time?</h4>
	                 <div class="col-md-12">
	                <input type="radio" id="excellent1" name="pickup_time" value="Excellent"><label for="excellent1">Excellent</label>
	                <input type="radio" id="good1" name="pickup_time" value="Good"><label for="good1">Good</label>
	                <input type="radio" id="satisfactory1" name="pickup_time" value="Satisfactory"><label for="satisfactory1">Satisfactory</label>
	                <input type="radio" id="poor1" name="pickup_time" value="Poor"><label for="poor1">Poor</label>
	                <input type="radio" id="unacceptable1" name="pickup_time" value="Unacceptable" ><label for="unacceptable1">Unacceptable</label></br>
	           </div>
	            </div>
	             <div class="col-md-12">
	            <h4>c) Were the vehicles in clean, neat & good condition ?</h4>
	           <div class="col-md-12">
	                <input type="radio" id="excellent2" name="vehicles_condition" value="Excellent"><label for="excellent2">Excellent</label>
	                <input type="radio" id="good2" name="vehicles_condition" value="Good"><label for="good2">Good</label>
	                <input type="radio" id="satisfactory2" name="vehicles_condition" value="Satisfactory"><label for="satisfactory2">Satisfactory</label>
	                <input type="radio" id="poor2" name="vehicles_condition" value="Poor"><label for="poor2">Poor</label>
	                <input type="radio" id="unacceptable2" name="vehicles_condition" value="Unacceptable"><label for="unacceptable2">Unacceptable</label>
	           </div>
	          </div>
	   
	            <div class="col-md-12 mg_tp_10">
	              <h4>d) Was the driver safe, polite, courteous and informative ?</h4>
	                 <div class="col-md-12">
	                <input type="radio" id="excellent3" name="driver_info" value="Excellent"><label for="excellent3">Excellent</label>
	                <input type="radio" id="good3" name="driver_info" value="Good"><label for="good3">Good</label>
	                <input type="radio" id="satisfactory3" name="driver_info" value="Satisfactory"><label for="satisfactory3">Satisfactory</label>
	                <input type="radio" id="poor3" name="driver_info" value="Poor"><label for="poor3">Poor</label>
	                <input type="radio" id="unacceptable4" name="driver_info" value="Unacceptable" ><label for="unacceptable4">Unacceptable</label></br>
	           </div>
	            </div>
	            <div class="col-md-12">
	            <h4>e) Were the tickets, service vouchers issued in a timely manner ?</h4>
	           <div class="col-md-12">
	                <input type="radio" id="excellent5" name="ticket_info" value="Excellent"><label for="excellent5">Excellent</label>
	                <input type="radio" id="good5" name="ticket_info" value="Good"><label for="good5">Good</label>
	                <input type="radio" id="satisfactory5" name="ticket_info" value="Satisfactory"><label for="satisfactory5">Satisfactory</label>
	                <input type="radio" id="poor5" name="ticket_info" value="Poor"><label for="poor5">Poor</label>
	                <input type="radio" id="unacceptable5" name="ticket_info" value="Unacceptable5"><label for="unacceptable">Unacceptable</label>
	           </div>
	          </div>
	        </div>
	    </div>

	     <div class="row mg_bt_20">
	        <div class="answer_wrap">
	            <h4>4. Quality of Accomodation Services</h4>
	          <div class="col-md-12">
	            <h4>a) Were the hotels exactly as requested ?</h4>
	           <div class="col-md-12">
	             <input type="radio" id="yes" name="hotel_request" value="Yes"><label for="yes">Yes</label>
	                <input type="radio" id="no" name="hotel_request" value="No"><label for="no">No</label>
	           </div>
	          </div>
	   
	            <div class="col-md-12 mg_tp_10">
	              <h4>b) How would you rate your accomodations for Hygiene & Cleanliness?</h4>
	                 <div class="col-md-12">
	                 <input type="radio" id="yes1" name="hotel_clean" value="Yes"><label for="yes1">Yes</label>
	                    <input type="radio" id="no1" name="hotel_clean" value="No"><label for="no1">No</label>
	                </div>
	            </div>
	             <div class="col-md-12">
	            <h4>c) How was the quality & quanity of meal?</h4>
	           <div class="col-md-12">
	                <input type="radio" id="excellent6" name="hotel_quality" value="Excellent"> <label for="excellent6">Excellent</label>
	                <input type="radio" id="good6" name="hotel_quality" value="Good"><label for="good6">Good</label>
	                <input type="radio" id="satisfactory6" name="hotel_quality" value="Satisfactory"><label for="satisfactory6">Satisfactory</label>
	                <input type="radio" id="poor6" name="hotel_quality" value="Poor"><label for="poor6">Poor</label>
	                <input type="radio" id="unacceptable6" name="hotel_quality" value="Unacceptable"><label for="unacceptable6">Unacceptable</label>
	           </div>
	          </div>
	        </div>
	    </div>

	    <div class="row mg_bt_20">
	        <div class="answer_wrap">
	            <h4>5. Quality of Sightseeing Services:</h4>
	          <div class="col-md-12">
	            <h4>a) Did you get all sightseeing as per itinerary ?</h4>
	           <div class="col-md-12">
	             <input type="radio" id="yes2" name="siteseen" value="Yes"><label for="yes2">Yes</label>
	                <input type="radio" id="no2" name="siteseen" value="No"><label for="no2">No</label>
	           </div>
	          </div>
	   
	            <div class="col-md-12 mg_tp_10">
	              <h4>b) Did you get enough time on sightseeing ?</h4>
	                 <div class="col-md-12">
	                 <input type="radio" id="yes3" name="siteseen_time" value="Yes"><label for="yes3">Yes</label>
	                    <input type="radio" id="no3" name="siteseen_time" value="No"><label for="no3">No</label>
	                </div>
	            </div>
	             <div class="col-md-12">
	            <h4>c) How was the knowledge & performance of the tour guide?</h4>
	           <div class="col-md-12">
	                <input type="radio" id="excellent7" name="tour_guide" value="Excellent"><label for="excellent7">Excellent</label>
	                <input type="radio" id="good7" name="tour_guide" value="Good"><label for="good7">Good</label>
	                <input type="radio" id="satisfactory7" name="tour_guide" value="Satisfactory"><label for="satisfactory7">Satisfactory</label>
	                <input type="radio" id="poor7" name="tour_guide" value="Poor"><label for="poor7">Poor</label>
	                <input type="radio" id="unacceptable7" name="tour_guide" value="Unacceptable"><label for="unacceptable7">Unacceptable</label>
	           </div>
	          </div>
	        </div>
	    </div>


		<div class="row mg_bt_20">
		    <div class="answer_wrap">
		        <h4>6. Please answer the following few questions based on your experience using us:</h4>
		      <div class="col-md-12">
		        <h4>a) How did you find overall booking experience ?</h4>
		       <div class="col-md-12">
		         <input type="radio" id="excellent8" name="booking_experience" value="Excellent"><label for="excellent8">Excellent</label>
		            <input type="radio" id="good8" name="booking_experience" value="Good"><label for="good8">Good</label>
		            <input type="radio" id="satisfactory8" name="booking_experience" value="Satisfactory"><label for="satisfactory8">Satisfactory</label>
		            <input type="radio" id="poor8" name="booking_experience" value="Poor"><label for="poor8">Poor</label>
		            <input type="radio" id="unacceptable8" name="booking_experience" value="Unacceptable"><label for="unacceptable8">Unacceptable</label>
		       </div>
		      </div>

		        <div class="col-md-12 mg_tp_10">
		          <h4>b) Would you travel again with us in the future? </h4>
		             <div class="col-md-12">
		             <input type="radio" id="yes4" name="travel_again" value="Yes"><label for="yes4">Yes</label>
		                <input type="radio" id="no4" name="travel_again" value="No"><label for="no4">No</label>
		            </div>
		        </div>
		         <div class="col-md-12">
		        <h4>c) Would you recommend us to people around you?</h4>
		       <div class="col-md-12">
		        <input type="radio" id="yes5" name="hotel_recommend" value="Yes"><label for="yes5">Yes</label>
		        <input type="radio" id="no5" name="hotel_recommend" value="No"><label for="no5">No</label> 
		       </div>
		      </div>
		    </div>
		</div>


		<div class="row mg_bt_20">
		    <div class="answer_wrap">
		      <div class="col-md-12">
		        <h4>7. How satisfied were you with the level and quality of service surrounding your trip?</h4>
		       <div class="col-md-12">
		            <input type="radio" id="satisfied" name="quality_service" value="Satisfied">&nbsp;<label for="satisfied">Satisfied</label>
		            &nbsp;&nbsp;&nbsp;
		            <input type="radio" id="kind_of_satisfied" name="quality_service" value="Kind of Satisfied">&nbsp;<label for="kind_of_satisfied">Kind of Satisfied</label>
		            &nbsp;&nbsp;&nbsp;
		            <input type="radio" id="neither_satisfied_nor_dissatified" name="quality_service" value="Neither Satisfied nor dissatified">&nbsp;<label for="neither_satisfied_nor_dissatified">Neither Satisfied nor dissatified</label>
		            &nbsp;&nbsp;&nbsp;
		            <input type="radio" id="dissatisfied" name="quality_service" value="Dissatisfied">&nbsp;<label for="dissatisfied">Dissatisfied</label>
		            &nbsp;&nbsp;&nbsp;
		            <input type="text" id="add_comment" name="add_comment" placeholder="Add Comment" class="mg_tp_10">&nbsp; 
		       </div>
		      </div>

		        <div class="col-md-12 mg_tp_10">
		            
		              <h4>8. From your front door until your return, How would you rate your trip overall?</h4>
		         
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
            <button class="btn btn-success" id="form_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Submit</button>
          </div>
        </div>
        <br>
  
</div>
</form>
</div>
<script>
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
  },
  submitHandler:function(){
      var booking_type = $('#tour_name').val();

      var booking_id = $('#booking_id').val();
      
        var sales_team1 = $('input[name="sales_team"]:checked').attr('id')
    
        if(sales_team1=='none_of_these')
        {
          var sales_team_comment = $('#sales_team_comment').val();
        }
        var customer_id = $('#customer_id').val();
        var sales_team = $('input[name="sales_team"]:checked').val();
        var travel_agencies = $('input[name="travel_agencies"]:checked').val();
        var vehicles_requested = $('input[name="vehicles_requested"]:checked').val();
        var pickup_time =  $('input[name="pickup_time"]:checked').val();
        var vehicles_condition = $('input[name="vehicles_condition"]:checked').val();
        var driver_info =  $('input[name="driver_info"]:checked').val();
        var ticket_info = $('input[name="ticket_info"]:checked').val();
        var hotel_request = $('input[name="hotel_request"]:checked').val();
        var hotel_clean = $('input[name="hotel_clean"]:checked').val();
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
        //var base_url = $('#base_url').val();

        $('#form_send').button('loading');

        $.ajax({
                  type : 'post',
                  url : '../../../../controller/customer/customer_feedback.php',
                  data: { customer_id : customer_id, sales_team : sales_team, travel_agencies : travel_agencies, vehicles_requested : vehicles_requested, pickup_time : pickup_time, vehicles_condition : vehicles_condition, driver_info : driver_info, ticket_info : ticket_info, hotel_request : hotel_request, hotel_clean : hotel_clean, hotel_quality : hotel_quality, siteseen : siteseen, siteseen_time : siteseen_time, tour_guide : tour_guide, booking_experience : booking_experience, travel_again : travel_again, hotel_recommend : hotel_recommend, quality_service : quality_service, trip_overall : trip_overall , sales_team_comment : sales_team_comment, add_comment : add_comment, booking_type : booking_type, booking_id : booking_id},
                  success:function(result){
                  	alert(result);
                    $('#form_send').button('reset');     
                  }
        });


  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>