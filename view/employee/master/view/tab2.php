<div class="row">

	<div class="col-md-12">

        <h3 class="editor_title">Bank Information</h3>
		<div class="panel panel-default panel-body app_panel_style">
			<div class="profile_box main_block">

        	 	<div class="row">

	        	 	<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd; min-height: 50px;">

		        		<span class="main_block">

			                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			                  <?php echo "<label>Bank Name <em>:</em></label> ".$sq_emp['bank_name'] ?>

			            </span>

			            <span class="main_block">

			                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			                  <?php echo "<label>Branch Name <em>:</em></label> ".$sq_emp['branch_name']; ?>

			            </span>
			       	</div>
			       	<div class="col-md-6">
			            <span class="main_block">

			                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			                  <?php echo "<label>IFSC/Swift Code <em>:</em></label> ".$sq_emp['ifsc']; ?>

			            </span>

			            <span class="main_block">

			                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			                  <?php echo "<label>A/c No. <em>:</em></label> ".$sq_emp['acc_no']; ?>

			            </span>	
	               
		        </div>
		   	</div>
	    </div>
		</div>
	</div>

	<div class="col-md-12 mg_tp_10">
		 <h3 class="editor_title">Salary Information</h3>
		 <div class="panel panel-default panel-body app_panel_style">
		 	<div class="profile_box main_block">
			 	<h5 class="mg_bt_20">Monthly Package</h5>
			   	<div class="row">
			   		
				 	<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd; min-height: 105px;">		        

					 		 <span class="main_block">

				              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				              <?php echo "<label>Basic Pay <em>:</em></label> ".number_format($sq_emp['basic_pay'],2)?> 

				            </span>


				            <span class="main_block">


				                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				                  <?php echo "<label>Dearness Allowance <em>:</em></label> ".number_format($sq_emp['dear_allow'],2); ?>

				            </span>

				            <span class="main_block">

				                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				                  <?php echo "<label>HRA <em>:</em></label> ".number_format($sq_emp['hra'],2); ?>

				            </span>

				            <span class="main_block">

				                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				                  <?php echo "<label>Travel Allowance <em>:</em></label> ".number_format($sq_emp['travel_allow'],2); ?>

				            </span>

				            <span class="main_block">

				              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				              <?php echo "<label>Medical Allowance <em>:</em></label> ".number_format($sq_emp['medi_allow'],2); ?>

				            </span>
				        </div>
				    <div class="col-md-6">		        

				 		 <span class="main_block">

				          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				          <?php echo "<label>Special Allowance <em>:</em></label> ".number_format($sq_emp['special_allow'],2)?>

				        </span>


				        <span class="main_block">


				              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				              <?php echo "<label>Uniform Allowance <em>:</em></label> ".number_format($sq_emp['uniform_allowance'],2); ?>

				        </span>

				        <span class="main_block">

				              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				              <?php echo "<label>Incentives <em>:</em></label> ".number_format($sq_emp['incentive'],2); ?>

				        </span>

				        <span class="main_block">

				              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				              <?php echo "<label>Meal Allowance <em>:</em></label> ".number_format($sq_emp['meal_allowance'],2); ?>

				        </span>

				        <span class="main_block">

				          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

				          <?php echo "<label>Gross Salary <em>:</em></label> ".number_format($sq_emp['gross_salary'],2); ?>

		                </span>
			        </div>
			    </div>
	    	</div>

	    	<div class="profile_box main_block">
	    	<hr>

	        <h5 class="mg_bt_20">Deductions</h5>

	        <div class="row">

	            <div class="col-md-6" style="border-right: 1px solid #ddd">

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Employer PF <em>:</em></label> ".number_format($sq_emp['employer_pf'],2); ?>

	                </span>

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Employee PF <em>:</em></label> ".number_format($sq_emp['employee_pf'],2); ?>

	                </span>
	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>PT <em>:</em></label> ".number_format($sq_emp['pt'],2); ?>

	                </span>	

                	<span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>ESIC <em>:</em></label> ".number_format($sq_emp['esic'],2); ?>

	                </span>	

	               
	        	</div>

	        	<div class="col-md-6">
	        		

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>TDS <em>:</em></label> ".number_format($sq_emp['tds'],2); ?>

	                </span>	
	                 <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Labour Welfare Fund<em>:</em></label> ".number_format($sq_emp['labour_all'],2); ?>

	                </span>	
	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Total Deductions <em>:</em></label> ".number_format($sq_emp['deduction'],2); ?>

	                </span>		                

	        	</div>

	        	</div>

			</div>



			 <div class="profile_box main_block">
	 			<hr>
		        <div class="row">

		            <div class="col-md-6" style="border-right: 1px solid #ddd">

		                <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Net Salary <em>:</em></label> ".number_format($sq_emp['net_salary'],2); ?>

		                </span>

		        	</div>

		        	</div>

				</div>

		 </div>
	</div>
</div> 

