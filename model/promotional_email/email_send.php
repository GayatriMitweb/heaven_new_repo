<?php 
class email_send
{
///////////////////////// Monthly Offer ////////////////////////////////
public function monthly_offer_send_mail($template_id,$group_id)
{
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	{
		$email_id = $row_email_group['email_id_id'];
	 	$sq_email = mysql_query("select * from sms_email_id where email_id_id = '$email_id'");

		while($row_email=mysql_fetch_assoc($sq_email)){

			$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
			$to_email_id = $row_email['email_id'];
			
		}
 
		$content = '
		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
			<tbody><tr>
			<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/monthly-offer.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    	color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a> 
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
			 	    $subject = "Monthly Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);

		}
	echo "Mail Sent Successfully";

	}
////////////////////////////////////// Easter //////////////////////////////////	
	public function easter_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];
			 	    $content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody><tr>
																<td class="editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 13px; line-height: 1.2; color: rgb(158, 158, 158); outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">
																	
																</td>
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/easter-day.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';
			 	    $subject = "Easter Offer!!! ".$app_name;		

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);

		}
	echo "Mail Sent Successfully";
	}
//////////////////////////////////// Halloween ///////////////////////////////////////	///
	public function halloween_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];
			 	    $content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/halloween-day.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
		
			 	    $subject = "Halloween Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";
	}
/////////////////////////////// women special //////////////////////////////////////////////
	public function women_special_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];
			 	    $content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/womens-special.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF </div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';
		
			 	    $subject = "Women's Special Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";
	}
/////////////////////////////// Senior Citizen //////////////////////////////////////////////
	public function senior_citizen_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];
			 	    $content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/senior-citizens.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a> 
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
		
			 	    $subject = "Senior Citizen Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";

	}
