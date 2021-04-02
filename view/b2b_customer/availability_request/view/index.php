<?php
include "../../../../model/model.php";
$request_id = $_POST['request_id'];
$query = mysql_fetch_assoc(mysql_query("select * from hotel_availability_request where request_id='$request_id'"));
$cart_data = json_decode($query['cart_data']);
$response = json_decode($query['response']);
?>
<form id="frm_response_save">
  <div class="modal fade profile_box_modal c-bookingInfo" id="request_details" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Hotel Availability Request Status</h4>
          </div>
          <div class="modal-body profile_box_padding">
          <input type="hidden" value='<?= $request_id ?>' id="request_id"/>
          <input type="hidden" value='<?= json_encode($cart_data) ?>' id="cart_data"/>
              <?php
              for($i=0;$i<sizeof($cart_data);$i++){
                $city_id = $cart_data[$i]->city_id;
                $hotel_id = $cart_data[$i]->id;
                $sq_hotel = mysql_fetch_assoc(mysql_query("select city_id,mobile_no,email_id from hotel_master where hotel_id='$hotel_id'"));
                $mobile_no = $encrypt_decrypt->fnDecrypt($sq_hotel['mobile_no'], $secret_key);
                $email_id = $encrypt_decrypt->fnDecrypt($sq_hotel['email_id'], $secret_key);
                
                $item = null;
                foreach($response as $struct) {
                    if ($hotel_id == $struct->id) {
                        $item = $struct;
                        break;
                    }
                }
                if($item->status == 'Available') $ava_status = 'checked'; else $ava_status='';
                if($item->status == 'Not Available') $nava_status = 'checked'; else $nava_status='';
              ?>
                <div class="row no-gutters">
                  <div class="col-md-12">
                    <h5 class="serviceTitle"><u><?= urldecode($cart_data[$i]->hotel_name) ?></u>
                    <?php if($city_id != ''){
                      $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$city_id'"));
                    }else{
                      $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_hotel[city_id]'"));
                    }
                      ?>
                    <span class="serviceTitle"><?= '('.$sq_city['city_name'].')' ?></span> 
                    &nbsp;<u>Mobile No</u> : <?= $mobile_no ?> &nbsp;<u>Email ID</u>: <?= $email_id ?>
                    </h5>
                    <div class="row">
                      <div class='col-md-3'>Check-In :  <strong><?= date('m-d-Y', strtotime($cart_data[$i]->check_in)); ?></strong></div>
                      <div class='col-md-3'>Check-Out : <strong><?= date('m-d-Y', strtotime($cart_data[$i]->check_out)); ?></strong></div>
                      <div class='col-md-6'>
                        <input class="btn-radio" type="radio" id="<?= 'a'.$i ?>" name="status<?= $i ?>" value='Available' onchange="generate_hotels('a',<?=$i?>);" <?= $ava_status ?>> <label for="<?= 'a'.$i ?>">Available</label>&nbsp;&nbsp;&nbsp;
                        <input class="btn-radio" type="radio" id="<?= 'n'.$i ?>" name="status<?= $i ?>" value='Not Available' onchange="generate_hotels('na',<?=$i?>);" <?= $nava_status ?>> <label for="<?= 'n'.$i ?>">Not Available</label>
                      </div>
                    </div>
                    <div class="row">
                    <?php
                      //Room Section
                      for($j=0;$j<sizeof($cart_data[$i]->item_arr);$j++){
                        $room_types = explode('-',$cart_data[$i]->item_arr[$j]);
                        ?>
                          <div class='col-md-12'><?= $room_types[0].': '.$room_types[1] ?></div>
                      <?php } ?>
                    </div>
                    <?php if($item->updated_by!=''){?><p style="margin-bottom: 0px;"><b>Confirmation No</b>: <?= $item->confirmation_no ?></p><?php }?>
                    <?php if($item->updated_by!=''){?><p style="margin-bottom: 0px;"><b>Updated By</b>: <?= $item->updated_by ?></p><?php }?>
                    <?php if($item->note!=''){?><p class="no-pad"><b>Note</b>: <?= $item->note ?></p><?php } ?>
                    
                    <div class="row mg_tp_10"><div class='col-md-12'>
                      <div id="optional_hotel_section<?=$i?>">
                        <?php if($item->status == 'Not Available' && sizeof($item->options)>0){ ?>

                          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
                              <legend>Select Similar Hotel Options</legend>
                              <div class="row text-right mg_bt_10">
                                  <div class="col-xs-12">
                                      <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_similar_hotels<?=$i?>',<?=$i?>)" title="Add row"><i class="fa fa-plus"></i></button>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="table-responsive">
                                      <table id="tbl_similar_hotels<?=$i?>" class="table table-bordered pd_bt_51 no-marg">
                                      <?php for($hi=0;$hi<sizeof($item->options);$hi++){
                                        $option_hotel_id = $item->options[$hi];
                                        $sq_ophotel = mysql_fetch_assoc(mysql_query("select hotel_name,hotel_id,city_id from hotel_master where hotel_id='$option_hotel_id'"));
                                        $sq_opcity = mysql_fetch_assoc(mysql_query("select city_name,city_id from city_master where city_id='$sq_ophotel[city_id]'")); ?>
                                          <tr>
                                              <td style="width:5%"><input class="css-checkbox" id="chk_hh1<?=$i.$hi?>" type="checkbox" checked><label class="css-label" for="chk_hh1<?=$i.$hi?>"> <label></td>
                                              <td style="width:10%"><input maxlength="15" class="form-control text-center" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
                                              <td><select id="city_id1<?=$i.$hi ?>" name="city_id1" title="Select City" onchange="hotel_name_list_load(this.id)" class="form-control app_minselect2" style="width:100%">
                                                      <option value="<?= $sq_opcity['city_id']?>"><?= $sq_opcity['city_name']?></option>
                                                      <?php get_cities_dropdown(); ?>
                                                  </select>
                                              </td>    
                                              <td><select id="hotel_id1<?=$i.$hi ?>" name="hotel_id1" title="Select Hotel" class="form-control app_select2" style="width:100%">
                                                      <option value="<?= $sq_ophotel['hotel_id']?>"><?= $sq_ophotel['hotel_name']?></option>
                                                      <option value="">*Select Hotel</option>
                                                  </select>
                                              </td>
                                          </tr>
                                          <script>
                                            $('#city_id1<?=$i.$hi ?>').select2({minimumInputLength:1});
                                            $('#hotel_id1<?=$i.$hi ?>').select2();
                                          </script>
                                        <?php } ?>
                                      </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        <?php }
                        else if($item->status == 'Not Available' && sizeof($item->options)==0){?>
                          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
                              <legend>Select Similar Hotel Options</legend>
                              <div class="row text-right mg_bt_10">
                                  <div class="col-xs-12">
                                      <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_similar_hotels<?=$i?>',<?=$i?>)" title="Add row"><i class="fa fa-plus"></i></button>
                                      <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_similar_hotels<?=$i?>',<?=$i?>)" title="Delete row"><i class="fa fa-trash"></i></button>    
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="table-responsive">
                                      <table id="tbl_similar_hotels<?=$i?>" class="table table-bordered pd_bt_51 no-marg">
                                          <tr>
                                              <td style="width:5%"><input class="css-checkbox" id="chk_hh1<?=$i?>" type="checkbox" checked><label class="css-label" for="chk_hh1<?=$i?>"> <label></td>
                                              <td style="width:10%"><input maxlength="15" class="form-control text-center" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
                                              <td><select id="city_id1<?=$i?>" name="city_id1" title="Select City" onchange="hotel_name_list_load(this.id)" class="form-control app_minselect2" style="width:100%">
                                                      <?php get_cities_dropdown(); ?>
                                                  </select>
                                              </td>    
                                              <td><select id="hotel_id1<?=$i?>" name="hotel_id1" title="Select Hotel" class="form-control app_select2" style="width:100%">
                                                      <option value="">*Select Hotel</option>
                                                  </select>
                                              </td>
                                          </tr>
                                          <script>
                                          $('#city_id1<?=$i?>').select2({minimumInputLength:1});
                                          $('#hotel_id1<?=$i?>').select2();
                                          </script>
                                      </table>
                                      </div>
                                  </div>
                              </div>
                          </div>

                        <?php } ?>
                      </div>
                    </div></div>
                    <hr/>
                  </div>
                </div>
              <?php } ?>
              <div class="row text-center">
                <div class="col-md-12">
                  <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#request_details').modal('show');
