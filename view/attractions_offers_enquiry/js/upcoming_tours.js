jQuery('#txt_tour_offer_valid_date').datetimepicker({ timepicker:false, format:'d-m-Y' });


function upcoming_tour_offsers_list_reflect()
{
	$.post('upcoming_tour_offsers_list.php', {}, function(data){
		$('#upcoming_tour_offsers_list_content').html(data);
	});
}
upcoming_tour_offsers_list_reflect();

///////////////////////***Upcoming Tour offers master save start*********//////////////

$(function(){

	$('#frm_upcoming_tour_offser_save').validate({
		rules:{
				txt_tour_offer_title : { required:true },
				txt_tour_offer_description : { required:true },
				txt_tour_offer_valid_date : { required:true },
		},
		submitHandler:function(form){
			  var base_url = $("#base_url").val();
			  var title = $("#txt_tour_offer_title").val();
			  var description = $("#txt_tour_offer_description").val();
			  var valid_date = $("#txt_tour_offer_valid_date").val();
			  
			  $('#btn_save').button('loading');
			  $.post( 
			               base_url+"controller/attractions_offers_enquiry/upcoming_tour_offers_master_save.php",
			               { title : title, description : description, valid_date : valid_date },
			               function(data) {  
			                      msg_alert(data);
			                      reset_form('frm_upcoming_tour_offser_save');
			                      $('#upcoming_tours_save_modal').modal('hide');
			                      upcoming_tour_offsers_list_reflect();
			               });
		}
	});

});

///////////////////////***Upcoming Tour offers master save end*********//////////////

///////////////////////***Upcoming Tour offer disable start*********//////////////

function upcoming_tour_offer_disable(offer_id)
{
	var base_url = $("#base_url").val();

	$('#vi_confirm_box').vi_confirm_box({
	    callback: function(data1){
	        if(data1=="yes"){
	          	
	          	  $.post( 
			    		   base_url+"controller/attractions_offers_enquiry/upcoming_tour_offers_disable.php",	
			               { offer_id : offer_id },
			               function(data) {  
			                      msg_alert(data);
			                      upcoming_tour_offsers_list_reflect();
			               });


	        }
	      }
	});

  
}

///////////////////////***Upcoming Tour offer disable end*********//////////////

function upcoming_tours_update_modal(offer_id)
{
	 $.post( 
               "upcoming_tours_update_modal.php",
               { offer_id : offer_id },
               function(data) {  
                      $('#div_upcoming_tours_update_modal').html(data);
               });
}