////////////////////////////////// Repeater offer/////////////////////////////////////	
	public function repeater_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];


			 	    $content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/repeater-offer.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
		
			 	    $subject = "Repeater Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";

	}

	/////////////////////////////// Full Payment ///////////////////////////////
	public function full_payment_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];


			$content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/full-payment.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
		
			 	    $subject = "Full Payment Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";

	}
	////////////////////////////// valentine day //////////////////////////////
	public function valentine_day_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];
			 	    $content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/valentine-day.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';
		
			 	    $subject = "Valentine Day Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";

	}
	////////////////////////////// thanks giving ///////////////////////////////////
	public function thanks_giving_send_mail($template_id,$group_id)
	{
			global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/thanksgiving.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';
			 	
			 	$subject = "Thanks Giving Offer!!! ".$app_name;			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";

	}
	////////////////////////////// Father's day //////////////////////////
	public function father_day_send_mail($template_id,$group_id){
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family:Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/fathers-day.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
					<tbody><tr>

						<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tbody><tr>
									<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
								</tr>

								<tr>
									<td>
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
											<tbody><tr>
												<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
							<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
								</td>
								<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

								</td>

							</tr>
						</tbody></table>
					</td>
				</tr>
				<tr>
					<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>					
						
						</td>
						</tr>
						</tbody></table>
				</td>
			</tr>
			
				
		</tbody></table>
	</td>
	</tr>
	<tr>
	<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	</tr>
	</tbody></table>
	</td>
	<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	</tr>
	</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
		<tbody><tr>
			<td width="50%" valign="top" class="tdBlock">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tbody><tr>
						<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tbody><tr>
									<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									<td>
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
											<tbody><tr>
												<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
											</tr>
											<tr>
												<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
													Special Offers
												</td>
											</tr>
											<tr>
												<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
											</tr>
											<tr>
												<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
													'.$sq_template['description'].'
												</td>
											</tr>
											<tr>
												<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
											</tr>
											<tr>
												<td>
		<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
		<tbody><tr>
		<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>
				<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
				</tr>
			<tr>
			<td>
	   <table cellspacing="0" cellpadding="0" border="0" width="100%">
	   <tbody><tr>																						
	   <td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">
	   </td>																								
			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">																			
		    <a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>							
		</td>																						
	    <td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>

			</tr>
	</tbody></table>
</td>
</tr>
<tr>
			<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
					</tr>
				</tbody></table>
			</td>
		</tr>
	</tbody></table>
</td>
</tr>

<tr>
	<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
	</tr>
																	
			</tbody></table>
		</td>
		<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	</tr>
</tbody></table>
</td>
<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
</tr>
</tbody></table>
</td>

</tr>
</tbody></table>								
										
		</td>
		</tr>
		</tbody></table>
		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';
			 	    $subject = "Father's Day Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";
	}
	////////////////////////// Mother's day ///////////////////////////////////////
	public function mother_day_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/mothers-day.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																									<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																										<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																									</td>
																									<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																									</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
																										<table cellspacing="0" cellpadding="0" border="0" width="100%">
																											<tbody><tr>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																												
																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																												</td>
																												<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																											</tr>
																										</tbody></table>
																									</td>
																								</tr>
																								<tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
																									<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
			 	    $subject = "Mother's Day Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";
	}
	///////////////////////////// new year ////////////////////////////
	public function new_year_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));
	 		$to_email_id = $sq_email['email_id'];

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));

			$content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
			<tbody><tr>
				<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				<td>
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tbody><tr>
							<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
						</tr>
						<tr>
							<td>
								<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
									<tbody>
									<tr>
										<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
									</tr>
								</tbody></table>
								<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
									<tbody><tr>
										
									</tr>
									<tr>
										<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
									</tr>
								</tbody></table>
							</td>
						</tr>
					</tbody></table>
				</td>
				<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
		</tbody></table>										
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
				<tbody><tr>
					<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody><tr>
								<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							<tr>
								<td align="center">
									<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
										<tbody><tr>
											<td align="center">
												<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
											</td>
										</tr>
									</tbody></table>
									<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
										<tbody><tr>
											<td align="center" height="20">
												<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
											</td>
										</tr>
									</tbody></table>
									<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
										<tbody><tr>
											<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										</tr>
										<tr>
											<td>
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tbody><tr>
														<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
															<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
														</td>
														
														<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
															
														</td>
														<td width="24">
															&nbsp; &nbsp; &nbsp; &nbsp;
														</td>
														<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
															<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
														</td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
							<tr>
								<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
						</tbody></table>
					</td>
					<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				</tr>
			</tbody></table>							
										
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/happy-new-year.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
				<tbody><tr>
					<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody><tr>
								<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							<tr>
								
							<tr>
								<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							
							<tr>
								<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							
							<tr>
								<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							<tr>
								<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
							</tr>
							<tr>
								<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							
							<tr>
								<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>

							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
										
										<tbody>
	<tr>
		<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
	</tr>
<tr>

<td align="center">
	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
		<tbody><tr>
<td>									
		<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
		<tbody><tr>

				<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody><tr>
							<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
						</tr>

						<tr>
							<td>
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
									<tbody><tr>
										<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
											<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

											
										</td>
										<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

										</td>

									</tr>
								</tbody></table>
							</td>
						</tr>
						<tr>
							<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody></table>


</td>
</tr>
		</tbody></table>
		</td>
		</tr>															
																
				</tbody></table>
			</td>
		</tr>
		<tr>
			<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
		</tr>
	</tbody></table>
</td>
<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
</tr>
</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
<tbody><tr>
<td width="50%" valign="top" class="tdBlock">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody><tr>
<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
<td>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tbody><tr>
	<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>
				<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
					Special Offers
				</td>
			</tr>
			<tr>
				<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
					'.$sq_template['description'].'
				</td>
			</tr>
			<tr>
				<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td>
					<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
						<tbody><tr>
							<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
									<tbody><tr>
										<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
									</tr>
									<tr>
										<td>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>																		
			<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>			
		    <td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">																				
		   <a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
		   <td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>	
	</tbody></table>
	</td>
</tr>
<tr>
<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
							</tr>
						</tbody></table>
					</td>
				</tr>
			</tbody></table>
		</td>
	</tr>

<tr>
<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
											</tr>
				
				</tbody></table>
			</td>
			<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
		</tr>
	</tbody></table>
</td>
					<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				</tr>
			</tbody></table>
		</td>

	</tr>
