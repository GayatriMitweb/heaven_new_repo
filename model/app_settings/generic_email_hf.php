<?php
class email_hf{
    public function mail_header(){
        global $app_name, $app_contact_no, $admin_logo_url, $app_website, $app_email_id;
        global $theme_color;
        $header = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="format-detection" content="date=no">
<meta name="format-detection" content="telephone=no"/>
<meta name="x-apple-disable-message-reformatting">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Roboto:400,300,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
	<style type="text/css">
    .ReadMsgBody { width: 100%; background-color: #ffffff;}
    .ExternalClass {width: 100%; background-color: #ffffff;}
    .ExternalClass, .ExternalClass p, .ExternalClass span,
    .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
    #outlook a { padding:0;}
    html,body {margin: 0 auto !important; padding: 0 !important; height: 100% !important; width: 100% !important; background-color: #ffffff;}
    * {-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;}
    table,td {mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important;}
    table {border-spacing: 0 !important;}
    table table table {table-layout: auto;}
    table td {border-collapse:collapse;}
    table p {margin:0;}
    img {height: auto !important; line-height: 100%; outline: none; text-decoration: none !important; -ms-interpolation-mode:bicubic;}
    br, strong br, b br, em br, i br { line-height:100%; }
    div, p, a, li, td { -webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
    h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
    span a ,a { text-decoration: none !important;}
    .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited,
    .yshortcuts a:hover, .yshortcuts a span { text-decoration: none !important; border-bottom: none !important;}
      p{ display:block !important}
    /*mailChimp class*/
    .default-edit-image{height:20px;}
    ul{padding-left:10px; margin:0;}
    .tpl-repeatblock {padding: 0px !important; border: 1px dotted rgba(0,0,0,0.2);}
    .tpl-content {padding:0px !important;}
      #show-table, #show-table td{
         border: 1px solid #888888 !important;
         font-family: \'Open Sans\', Arial, Helvetica, sans-serif;
         color: #888888 !important;
      }
    @media only screen and (max-width:640px){
    .full-width,.container{width:95%!important; float:none!important; min-width:95%!important; max-width:95%!important; margin:0 auto!important; padding-left:15px; padding-right:15px; text-align: center!important; clear: both;}
    #mainStructure, #mainStructure .full-width .full-width,table .full-width .full-width, .container .full-width{width:100%!important; float:none!important; min-width:100%!important; max-width:100%!important; margin:0 auto; clear: both; padding-left:0; padding-right:0;}
    .no-pad{padding:0!important;}
    .full-block{display:block!important;}
    .image-full-width,
    .image-full-width img{width:100%!important; height:auto!important; max-width:100%!important;}
    .full-width.fix-800{min-width:auto!important;}
    .remove-block{display:none !important;}
    .pad-lr-20{padding-left:20px!important; padding-right:20px!important;}
    #logo{margin:0px auto;}
    #give_margin{margin-top:25px !important;}
    }

    @media only screen and (max-width:480px){
    .full-width,.container{width:95%!important; float:none!important; min-width:95%!important; max-width:95%!important; margin:0 auto!important; padding-left:15px; padding-right:15px; text-align: center!important; clear: both;}
    #mainStructure, #mainStructure .full-width .full-width,table .full-width .full-width,.container .full-width{width:100%!important; float:none!important; min-width:100%!important; max-width:100%!important; margin:0 auto; clear: both; padding-left:0; padding-right:0;}
    .no-pad{padding:0!important;}
    .full-block{display:block!important;}
    .image-full-width,
    .image-full-width img{width:100%!important; height:auto!important; max-width:100%!important;}
    .full-width.fix-800{min-width:auto!important;}
    .remove-block{display:none !important;}
    .pad-lr-20{padding-left:20px!important; padding-right:20px!important;}
    #logo{margin:0px auto;}
    #give_margin{margin-top:25px !important;}
    }
    
    td ul{list-style: initial; margin:0; padding-left:20px;}
	body{background-color:#ffffff; margin: 0 auto !important; } .default-edit-image{height:20px;} tr.tpl-repeatblock , tr.tpl-repeatblock > td{ display:block !important;} .tpl-repeatblock {padding: 0px !important;border: 1px dotted rgba(0,0,0,0.2); }
	@media only screen and (max-width: 640px){ .row{display:table-row!important;} .image-100-percent{ width:100%!important; height: auto !important; max-width: 100% !important; min-width: 124px !important;}}
	@media only screen and (max-width: 480px){ .row{display:table-row!important;}}

	*[x-apple-data-detectors],
	.unstyle-auto-detected-links *,
	.aBn{border-bottom: 0 !important; cursor: default !important;color: inherit !important; text-decoration: none !important;font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important;line-height: inherit !important;}
	.im {color: inherit !important;}
	.a6S {display: none !important; opacity: 0.01 !important;}
	img.g-img + div {display: none !important;}
	a img{ border: 0 !important;}
	a:active{color:initial } a:visited{color:initial }
	span a{color:inherit;}
	.tpl-content{padding:0 !important;}
	table td ,table th{border-collapse:collapse; display:table-cell!important;}
	table,td,th, img{min-width:0!important;}
	#mainStructure{padding:0 !important;}
	span,p{display:inline!important;}
	.row{display:flex;}
	</style>
</head>
        <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; max-width: 800px; outline: rgb(239, 239, 239) solid 1px; box-shadow: rgb(224, 224, 224) 0px 0px 30px 5px; margin: 0px auto;" bgcolor="#ffffff">
        <tr>
      <td align="center" valign="top" class="full-width" style="background-color: '.$theme_color.';" bgcolor="'.$theme_color.'">
         <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: '.$theme_color.'; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="'.$theme_color.'">
            <tr>
               <td valign="top">
                  <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">            
                     <tr>
                        <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                     </tr>
                     <tr>
                        <td valign="top">
                           <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                              <tr class="row" style="display: flex;">

                                 <th valign="top" class="full-block full-width" style="display: table; margin: 0px auto;">
                                    <table width="auto" align="left" border="0" cellspacing="0" cellpadding="0" class="full-width left" role="presentation" style="min-width: 100%;">
                                       <tr>
                                          <td valign="top" align="center" dup="0">
                                             <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                <tr>
                                                   <td align="left" valign="middle" width="auto">
                                                      <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                         <tr>
                                                            <td align="left" valign="top" style="padding-right: 10px; width: 15px; line-height: 0px;" width="15">
                                                            <img src="http://itwebservice.in/emailer/img/world-icon-white.png" width="15" style="max-width: 15px; display: block !important; " vspace="0" hspace="0" alt="icon-world"></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                   <td align="left" style="font-size: 14px; color: #ffffff; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;  line-height: 1;">
                                                      <span style="text-decoration: none; color: #ffffff; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;">
                                                         <a href="#" style="color: #ffffff; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;" border="0">'.$app_email_id.'</a>
                                                      </span>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </th>
                                 <th valign="top" class="full-block full-width" width="336" style="width: 336px; display: table; margin: 0px auto;">
                                    <table width="25" border="0" cellpadding="0" cellspacing="0" align="left" class="full-width left" style="max-width: 25px; border-spacing: 0px; min-width: 100%;" role="presentation">
                                       <tr>
                                          <td height="20" width="25" style="border-collapse: collapse; height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                       </tr>
                                    </table>
                                 </th>
                                 <th valign="top" class="full-block full-width" width="116" style="width: 116px; display: table; margin: 0px auto;">
                                    <table width="auto" align="right" border="0" cellpadding="0" cellspacing="0" class="full-width right" role="presentation" style="min-width: 100%;">
                                       <tr>
                                          <td valign="top" align="center" dup="0">
                                             <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                <tr>
                                                   <td align="left" valign="middle" width="auto">
                                                      <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                         <tr>
                                                            <td align="left" valign="top" style="padding-right: 10px; width: 15px; line-height: 0px;" width="15">
                                                            <img src="http://itwebservice.in/emailer/img/phone-icon-white.png" width="15" style="max-width: 15px; display: block !important; " vspace="0" hspace="0" alt="set6-icon-phone"></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                   <td align="left" style="font-size: 14px; color: #ffffff; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; line-height: 1;">
                                                      <span style="text-decoration: none; color: #ffffff; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;">
                                                         '.$app_contact_no.'
                                                      </span>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </th>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">   
         <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
            <tr>
               <td valign="top">
                  <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">                 
                     <tr>
                        <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                     </tr>
                     <tr style="display: table;" id="logo">
                        <td valign="top">
                           <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">                     
                              <tr>
                                 <td valign="top" align="left" width="136" style="width: 136px; line-height: 0px;">
                                 <a href="'.$app_website.'" target="blank">
                                 <img src="'.BASE_URL.'/images/Admin-Area-Logo.png" style="width: 170px;" style="max-width: 15px; display: block !important; " vspace="0" hspace="0" alt="icon-logo">
                              </a></td>
                              </tr>         
                           </table>
                        </td>
                     </tr>
                     <tr dup="0">
                        <td valign="top" align="center">
                           <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                              <tr>
                                 <td valign="top">
                                    <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                       <tr>
                                          <td align="center" style="font-size: 14px; color: #888888 !important; font-weight: 300; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td align="center" class="full-width no-pad" valign="top" style="background-color: #f4f6f7;" bgcolor="#f4f6f7">   
         <table width="800" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width fix-800" style="background-color: #f4f6f7; max-width: 800px; margin: 0px auto; min-width: 100%;" role="presentation" bgcolor="#f4f6f7">
            <tr>
               <td valign="top" align="center">
                  <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                     <tr>
                        <td valign="top" align="center">
                           <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                              <tr class="row" style="display: flex;">                      
                                 <th valign="top" colspan=2 class="full-block full-width" style="display: table; margin: 0px 113px; width:90%">
                                    <table width="100%" align="right" border="0" cellspacing="0" cellpadding="0" class="full-width right" style="max-width: 100%; min-width: 100%;" role="presentation">
                                       <tr dup="0">
                                          <td valign="top" >
                                             <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">                                                
                                               <tr>
                                                   <td valign="top" height="40" style="height: 40px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                </tr>
                                                <tr dup="0">
                                                   <td valign="top">
                                                      <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr dup="0">
                                                   <td valign="top">
                                                      <table width="94%" align="center" border="0" cellspacing="0" cellpadding="1" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                         <tr>
                                                            <td align="left" style="font-size: 14px; color: #888888 !important; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #888888 !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;"> ';
                                                            return $header;
}
public function mail_footer(){
          global $app_email_id_send, $app_address, $theme_color,$app_name, $app_send_contact_no;
           $footer = '
       
   </table>
   </td>
    </tr>
    </table>
    <tr>
                        <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                     </tr>
    </td>
    </tr>
    </table>
    </th>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td align="center" valign="top" class="full-width" style="background-color: #ffffff;" bgcolor="#ffffff">
       <table align="center" id="mainStructure" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; padding-left: 25px; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
          <tr>
             <td valign="top">
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="full-width" style="margin: 0px auto; width: 548px; min-width: 280px; max-width: 90%;" role="presentation">
                   <tr>
                      <td valign="top" height="50" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                   </tr>
                   <tr>
                      <td valign="top">
                         <table width="96%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                            <tr class="row" style="display: flex;">
                               <th valign="top" class="full-block full-width" width="266" style="width: 100%; display: table;">
                                  <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" class="full-width right" style="max-width: 100%; min-width: 100%;" role="presentation">
                                     <tr dup="0">
                                        <td valign="top" align="left">
                                           <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                              <tr>
                                                 <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"> <span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 600; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;">CONTACT US
     </span>
                                                 </td>
                                              </tr>
                                              <tr>
                                                 <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                              </tr>
                                           </table>
                                        </td>
                                     </tr>
                                     <tr>
                                        <td valign="top">
                                           <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                           <tr class="row" style="display: flex;">
                                              <th valign="top" class="full-block full-width" style="width:50%; display: table; margin: 0px auto;">
                                              <table width="auto" align="left" border="0" cellspacing="0" cellpadding="0" class="full-width left" role="presentation" style="min-width: 100%;">
                                                 <tr>
                                                    <td valign="top" align="center" dup="0">
                                                       <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                          <tr>
                                                                <td align="left" style="padding-right:20px;width:60%;font-size: 14px;color: #888888 !important; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                      <span style="text-decoration: none; color: #888888 !important; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;">
                                                                      '.$app_address.'
                                                                      </span>
                                                                   </td>
                                                          </tr>
                                                       </table>
                                                    </td>
                                                 </tr>
                                              </table>
                                             </th>
                                     <th valign="top" id="give_margin" class="full-block full-width" style="width: 50%; display: table; margin: 0px auto;">
                                     <table width="auto" align="right" border="0" cellpadding="0" cellspacing="0" class="full-width right" role="presentation" style="min-width: 100%;">
                                        <tr>
                                              <td align="left" style="font-size: 14px;width:40%; color: #888888 !important; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                    <span style="text-decoration: none; color: #888888 !important; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;">Mail&nbsp;&nbsp;:&nbsp;&nbsp;
                                                    <a href="mailto:'.$app_email_id_send.'" style="color: '.$theme_color.'!important; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;" border="0">'.$app_email_id_send.'</a></span><br style="font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;"><span style="text-decoration: none; color: #888888 !important; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;">Call Us&nbsp;&nbsp;:&nbsp;&nbsp;<a href="#" style="color:'.$theme_color.'!important; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;" border="0">'.$app_send_contact_no.'</a></span>
                                                 </td>
                                        </tr>
                                     </table>
                         </th> 
                                              </tr>
                                           </table>
                                        </td>
                                     </tr>
                                  </table>
                               </th>
                            </tr>
                         </table>
                      </td>
                   </tr>
                   <tr>
                      <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                   </tr>
                </table>
             </td>
          </tr>
       </table>
    </td>
    </tr>
    <tr>
       <td valign="top" align="center" style="background-color:'.$theme_color.';" bgcolor="'.$theme_color.'">
          <table width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: '.$theme_color.'; margin: 0px auto; min-width: 320px; max-width: 90%;" class="full-width" role="presentation" bgcolor="'.$theme_color.'">
             <tr>
                <td valign="top" align="center">
                   <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                      <tr>
                         <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                      </tr>
                      <tr>
                         <td valign="top" align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                               <tr>
                                  <td valign="middle" align="center">
                                     <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                        <tr>
                                           <td align="center" style="font-size: 14px; color: #ffffff; font-weight: normal; font-family: \'Open Sans\', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
    <span style="text-decoration: none; color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: \'Open Sans\', Arial, Helvetica, sans-serif;">
    © '.date("Y").' '.$app_name.' All rights reserved.
    </span>
                                           </td>
                                        </tr>
                                     </table>
                                  </td>
                               </tr>
                            </table>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                      </tr>
                   </table>
                </td>
             </tr>
          </table>
       </td>
    </tr>
    </table>';
    return $footer;     
    }
    
}?>