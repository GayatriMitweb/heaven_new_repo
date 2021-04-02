<?php 
header("Content-type: text/css");
?>

/*=================Visa css start==================*/
#frm_visa_save .fieldset,
#frm_visa_update .fieldset,
#frm_passport_save .fieldset,
#frm_passport_update .fieldset,
#frm_ticket_save .fieldset,
#frm_pnr_invoice .fieldset,
#frm_ticket_update .fieldset{
 position: relative;
 padding-top: 25px;
}
#frm_visa_save .fieldset legend,
#frm_visa_update .fieldset legend,
#frm_passport_save .fieldset legend,
#frm_passport_update .fieldset legend,
#frm_ticket_save .fieldset legend,
#frm_pnr_invoice .fieldset legend,
#frm_ticket_update .fieldset legend{
    position: absolute;
    top: -12px;
    color: #2b2b2b;
    font-size: 16px;
    border-bottom: 0;
    background: #fff;
    width: auto;
    padding: 0 4px;
}

#tbl_dynamic_visa input[type="text"], 
#tbl_dynamic_visa_update input[type="text"],
#tbl_dynamic_visa select, 
#tbl_dynamic_visa_update select,
#tbl_dynamic_visa textarea, 
#tbl_dynamic_visa_update textarea{
	height: 30px;
	font-size: 12px;
}
#tbl_dynamic_visa select[name="received_documents"], 
#tbl_dynamic_visa_update select[name="received_documents"]{
	height: 50px;
}
#tbl_dynamic_visa td, 
#tbl_dynamic_visa_update td{
    padding: 8px 4px;
}


/*=================Visa css end==================*/

/*=================Passport css start==================*/
#tbl_dynamic_passport select[name="received_documents"], 
#tbl_dynamic_passport_update select[name="received_documents"]{
	height: 50px;
}
/*=================Passport css end==================*/

/*=================Air ticket css start==================*/
#tbl_dynamic_ticket_master input[type="text"], 
#tbl_dynamic_ticket_master select, 
#tbl_dynamic_ticket_master textarea{
    height: 30px;
    font-size: 12px;
}
#tbl_dynamic_ticket_master td{
    padding: 8px 4px;
}

#sec_ticket_save li, #sec_pnr_invoice li{
    float: initial;
    display:inline-block;
}
#sec_ticket_save ul, #sec_pnr_invoice ul{
    text-align: center;
}
#sec_ticket_save li{
    pointer-events: none;
}
/*=================Air ticket css end==================*/