</tbody></table>

		
</td>
</tr>
</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';
	  				$subject = "New Year Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
	}
	echo "Mail Sent Successfully";
	}
	////////////////////////// diwali ///////////////////////////
	public function diwali_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = '
						
		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
				<tbody><tr>
					<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody><tr>
								<td height="27"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
										<tbody>
										<tr>
											<td height="7"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
										</tr>
									</tbody></table>
									<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
										<tbody><tr>
											
										</tr>
										<tr>
											<td height="7"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
					</td>
					<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				</tr>
			</tbody></table>
										
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
<tbody><tr>
	<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody><tr>
				<td height="15"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td align="center">
					<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
						<tbody><tr>
							<td align="center">
								<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
							</td>
						</tr>
					</tbody></table>
					<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
						<tbody><tr>
							<td align="center" height="20">
								<img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
							</td>
						</tr>
					</tbody></table>
					<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
						<tbody><tr>
							<td height="4"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
						</tr>
						<tr>
							<td>
								<table cellpadding="0" cellspacing="0" border="0" align="center">
									<tbody><tr>
										<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
											<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
										</td>
										
										<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
											
										</td>
										<td width="24">
											&nbsp; &nbsp; &nbsp; &nbsp;
										</td>
										<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
										<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-bottom: -8px;" href="'.$app_website.'" data-selector="a.editable">contact</a>
										</td>
									</tr>
								</tbody></table>
							</td>
						</tr>
					</tbody></table>
						</td>
					</tr>
					<tr>
						<td height="15" class="height-25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					</tr>
				</tbody></table>
			</td>
			<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
		</tr>
	</tbody></table>						
										
		</td>
		</tr>
		</tbody></table>
		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background: url('.BASE_URL.'/images/templates/happy-diwali.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
				<tbody><tr>
					<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody><tr>
								<td height="72"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							<tr>
								
							<tr>
								<td height="32"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							
							<tr>
								<td height="19"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							
							<tr>
								<td height="12"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							<tr>
								<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src="'.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
							</tr>
							<tr>
								<td height="28"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>
							
							<tr>
								<td height="52"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							</tr>

							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
										
										<tbody>
							<tr>
								<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
							</tr>
											<tr>

											<td align="center">
												<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
													<tbody><tr>
		<td>									
	<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
													<tbody><tr>

														<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
															<table cellspacing="0" cellpadding="0" border="0" width="100%">
																<tbody><tr>
																	<td height="10"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																</tr>

																<tr>
																	<td>
																		<table cellspacing="0" cellpadding="0" border="0" width="100%">
																			<tbody><tr>
																				<td width="27"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																				<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
								<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
											</td>
											<td width="27"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

											</td>

										</tr>
									</tbody></table>
								</td>
							</tr>
							<tr>
								<td height="10"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
							</tr>
						</tbody></table>
					</td>
				</tr>
			</tbody></table>					
						
	</td>
	</tr>
											</tbody></table>
										</td>
									</tr>
									
										
								</tbody></table>
							</td>
						</tr>
						<tr>
							<td><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
						</tr>
					</tbody></table>
				</td>
				<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
		</tbody></table>
																
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src="'.BASE_URL.'images/templates/'.$quotation_icon.'" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="9"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
															</tr>
												<tr>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody>
															<tr>
																<td width="25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																
																<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																	<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																</td>
																<td width="25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="9"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1">
													</td>
												</tr>
											</tbody></table>
										</td>
									</tr>
								</tbody></table>
							</td>
						</tr>
					
					<tr>
				<td height="40">
					
					</tbody></table>
				</td>
					<td width="30"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				</tr>
				</tbody></table>
													</td>
													<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>					
										
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>';
	  				$subject = "Diwali Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";
	}


