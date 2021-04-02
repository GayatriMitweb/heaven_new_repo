<?php

include "../../../model/model.php";

?>

<form id="frm_save">

<div class="modal fade" id="display_modal1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Inclusion/Exclusion</h4>

      </div>

      <div class="modal-body">

        

          <div class="row mg_bt_10">
            <div class="col-md-12">
              <div class="panel panel-default panel-body app_panel_style feildset-panel mg_bt_30">
                <legend>Inclusion : </legend>
                <ul class="no-marg">
                  <li class="mg_tp_10">Accommodation on twin/Double sharing basis in Deluxe hotels.</li>
                  <li class="mg_tp_10">Return Air fare</li>
                  <li class="mg_tp_10">Extra bed for the extra Adult, Child (above 12 yrs) Child without bed (5-11 Yrs) i.e. Aa Per tour cost paid.</li>
                  <li class="mg_tp_10">Internal transfers &amp; sightseeing by AC vehicle some sightseeings by Non AC small vehicleas tour iternary.</li>
                  <li class="mg_tp_10">Food Plan As per tour Iternary.</li>
                  <li class="mg_tp_10">Tour Escort.</li>
                  <li class="mg_tp_10">Per day per person 2 ltrs drinking water bottle. (except Infant).</li>
                  <li class="mg_tp_10">Porter charges except itinerary.</li>
                  <li class="mg_tp_10">Service Charges.</li>
                  <li class="mg_tp_10">All meals included (breakfast, lunch, dinner)</li>
                  <li class="mg_tp_10">Daily one mineral water</li>
                </ul>
              </div>
            

              <div class="panel panel-default panel-body app_panel_style feildset-panel">
                <legend>Exclusions : </legend>
                <ul class="no-marg">
                  <li class="mg_tp_10">Onward and return train/air ticket fare & food.</li>
                  <li class="mg_tp_10">Optional sightseeing.</li>
                  <li class="mg_tp_10">Any increase in any applicability of new taxes from Government.</li>
                  <li class="mg_tp_10">Entrance fees.</li>
                  <li class="mg_tp_10">Any upgradation in class or hotel room category.</li>
                  <li class="mg_tp_10">Cost of Insurance.</li>
                  <li class="mg_tp_10">Cost of Pre / Post tour hotel accommodation.</li>
                  <li class="mg_tp_10">Any extra expense such as route change, Airline change, Date change, Accommodation facilities, etc. incurred due to the unforeseen, unavoidable forced major circumstances during the tour.</li>
                  <li class="mg_tp_10">Personal expenses like – tipping, laundry, telephone charges, shopping, beverages, mineral water other than commitment, items of personal nature and food /drink which is not part of a set group menu.</li>
                  <li class="mg_tp_10">Any extra cost incurred on behalf of an individual due to illness, accident, hospitalization, or any personal emergency.</li>
                  <li class="mg_tp_10">Any services or activity charges other than those included in the group tour itinerary.</li>
                  <li class="mg_tp_10">Anything specifically not mentioned in the “Tour Cost Includes” column.</li>
                  <li class="mg_tp_10">Porterage (coolie charges), laundry, telephone charges, shopping , or extra beverages mineral water, items of personal nature </li>
                </ul>
              </div>    
              </div>
          </div>      

      </div>

  </div>
</div>
</div>

</form>

<script>

$('#display_modal1').modal('show');

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>