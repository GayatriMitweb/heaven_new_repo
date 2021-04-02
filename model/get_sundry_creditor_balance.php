<?php
class sundry_creditor_master{

	function sundry_creditor_balance_update()
	{
		//sum of opening balalnce of each vendor
		$sq_hotel_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from hotel_master"));
		$sq_tranport_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from transport_agency_master"));
		$sq_dmc_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from dmc_master"));
		$sq_car_rental_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from car_rental_vendor"));
		$sq_visa_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from visa_master"));
		$sq_passport_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from passport_master"));
		$sq_ticket_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from ticket_master"));
		$sq_train_ticket_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from train_ticket_master"));
		$sq_site_seeing_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from site_seeing_vendor"));
		$sq_insuarance_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from insuarance_vendor"));
		$sq_other_vendors_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from other_vendors"));
		$sq_cruise_balance = mysql_fetch_query(mysql_query("select sum(opening_balance) as opening_balance from cruise_master"));

		//total sum of opening balance
		$total_sundry_balance = $sq_hotel_balance['opening_balance'] + $sq_tranport_balance['opening_balance'] + $sq_dmc_balance['opening_balance'] + $sq_car_rental_balance['opening_balance'] + $sq_visa_balance['opening_balance'] + $sq_passport_balance['opening_balance'] + $sq_ticket_balance['opening_balance'] + $sq_train_ticket_balance['opening_balance'] + $sq_site_seeing_balance['opening_balance'] + $sq_insuarance_balance['opening_balance'] + $sq_other_vendors_balance['opening_balance'] + $sq_cruise_balance['opening_balance'];

		//update sundry creditor opening balance
		$sq_bank = mysql_query("update gl_master set  gl_balance='$total_sundry_balance' where gl_id='108'");
	}
}
?>