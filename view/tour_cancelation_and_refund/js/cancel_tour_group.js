//*************************************** Cancel Tour reflect start ******************************************\\
function cancel_tour_group_reflect(){
  
    var tour_id = $("#cmb_tour_name").val();  

    $.get( "cancel_tour_group_reflect.php" , { tour_id : tour_id } , function ( data ) {
            $ ("#div_tour_group_reflect").html( data ) ;              
    });
}
//*************************************** Cancel Tour reflect end ******************************************\\

/////////////********** Cancel Tour Froup Start ***********************************
function cancel_tour_group()
{
  var base_url = $('#base_url').val();	
  var tour_id = $("#cmb_tour_name").val();
  var tours_count = $('#tour_count').val();
  var disabled_count = $('#disabled_count').val();
  if(tour_id=="select")
  {
    error_msg_alert("Please select atleast 1 Tour group first.");
    return false;
  } 
  else if(parseInt(tours_count) == parseInt(disabled_count)){
    error_msg_alert("All the Tours are already cancelled");
    return false;
  } 

 

  $('#vi_confirm_box').vi_confirm_box({
    callback: function(data1){
        if(data1=="yes"){
  var table = document.getElementById('tbl_report_content');
  var rowCount = table.rows.length;
  var count = 0;
  var tour_group_id = new Array(); 
  
  for(var i=1; i<rowCount; i++)
  {  
    var row = table.rows[i]; 
    if(row.cells[3].childNodes[0].checked == true)
    {
      row.cells[3].childNodes[0].disabled = "true";
      count++;
      var temp_id = row.cells[3].childNodes[0].value;
      tour_group_id.push(temp_id);      
      
    }  
  }

  if(count == 0)
  {
    error_msg_alert("Please select atleast 1 Tour group to cancel.");
    return false;
  }



               $.post( 
                 base_url+"controller/group_tour/tour_cancelation_and_refund/cancel_tour_group.php",
                 { tour_id : tour_id, tour_group_id : tour_group_id },
                 function(data) {                     
                      msg_popup_reload(data);              
                 });
            
          }
          else{
            $('#btn_cancel_tour_group').button('reset');
          }
        }
    });


}
/////////////********** Cancel Tour Froup End ***********************************