//////////////////// Chaturthi Offer ////////////////////////////

	public function chaturthi_send_mail($template_id,$group_id)
	{

		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = '	

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src="'.BASE_URL.'images/templates/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src="'.BASE_URL.'images/templates/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/ganesha-chaturthi.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src="'.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																			<table cellspacing="0" cellpadding="0" border="0" width="100%">
													                    <tbody><tr>
																					<td width="27"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																					<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
														<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px;"></a>

																										
																		</td>
																		<td width="27"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																		</td>

																	</tr>
																</tbody></table>
																						</td>
																					</tr>
																					<tr>
																						<td height="10"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="9"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
															</tr>
												<tr>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody>
															<tr>
																<td width="25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																
																<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																	<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																</td>
																<td width="25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="9"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1">
													</td>
												</tr>
											</tbody></table>
										</td>
									</tr>
								</tbody></table>
							</td>
						</tr>
					
					<tr>
				<td height="40">
					
					</tbody></table>
				</td>
					<td width="30"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				</tr>
				</tbody></table>
													</td>
													<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
														<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
															<tbody><tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
	


			 	    ';
	  				$subject = "Ganesha Chaturthi Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";
	}

////////////////////////////////////   Eid Offer  //////////////////////////////////////////////
	public function eid_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-bottom: -8px;" href="'.$app_website.'" data-selector="a.editable">contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/eid-mubarak.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																	<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																	<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																				<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																					</td>
																		<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																				</td>

																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																					<tr>
																	<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
																	<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
																				Special Offers
																			</td>
																		</tr>
																		<tr>
																			<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
																				'.$sq_template['description'].'
																			</td>
																		</tr>
																		<tr>
																			<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																		</tr>
																		<tr>
																			<td>
																				<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
																					<tbody><tr>
																						<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
																							<table cellspacing="0" cellpadding="0" border="0" width="100%">
																								<tbody><tr>
																									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																								<tr>
																									<td>
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
																				<tbody><tr>			
								<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>																																												<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-nter;">																													<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>																												</td>														<td width="25">
												</tr>
											</tbody></table>
											</td>
									</tr>
									<tr>
									<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																							</tbody></table>
																						</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	
																	<tr>
											<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																								</tr>
																	
																	</tbody></table>
																</td>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>

									</tr>
								</tbody></table>							
										
		</td>
		</tr>
		</tbody></table>	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
												<tr>
													<td>
														<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
															<tbody><tr>
																<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
															</tr>
														</tbody></table>
														
														
							<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
								<tbody><tr>
									<td align="center">
										<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
																		<tbody>
																			<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														
														
													</td>
												</tr>
												<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
	  				$subject = "Eid Mubarak Offer!!! ".$app_name;	
			

	  global $model;
	  $model->app_template_email_master($to_email_id, $content, $subject);
}
	echo "Mail Sent Successfully";
	}

	/////////////////////////////// Gudi Padwa ///////////////////////////////////
	public function padwa_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = '
			 	    	<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-top: 10px;" href="'.$app_website.'" data-selector="a.editable">Contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/gudi-padwa.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
																		<tbody><tr>

																			<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
																				<table cellspacing="0" cellpadding="0" border="0" width="100%">
																					<tbody><tr>
																						<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>

																					<tr>
																						<td>
																<table cellspacing="0" cellpadding="0" border="0" width="100%">
																<tbody><tr>
																<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
																<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

																										
																	</td>
																	<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

																	</td>
																	</tr>
																</tbody></table>
															</td>
														</tr>
														<tr>
														<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																	</tbody></table>
						
						
						</td>
						</tr>
																	</tbody></table>
																</td>
															</tr>
															
																
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
																
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
									<tbody><tr>
										<td width="50%" valign="top" class="tdBlock">
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody><tr>
																<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tbody><tr>
									<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
								</tr>
								<tr>
									<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
										Special Offers
									</td>
								</tr>
								<tr>
									<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
								</tr>
								<tr>
									<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">'.$sq_template['description'].'
									</td>
								</tr>
								<tr>
									<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
								</tr>
								<tr>
									<td>
										<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
											<tbody><tr>
												<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
													<table cellspacing="0" cellpadding="0" border="0" width="100%">
																		<tbody><tr>
																			<td height="9"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
															</tr>
												<tr>
													<td>
														<table cellspacing="0" cellpadding="0" border="0" width="100%">
															<tbody>
															<tr>
																<td width="25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
																
																<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
																	<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
																</td>
																<td width="25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="9"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1">
													</td>
												</tr>
											</tbody></table>
			</td>
		</tr>
	
	<tr>
			<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
														</tr>
							
							</tbody></table>
						</td>
						<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					</tr>
				</tbody></table>
			</td>
			<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
		</tr>
	</tbody></table>
