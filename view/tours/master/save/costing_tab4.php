<form id="frm_tour_master_save"> 

<div class="app_panel">
<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
		<div class="container">
			<h2 class="pull-left"></h2>
			<div class="pull-right header_btn">
				<button>
					<a>
						<i class="fa fa-arrow-right"></i>
					</a>
				</button>
			</div>
		</div>
    </div> 
<!--=======Header panel end======-->
  <div class="container">
        
        <div class="row text-center">   
            <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 
                <input type="text" id="txt_tour_cost" name="txt_tour_cost" onchange="validate_balance(this.id)" class="form-control" placeholder="*Adult Cost" title="Adult Cost"  maxlength="10"/>
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 
                <input type="text" id="txt_child_with_cost" name="txt_child_with_cost" onchange="validate_balance(this.id)" class="form-control"  placeholder="*CWB Cost" title="CWB Cost" maxlength="10" />
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 
                <input type="text" id="txt_child_without_cost" name="txt_child_without_cost" onchange="validate_balance(this.id)" class="form-control"  placeholder="CWOB Cost" title="CWOB Cost" maxlength="10" />
            </div>                         
            <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 
                <input type="text" id="txt_infant_cost" name="txt_infant_cost" onchange="validate_balance(this.id)" class="form-control"  placeholder="*Infant Cost" title="Infant Cost" maxlength="10" />
            </div>
        </div>
        <div class="row mg_tp_10 text-center"> 
            <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 
                <input type="text" id="with_bed_cost" onchange="validate_balance(this.id)" name="with_bed_cost" placeholder="*Extra bed cost" title="Extra bed cost">
            </div> 
        </div>
        <div class="row mg_tp_20">                         
            <div class="col-md-6 col-sm-6 mg_bt_10_sm_xs">
                <h3 class="editor_title">Inclusions</h3>
                <textarea class="feature_editor" id="inclusions" name="inclusions" placeholder="*Inclusions" title="Inclusions" rows="4"></textarea>
            </div>      
            <div class="col-md-6 col-sm-6"> 
                <h3 class="editor_title">Exclusions</h3>
                <textarea class="feature_editor" id="exclusions" name="exclusions" class="form-control"  placeholder="*Exclusions" title="Exclusions" rows="4"></textarea>

            </div>   
        </div>
        <div class="row mg_bt_10 mg_tp_20 text-center">
            <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab3()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
            &nbsp;&nbsp;<button class="btn btn-sm btn-success" id="btn_save" ><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</div>
</form>

<script>

function switch_to_tab3(){ 
    $('#tab4_head').removeClass('active');
	$('#tab3_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab3').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

</script>