function generate_hotels(status,i){
  if(status === 'na')
    $.post('view/generate_hotels.php', { i:i}, function(data){
      $('#optional_hotel_section'+i).html(data);
    })
  else
    $('#optional_hotel_section'+i).html('');
}
function hotel_name_list_load(id)
{
  var count = id.substring(7);
  var city_id = $("#"+id).val();
  $.get( "view/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_id"+count).html( data ) ;                            
  } ) ;   
}

$('#frm_response_save').validate({
    rules:{
        // customer_id : { required : true },
    },
    submitHandler:function(){
          var base_url = $('#base_url').val();
          var request_id = $('#request_id').val();
          var cart_data = JSON.parse($('#cart_data').val());
          var response_arr = new Array();
          for(var i=0;i<cart_data.length;i++){

            var input_name = 'status'+i;
            $('input[name=' + input_name + ']:checked').each(function () {
              var options_arr = new Array();
              var status = $(this).val();
              if(status === "Not Available"){
                
                var table = document.getElementById("tbl_similar_hotels"+i);
                var rowCount = table.rows.length;
                for(var j=0; j<rowCount; j++)
                {
                  var row = table.rows[j];
                  if(row.cells[0].childNodes[0].checked){
                    if(row.cells[2].childNodes[0].value != "" && row.cells[3].childNodes[0].value =="") {
                      error_msg_alert("Select Hotel at row"+(j+1)); return false;
                    }        
                    var hotel_id = row.cells[3].childNodes[0].value;
                    options_arr.push(hotel_id);
                    if(row.cells[2].childNodes[0].value == "")
                    options_arr=[];
                  }
                }
              }
              response_arr.push({
                'id'      : cart_data[i]['id'],
                'status'  : status,
                'options' : options_arr
              }
              );
            });
          }

          $.ajax({
              type: 'post',
              url: base_url+'controller/b2b_customer/availability_request/response_save.php',
              data:{request_id: request_id, response_arr: response_arr},
              success: function(result){
                var msg = result.split('--');
                if(msg[0]=='error'){
                  error_msg_alert(msg[1]);
                  return false;
                }else{
                  success_msg_alert(msg[0]);
                  $('#request_details').modal('hide');
		              list_reflect();
                }
              }
          });
    }
});

</script>