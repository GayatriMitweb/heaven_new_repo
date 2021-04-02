$(document).ready(function() {
    $("#cmb_tour_name").select2();   
});

function cancelled_tour_groups_reflect(id)
{
  var tour_id=$('#'+id).val();

  $.get('refund_tour/cancelled_tour_groups_reflect.php', { tour_id : tour_id }, function(data){
  	$('#cmb_tour_group').html(data);
  }); 

}

function canceled_travelers_reflect()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
 
  $.get( "refund_tour/cancelled_traveler_reflect.php" , { tour_id : tour_id, tour_group_id : tour_group_id } , function ( data ) {
                $ ("#cmb_traveler_group_id").html( data ) ;
          } ) ; 
}

function refund_cancelled_tour_group_reflect()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
  var traveler_group_id = document.getElementById("cmb_traveler_group_id").value;
 
  $.get( "refund_tour/cancel/refund_cancelled_tour_group_reflect.php" , { tour_id : tour_id, tour_group_id : tour_group_id, traveler_group_id : traveler_group_id  } , function ( data ) {
                $ ("#div_traveler_refund_details").html( data ) ;
                        
          } ) ; 
}

function refund_cancelled_tour_group_traveler_reflect()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
  var traveler_group_id = document.getElementById("cmb_traveler_group_id").value;
 
  $.get( "refund_tour/refund/refund_cancelled_tour_group_traveler_reflect.php" , { tour_id : tour_id, tour_group_id : tour_group_id, traveler_group_id : traveler_group_id  } , function ( data ) {
                $ ("#div_traveler_refund_details").html( data ) ;
                        
          } ) ; 
}


//Voucher for Tour cancel refund
//This function is called after tour refund is done.
function generate_voucher_for_cancelled_tour(refund_id)
{
  var tourwise_id = $("#txt_tourwise_traveler_id").val();
 

  url = 'cancelled_tour_voucher.php?tourwise_id='+tourwise_id+'&refund_id='+refund_id;
                window.open(url, '_blank');
}