</td>

									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
				<tbody><tr>
					<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
							<tr>
								<td>
									<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
										<tbody><tr>
											<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
										</tr>
									</tbody></table>
									
									
									<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
										<tbody><tr>
											<td align="center">
												<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
													<tbody>
														<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
									
									
								</td>
							</tr>
							<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
						</tbody></table>
					</td>
					<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				</tr>
			</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';
			 	    $subject = "Gudi Padwa Offer!!! ".$app_name;	
			

		  global $model;
		  $model->app_template_email_master($to_email_id, $content, $subject);
}
		  echo "Mail Sent Successfully"; 	    
	}
///////////////////////////// Raksha Bandhan ///////////////////////////////	
	public function raksha_bandhan_send_mail($template_id,$group_id)
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];
			 	    $content = '
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-bottom: -8px;" href="'.$app_website.'" data-selector="a.editable">contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/raksha-bandhan.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;"> SALE UP TO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
<tbody><tr>

	<td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>
				<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
			</tr>

			<tr>
				<td>
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody><tr>
							<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
								<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

								
							</td>
							<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

							</td>

						</tr>
					</tbody></table>
											</td>
										</tr>
										<tr>
											<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
</td>
</tr>
						</tbody></table>
					</td>
				</tr>
				
					
			</tbody></table>
		</td>
	</tr>
	<tr>
		<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	</tr>
</tbody></table>
</td>
<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
</tr>
</tbody></table>
																
	</td>
	</tr>
	</tbody></table>



		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
<tbody><tr>
<td width="50%" valign="top" class="tdBlock">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody><tr>
	<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>
				<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				<td>
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody><tr>
							<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
						</tr>
						<tr>
							<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
								Special Offers
							</td>
						</tr>
						<tr>
							<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
						</tr>
						<tr>
							<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
								'.$sq_template['description'].'
							</td>
						</tr>
						<tr>
							<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
						</tr>
						<tr>
		<td>
			<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
					<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tbody><tr>
								<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
							</tr>
							<tr>
								<td>
									<table cellspacing="0" cellpadding="0" border="0" width="100%">
										<tbody><tr>
										<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>											
										<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">
									    <a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>	
									</td>																	
									<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
									</tr>
								</tbody></table>
									</td>
								</tr>
							
							<tr>
							<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
						</tr>
					
					</tbody></table>
				</td>
				<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
		</tbody></table>
				</td>
				<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
		</tbody></table>
	</td>

</tr>
</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
			<tbody><tr>
				<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				<td>
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
						<tr>
							<td>
								<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
									<tbody><tr>
										<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
									</tr>
								</tbody></table>
								
								
								<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
									<tbody><tr>
										<td align="center">
											<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
												<tbody>
													<td><td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td></td>
											</tbody></table>
										</td>
									</tr>
								</tbody></table>
								
								
							</td>
						</tr>
						<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
					</tbody></table>
				</td>
				<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
		</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
			 	    ';

			 $subject = "Raksha Bandhan Offer!!! ".$app_name;	
			

		  global $model;
		  $model->app_template_email_master($to_email_id, $content, $subject);
}
		  echo "Mail Sent Successfully"; 	    
	}

