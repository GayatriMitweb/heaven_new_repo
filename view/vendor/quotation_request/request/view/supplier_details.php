<br>
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
        <h3 class="editor_title">Supplier Details</h3>
        	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
			
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Supplier_name</th>
							<th>Contact_person_name</th>
							<th>Contact_No</th>
							<th>Email_Id</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						$city_id_temp = array();
						$city_id_temp = explode(",",$sq_req['city_id']);
						$contact_person_arr = array();
						$vendor_name_arr = array();
						$vendor_contact_arr = array();
						$email_arr = array();

						if($sq_req['quotation_for']=="Transport"){
							$sq_transport = mysql_query("select * from transport_agency_master where transport_agency_id in ($sq_req[city_id])");
							while($row_trans = mysql_fetch_assoc($sq_transport)){
								$mobile_no = $encrypt_decrypt->fnDecrypt($row_trans['mobile_no'], $secret_key);
								$email_id = $encrypt_decrypt->fnDecrypt($row_trans['email_id'], $secret_key);
								array_push($contact_person_arr,$row_trans['contact_person_name']);
								array_push($vendor_name_arr,$row_trans['transport_agency_name']);
								array_push($vendor_contact_arr,$mobile_no);
								array_push($email_arr,$email_id);

							}
							for($i=0;$i<sizeof($contact_person_arr);$i++){	
								?>
								<tr>
									<td><?= $count++ ?></td>
									<td><?= $vendor_name_arr[$i] ?></td>
									<td><?= $contact_person_arr[$i] ?></td>
									<td><?= $vendor_contact_arr[$i] ?></td>
									<td><?= $email_arr[$i] ?></td>
								</tr>
								<?php
							}
						}
						if($sq_req['quotation_for']=="DMC"){
							$sq_dmc = mysql_query("select * from dmc_master where dmc_id in ($sq_req[city_id])");
								while($row_dmc = mysql_fetch_assoc($sq_dmc)){
									$mobile_no = $encrypt_decrypt->fnDecrypt($row_dmc['mobile_no'], $secret_key);
									$email_id = $encrypt_decrypt->fnDecrypt($row_dmc['email_id'], $secret_key);
									array_push($contact_person_arr,$row_dmc['contact_person_name']);
									array_push($vendor_name_arr,$row_dmc['company_name']);
									array_push($vendor_contact_arr,$mobile_no);
									array_push($email_arr,$email_id);

								}
								for($i=0;$i<sizeof($contact_person_arr);$i++){	
									?>
									<tr>
										<td><?= $count++ ?></td>
										<td><?= $vendor_name_arr[$i] ?></td>
										<td><?= $contact_person_arr[$i] ?></td>
										<td><?= $vendor_contact_arr[$i] ?></td>
										<td><?= $email_arr[$i] ?></td>
									</tr>
									<?php
								}
						}
						if($sq_req['quotation_for']=="Hotel"){
							$sq_hotel = mysql_query("select * from hotel_master where hotel_id in ($sq_req[city_id])");
							while($row_hotel = mysql_fetch_assoc($sq_hotel)){
								$mobile_no = $encrypt_decrypt->fnDecrypt($row_hotel['mobile_no'], $secret_key);
								$email_id = $encrypt_decrypt->fnDecrypt($row_hotel['email_id'], $secret_key);
								array_push($contact_person_arr,$row_hotel['contact_person_name']);
								array_push($vendor_name_arr,$row_hotel['hotel_name']);
								array_push($vendor_contact_arr,$mobile_no);
								array_push($email_arr,$email_id);
							}
							for($i=0;$i<sizeof($contact_person_arr);$i++){	
								?>
								<tr>
									<td><?= $count++ ?></td>
									<td><?= $vendor_name_arr[$i] ?></td>
									<td><?= $contact_person_arr[$i] ?></td>
									<td><?= $vendor_contact_arr[$i] ?></td>
									<td><?= $email_arr[$i] ?></td>
								</tr>
								<?php
							}
						}
		        	?>
	        		</tbody>
	        	</table>
        	</div> </div> </div>
        </div>
    </div>
</div>
 