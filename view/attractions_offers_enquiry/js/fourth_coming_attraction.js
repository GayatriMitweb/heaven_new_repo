function fourth_coming_attractions_list_reflect()
{
  $.post('fourth_coming_attractions_list.php', {}, function(data){
    $('#fourth_coming_attraction_content').html(data);
  });
}
fourth_coming_attractions_list_reflect();
/////////////////////////////
function load_tourism_attr()
{
  var dest_id = $('#dest_id').val();
    $.post('tourism_attarction_reflect.php', {dest_id : dest_id }, function(data){
    $('#div_list').html(data);
  }); 

}
//load_tourism_attr();
function display_image(entry_id)
{
  $('#attractions_view_modal').modal('hide');
  $.post('display_image_modal.php', {entry_id : entry_id}, function(data){
    $('#div_modal').html(data);
  });
}
function update_modal(entry_id)
{
  $.post('update_modal.php', { entry_id : entry_id }, function(data){
    $('#div_modal1').html(data);
  });
}
///////////////////////***Fourth Coming attraction master save start*********//////////////
$(function(){
  $('#frm_fourth_coming_attraction_save').validate({
    rules:{
            txt_title : { required : true },
            txt_description : { required : true },
            txt_valid_date : { required : true },
    },
    submitHandler:function(form){

        var base_url = $("#base_url").val();
        var title = $("#txt_title").val();
        var description = $("#txt_description").val();
        var valid_date = $('#txt_valid_date').val();
        $('#save_button').button('loading');
        $.post( 
          base_url+"controller/attractions_offers_enquiry/fourth_coming_attraction_master_save_c.php",
          { title : title, description : description, valid_date : valid_date },
          function(data) {  
                msg_alert(data);
                $('#save_button').button('reset');
                reset_form('frm_fourth_coming_attraction_save');
                $('#fouth_coming_attractions_save_modal').modal('hide');
                fourth_coming_attractions_list_reflect();

          });
    }
  });
});
///////////////////////***Fourth Coming attraction master save end*********//////////////

///////////////////////***Fourth Coming attraction master disable start*********//////////////
function fouth_coming_attractions_disable(id)
{
    var base_url = $("#base_url").val();
    

    $('#vi_confirm_box').vi_confirm_box({
        callback: function(data1){
            if(data1=="yes"){
              
                  $.post( 
                         base_url+"controller/attractions_offers_enquiry/fourth_coming_attraction_disable_c.php",
                         { id : id },
                         function(data) {
                                msg_alert(data);
                                fourth_coming_attractions_list_reflect();
                         });

            }
          }
    });
  
}
///////////////////////***Fourth Coming attraction master disable end*********//////////////

function fourth_coming_attractions_update_modal(id)
{
  $.post('fourth_coming_attractions_update_modal.php', { id : id }, function(data){
      $('#div_fourth_coming_attractions_update_modal').html(data);
  });
}