//////////////////////////// christmas /////////////////////////////////	
public function christmas_send_mail($template_id,$group_id)
{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;	 	

	 	$sq_email_group = mysql_query("select * from email_group_entries where email_group_id = '$group_id'");
	 	while($row_email_group = mysql_fetch_assoc($sq_email_group))
	 	{
	 		$email_id = $row_email_group['email_id_id'];
	 		$sq_email = mysql_fetch_assoc(mysql_query("select * from sms_email_id where email_id_id = '$email_id'"));

	 		$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id = '$template_id'"));
	 		$to_email_id = $sq_email['email_id'];

			$content = ' 
			 	    <table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="left" class="device-width txt-center">
															<tbody><tr>
																<td class="editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 13px; line-height: 1.2; color: rgb(158, 158, 158); outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">
																	
																</td>
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" width="49%" align="right" class="device-width txt-center">
															<tbody><tr>
																
															</tr>
															<tr>
																<td height="7"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1" style="display: block;"></td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
										
		</td>
		</tr>
		</tbody></table>
		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff; border: 1px solid #ccc";>
		<tbody><tr>
		<td>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="15"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center">
														<table cellpadding="0" cellspacing="0" border="0" align="left" class="device-width">
															<tbody><tr>
																<td align="center">
																	<a class="editable-lni" href="'.$app_website.'" data-selector="a.editable-lni" style="outline: none; outline-offset: 2px;"><img src="'.$admin_logo_url.'" border="0" width="224" height="83" alt="" style="display: block;"></a>
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" class="device-width" align="left">
															<tbody><tr>
																<td align="center" height="20">
																	<img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1" style="display: block">
																</td>
															</tr>
														</tbody></table>
														<table cellpadding="0" cellspacing="0" border="0" align="right" class="device-width">
															<tbody><tr>
																<td height="4"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
															</tr>
															<tr>
																<td>
																	<table cellpadding="0" cellspacing="0" border="0" align="center">
																		<tbody><tr>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight:500; font-size:15px; display: block; color:#4c4c4c;text-decoration: none" data-selector="a.editable"> <span style="color: #20a69f;"><img src="'.BASE_URL.'images/templates/phone-1.png" style="margin-right: 1px;">+'.$app_contact_no.'</span></a>
																			</td>
																			
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				
																			</td>
																			<td width="24">
																				&nbsp; &nbsp; &nbsp; &nbsp;
																			</td>
																			<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.2; color: #4c4c4c; text-transform: uppercase;">
																				<a class="editable" style="font-weight: 500;font-size: 14px;display: block;color: #ffffff;background: #009898;text-decoration: none;padding: 7px 10px;border-radius: 25px;margin-bottom: -8px;" href="'.$app_website.'" data-selector="a.editable">contact</a>
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td height="15" class="height-25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
											</tbody></table>
										</td>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
									</tr>
								</tbody></table>
								
										
		</td>
		</tr>
		</tbody></table>
	




		<table cellpadding="0" cellspacing="0" border="0" width="600" height="489" align="center" class="wrapper" style="background-image: url('.BASE_URL.'images/templates/Christmas.jpg); background-repeat: no-repeat;">
		<tbody><tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="489" align="center" style="background-repeat: no-repeat; background-position: center top; background-size: auto 100%; -webkit-background-size: auto 100%;">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" width="100%">
												<tbody><tr>
													<td height="72"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													
												<tr>
													<td height="32"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="19"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="12"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable"><img border="0" src='.BASE_URL.'images/templates/heart-line.png" width="127" height="10" style="display: block;" data-selector="div.editable img"></div></td>
												</tr>
												<tr>
													<td height="28"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>
												
												<tr>
													<td height="52"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
												</tr>

												<tr>
													<td>
														<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 60px;">
															
															<tbody>
												<tr>
													<td align="center"><div class="editable" data-selector="div.editable" style="margin-top:40px; margin-bottom:15px; font-family: Roboto, Geneva, sans-serif; font-size: 30px; font-weight: 400;
    color: #fefffd;">SALE UPTO '.$sq_template['offer_amount'].' OFF</div></td>
												</tr>
																<tr>

																<td align="center">
																	<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" width="322" align="right">
																		<tbody><tr>
							<td>									
						<table cellspacing="0" cellpadding="0" border="0" align="left" class="mob_btn spacer">
						<tbody><tr>

				        <td style="border: 1px solid #ffffff; border-radius: 25px; display: block;">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tbody><tr>
								<td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
							</tr>

							<tr>
								<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tbody><tr>
							<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
							<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #ffffff; text-transform: uppercase; text-align: center;">
								<a class="editable" style="color: #ffffff; text-decoration: none; display: block" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" data-selector="a.editable">&nbsp; I LIKE <img border="0" src="'.BASE_URL.'images/templates/thumb-up.png" width="20" height="20" style="padding-bottom:0px; margin-bottom:-1.5px"></a>

							</td>
							<td width="27"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1">

							</td>

						</tr>
					</tbody></table>
				</td>
			</tr>
			<tr>																						
		    <td height="10"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
</td>
</tr>
					</tbody></table>
				</td>
			</tr>
			
				
		</tbody></table>
	</td>
</tr>
<tr>
					<td><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					</tr>
				</tbody></table>
			</td>
			<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
		</tr>
	</tbody></table>
									
</td>
</tr>
		</tbody></table>


		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #ffffff;">
		<tbody><tr>
		<td>
		
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="border:1px solid #ccc">
<tbody><tr>
<td width="50%" valign="top" class="tdBlock">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody><tr>
<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
<td>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tbody><tr>
	<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>
				<td height="41"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 500; font-size: 20px; line-height: 1.2; color: #d72c34;; text-transform: uppercase;" data-selector="td.editable">
					Special Offers
				</td>
			</tr>
			<tr>
				<td height="13"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td class="alignCenetr editable" style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.8; color: #4c4c4c;" data-selector="td.editable">
					'.$sq_template['description'].'
				</td>
			</tr>
			<tr>
				<td height="21"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
			<tr>
				<td>
					<table class="btnCenter" cellspacing="0" cellpadding="0" border="0">
						<tbody><tr>
		<td style="border: 1px solid #d71d26; border-radius: 25px; display: block;">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>
					<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
					</tr>
					<tr>
						<td>
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
					<tbody><tr>											
<td width="25"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>					
<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-str>
<td style="padding: 0px; margin: 0px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 12px; line-height: 1.2; color: #d71d26; text-transform: uppercase; text-align: center;">			
<a class="editable" href="'.BASE_URL.'model/app_settings/template_like_email.php?email_id='.$to_email_id.'&template_id='.$template_id.'" style="color: #d71d26; text-decoration: none; display: block" data-selector="a.editable">INTERESTED</a>
	</td>					
	<td width="25"><img border="0" src="'.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>	
					</tr>
		</tbody></table>
	</td>
</tr>
<tr>
	<td height="9"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
			</tr>
			</tbody></table>
			</td>
			</tr>
		</tbody></table>
	</td>
</tr>																	
				<tr>
				<td height="40"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" alt="" width="1" height="1"></td>
				</tr>										
				</tbody></table>
						</td>
						<td width="30"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
					</tr>
				</tbody></table>
				</td>
				<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
			</tr>
		</tbody></table>
	</td>
			</tr>
			</tbody></table>							
					
		</td>
		</tr>
		</tbody></table>

		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center" class="wrapper" style="background: #2e2e2e;">
		<tbody><tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
									<tbody><tr>
										<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
										<td>
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tbody><tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
								<tr>
									<td>
										<table class="mob_btn spacer" cellpadding="0" cellspacing="0" border="0" align="left">
											<tbody><tr>
												<td class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; outline: none; outline-offset: 2px;" data-selector="td.editable" contenteditable="false">Copyright@2017 IWS</td>
											</tr>
										</tbody></table>
										
										
										<table class="mob_btn" cellpadding="0" cellspacing="0" border="0" align="right">
											<tbody><tr>
												<td align="center">
													<table cellpadding="0" cellspacing="0" border="0" align="center" style="color:#d6d6d6; font-family: Montserrat, Arial, Helvetica, sans-serif; font-size: 12px;">
														<tbody>
															<td><a class="editable" style="color:#d6d6d6; font-size: 12px; line-height: 15px; font-family: Montserrat, Arial, Helvetica, sans-serif; text-decoration: none" href="'.$app_website.'" data-selector="a.editable">'.$app_website.'</a></td>
													</tbody></table>
												</td>
											</tr>
										</tbody></table>
										
										
									</td>
								</tr>
								<tr><td height="18"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td></tr>
							</tbody></table>
					</td>
					<td width="20"><img border="0" src='.BASE_URL.'images/templates/spacer.gif" width="1" height="1"></td>
				</tr>
			</tbody></table>
							  							
		</td>
		</tr>
		</tbody></table>
		';
 
			 $subject = "Christmas Offer!!! ".$app_name;	
			
			
		  global $model;
		  $model->app_template_email_master($to_email_id, $content, $subject);
}
		  echo "Email has been successfully send."; 	    
}
}
?>