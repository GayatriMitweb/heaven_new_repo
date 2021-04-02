var g_validate_status = true;

// Validation for name

function fname_validate (id) {
	var pass1 = document.getElementById(id).value;
	//alert(pass1.length);
	if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('It should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[0-9 ]+$/.test(pass1)) {
		error_msg_alert('It should not allow numbers.');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[A-z ]+$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		var iChars = '!@#$%^&*()+=-[]\\\';,./{}|":<>?';
		var obj = document.getElementById(id).value;
		for (var i = 0; i < obj.length; i++) {
			if (iChars.indexOf(obj.charAt(i)) != -1) {
				error_msg_alert('It should not allow special character.');
				$('#' + id).css({ border: '1px solid red' });
				document.getElementById(id).value = '';
				$('#' + id).focus();
				g_validate_status = false;
				return false;
			}
			else {
				$('#' + id).css({ border: '1px solid #ddd' });
				return true;
			}
		}
	}
}

//Validation for alphanumeric
function validate_alphanumeric (id) {
	//alert('hiiii');
	var pass1 = document.getElementById(id).value;
	var decimal = /^[-+]?[0-9]+\.[0-9]+$/;
	//alert(pass1.length);
	if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('It Should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[A-z0-9 ]+$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else if (pass1.match(decimal) || pass1 < 0) {
		error_msg_alert('Please enter valid name.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		var iChars = '!@#$%^&*()+=-[]\\\';,./{}|":<>?';
		var obj = document.getElementById(id).value;
		for (var i = 0; i < obj.length; i++) {
			if (iChars.indexOf(obj.charAt(i)) != -1) {
				error_msg_alert('It should not allow special character.');
				$('#' + id).css({ border: '1px solid red' });
				document.getElementById(id).value = '';
				$('#' + id).focus();
				g_validate_status = false;
				return false;
			}
			else {
				$('#' + id).css({ border: '1px solid #ddd' });
				return true;
			}
		}
	}
}
//Validation for locations
function locationname_validate (id) {
	var pass1 = document.getElementById(id).value;
	var decimal = /^[-+]?[0-9]+\.[0-9]+$/;
	//alert(pass1.length);
	if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('It Should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[A-z0-9 ]+$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else if (pass1.match(decimal) || pass1 < 0) {
		error_msg_alert('Please enter valid location name.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		var iChars = '!@#$%^&*()+=-[]\\\';,./{}|":<>?';
		var obj = document.getElementById(id).value;
		for (var i = 0; i < obj.length; i++) {
			if (iChars.indexOf(obj.charAt(i)) != -1) {
				error_msg_alert('It should not allow special character.');
				$('#' + id).css({ border: '1px solid red' });
				document.getElementById(id).value = '';
				$('#' + id).focus();
				g_validate_status = false;
				return false;
			}
			else {
				$('#' + id).css({ border: '1px solid #ddd' });
				return true;
			}
		}
	}
}
// Validation for mobile no
function mobile_validate (id) {
	var pass1 = document.getElementById(id).value;
	if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('It Should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[A-z ]+$/.test(pass1)) {
		error_msg_alert('It should not allow alphabets');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (pass1.length > 20) {
		error_msg_alert('It should be less than 20 digits');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (
		/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(pass1) ||
		/^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/.test(
			pass1
		)
	) {
		error_msg_alert('Please enter valid mobile number');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		var iChars = '!@#$%^&*()=-[]\\\';,./{}|":<>?';
		for (var i = 0; i < pass1.length; i++) {
			if (iChars.indexOf(pass1.charAt(i)) != -1) {
				error_msg_alert('It should not allow special character.');
				$('#' + id).css({ border: '1px solid red' });
				document.getElementById(id).value = '';
				$('#' + id).focus();
				g_validate_status = false;
				return false;
			}
			else {
				$('#' + id).css({ border: '1px solid #ddd' });
				return true;
			}
		}
	}

	return true;
}

//Validation for Email
function validate_email (id) {
	var pass1 = document.getElementById(id).value;
	var atposition = pass1.indexOf('@');
	var dotposition = pass1.lastIndexOf('.');
	if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= pass1.length) {
		error_msg_alert('Please enter valid Email Id');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

//Validation for DOB
function checkDate (id) {
	var date = document.getElementById(id).value;

	if (date == '') {
		alert('Please enter the Date..!!');
		return false;
	}
	else if (!date.match(/^(0[1-9]|[12][0-9]|3[01])[\- \/.](?:(0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$/)) {
		alert('date format is wrong');
		return false;
	}

	var today = new Date();
	date = Date.parse(date);
	if (today <= date) {
		alert('Current or future date is not allowed.');
		return false;
	}
}

//Validation for Domain Name
function validate_domain (id) {
	var name = document.getElementById(id).value;
	if (
		!/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/gm.test(
			name
		)
	) {
		error_msg_alert('Please enter Domain');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}
//Validation for address Maxlength
function validate_address (id) {
	var el = document.getElementById(id).value;
	if (el.length > 156) {
		error_msg_alert('More than 155 characters are not allowed.');
		$('#' + id).css({ border: '1px solid red' });
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

//validation for location
function validate_location (from, to) {
	/* var from_loc = document.getElementById(from).value; 
    var to_loc = document.getElementById(to).value; 
    if(to_loc != '')
    {
      if(from_loc == to_loc)
      {
          error_msg_alert("From and To location cannot be same");
          $('#'+to).css({'border':'1px solid red'});  
          document.getElementById(to).value="";
          $('#'+to).focus();
          g_validate_status = false;
          return false;
      }
      else
      {
         $('#'+to).css({'border':'1px solid #ddd'}); 
        return (true);  
      }
    }*/
	return true;
}
//Validation for joining date
function validate_joiningdate (id) {
	/*var chkdate = document.getElementById("id").value;

  var edate = chkdate.split("-");
  var spdate = new Date();
  var sdd = spdate.getDate();
  var smm = spdate.getMonth();
  var syyyy = spdate.getFullYear();
  var today = new Date(syyyy,smm,sdd).getTime();
  var e_date = new Date(edate[2],edate[1]-1,edate[0]).getTime();
  if(e_date > today)
   {
      error_msg_alert('Joining date is not valid.');
      $('#'+id).css({'border':'1px solid red'});  
      document.getElementById(id).value="";
      $('#'+id).focus();
      g_validate_status = false;
         return (false);
   }
   else
  {
     $('#'+id).css({'border':'1px solid #ddd'}); 
    return (true);  
  }*/
	return true;
}

//Validation for username
function validate_username (id) {
	// var obj = document.getElementById(id).value;
	// obj = obj.replace(/^\s+|\s+$/g, "");
	// var CharArray = obj.split(" ");
	// if (CharArray.length > 1)
	// {
	//   error_msg_alert('Username field should not allow space.');
	//   $('#'+id).css({'border':'1px solid red'});
	//   document.getElementById(id).value="";
	//   $('#'+id).focus();
	//   g_validate_status = false;
	//   return (false);
	// }
	// else if( obj.length < 6 || obj.length >20)
	// {
	//   error_msg_alert('Username field contains atleast 6 letters but not more than 20 letters.');
	//   $('#'+id).css({'border':'1px solid red'});
	//   document.getElementById(id).value="";
	//   $('#'+id).focus();
	//   g_validate_status = false;
	//   return (false);
	// }
	// else
	// {
	//    $('#'+id).css({'border':'1px solid #ddd'});
	//   return (true);
	// }
}

//validation for password
function validate_password (id) {
	// var obj = document.getElementById(id).value;
	// obj = obj.replace(/^\s+|\s+$/g, "");
	// var CharArray = obj.split(" ");
	// if (CharArray.length > 1){
	//   error_msg_alert('Password field should not allow space.');
	//   $('#'+id).css({'border':'1px solid red'});
	//   document.getElementById(id).value="";
	//   $('#'+id).focus();
	//   g_validate_status = false;
	//  return (false);
	// }
	// else if( obj.length < 6 || obj.length >20)
	// {
	//   error_msg_alert('Password field contains atleast 6 letters but not more than 20 letters.');
	//   $('#'+id).css({'border':'1px solid red'});
	//   document.getElementById(id).value="";
	//   $('#'+id).focus();
	//   g_validate_status = false;
	//  return (false);
	// }
	// else
	// {
	//    $('#'+id).css({'border':'1px solid #ddd'});
	//   return (true);
	// }
}

// Validation for monthly target
function validate_monthlyIncome (id) {
	var num = document.getElementById(id).value;
	var decimal = /^[-+]?[0-9]+\.[0-9]+$/;
	if (!num.replace(/\s/g, '').length) {
		error_msg_alert('Please enter valid information.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (num.match(decimal) || num < 0) {
		error_msg_alert('Please enter valid amount.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

//Validation for future date

function validate_futuredate (id) {
	 var from_date = $('#'+id).val(); 
    var parts = from_date.split('-');
    var date = new Date();
    var today = new Date();
    var new_month = parseInt(parts[1])-1;
    date.setFullYear(parts[2]);
    date.setDate(parts[0]);
    date.setMonth(new_month);
    var from_date_ms = date.getTime();
    var today = new Date();
    if(from_date_ms > today){
      error_msg_alert("Date cannot be future date");
      $('#'+id).css({'border':'1px solid red'});  
        document.getElementById(id).value="";
        $('#'+id).focus();
        g_validate_status = false;
      return false;
    } 
    else
    {
       $('#'+id).css({'border':'1px solid #ddd'}); 
      return (true);  
    }
}
//Validate past date
function validate_pastDate (id) {
  var from_date = $('#'+id).val(); 
  var from_parts = from_date.split(' ');
  var parts = from_parts[0].split('-');
  var date = new Date();
  var new_month = parseInt(parts[1])-1;
  date.setFullYear(parts[2]);
  date.setDate(parts[0]);
  date.setMonth(new_month);
  var today = new Date();
  var from_date_ms = date.getTime();
  var to_date_ms = today.getTime();
    if(from_date_ms < to_date_ms){
      error_msg_alert("Date cannot be past date");
      $('#'+id).css({'border':'1px solid red'});  
        document.getElementById(id).value="";
        $('#'+id).focus();
        g_validate_status = false;
      return false;
    } 
    else
    {
       $('#'+id).css({'border':'1px solid #ddd'}); 
      return (true);  
    }
}

// Validation for Issue date
function validate_issueDate (from, to) {
	/*var from_date = $('#'+from).val(); 
    var to_date = $('#'+to).val(); 
    var parts = from_date.split('-');
    var date = new Date();
    var new_month = parseInt(parts[1])-1;
    date.setFullYear(parts[2]);
    date.setDate(parts[0]);
    date.setMonth(new_month);

    var parts1 = to_date.split('-');
    var date1 = new Date();
    var new_month1 = parseInt(parts1[1])-1;
    date1.setFullYear(parts1[2]);
    date1.setDate(parts1[0]);
    date1.setMonth(new_month1);

    var one_day=1000*60*60*24;

    var from_date_ms = date.getTime();
    var to_date_ms = date1.getTime();

    if(from_date_ms>to_date_ms ){
      error_msg_alert("Date should be greater than previous date");
      $('#'+to).css({'border':'1px solid red'});  
        document.getElementById(to).value="";
        $('#'+to).focus();
        g_validate_status = false;
      return false;
    } 
   else if(from_date_ms==to_date_ms )
   {
    error_msg_alert("Please enter valid date");
    $('#'+to).css({'border':'1px solid red'});  
        document.getElementById(to).value="";
        $('#'+to).focus();
        g_validate_status = false;
      return false;
   }
    else
      {
         $('#'+to).css({'border':'1px solid #ddd'}); 
        return (true);  
      }*/
	return true;
}

//Validation for amount

function validate_amount (id) {
	var evt = document.getElementById(id).value;

	var iKeyCode =
		evt.which ? evt.which :
		evt.keyCode;
	if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)) {
		error_msg_alert('Please enter valid amount.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

//Validation for Pf
function validate_pf (emp1, emp2) {
	var emp1val = document.getElementById(emp1).value;
	var emp2val = document.getElementById(emp2).value;
	if (emp2val != '') {
		if (emp1val == emp2val) {
			$('#' + emp1).css({ border: '1px solid #ddd' });
			return true;
		}
		else {
			error_msg_alert('Employee PF and Employer PF should be same.');
			$('#' + emp1).css({ border: '1px solid red' });
			document.getElementById(emp1).value = '';
			$('#' + emp1).focus();
			g_validate_status = false;
			return false;
		}
	}
}

//Validation for Website

function validate_url (id) {
	/* var str = document.getElementById(id).value;

  regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
        if (regexp.test(str))
        {
          $('#'+id).css({'border':'1px solid #ddd'}); 
          return (true); 
        }
        else
        {
          error_msg_alert('Please enter valid url.');
          $('#'+id).css({'border':'1px solid red'});  
          document.getElementById(id).value="";
          $('#'+id).focus();
          g_validate_status = false;
          return (false);     
        }*/
	return true;
}

//Validation for account no

function validate_accountNo (id) {
	// var pass1 = document.getElementById(id).value;

	// if(isNaN(pass1) || pass1.length >35)
	// {
	//   error_msg_alert('Please enter valid account number');
	//   $('#'+id).css({'border':'1px solid red'});
	//   //$('#'+id).next().hide();
	//   //$("#"+id).after("<span style='border:0px; color:red; float:right; background: initial;' class='form-control text-right'>Enter Number Only!</span>");
	//   document.getElementById(id).value="";
	//   $('#'+id).focus();
	//   g_validate_status = false;
	//   return false;
	// }
	// else if(!pass1.replace(/\s/g, '').length)
	// {
	//    error_msg_alert('It should not allow spaces');
	//    $('#'+id).css({'border':'1px solid red'});
	//    //alert("Use only letter in name!");
	//    document.getElementById(id).value="";
	//    $('#'+id).focus();
	//    g_validate_status = false;
	//   return false;
	// }
	// else
	// {
	//   var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
	//   var obj =    document.getElementById(id).value;
	//   for (var i = 0; i < obj.length; i++) {
	//       if (iChars.indexOf(obj.charAt(i)) != -1) {
	//         error_msg_alert('It should not allow special character.');
	//         $('#'+id).css({'border':'1px solid red'});
	//         document.getElementById(id).value="";
	//         $('#'+id).focus();
	//         g_validate_status = false;
	//         return (false);
	//       }
	//       else
	//     {
	//        $('#'+id).css({'border':'1px solid #ddd'});
	//       return (true);
	//     }
	//   }
	// }

	// else
	// {
	//   $('#'+id).css({'border':'1px solid #ddd'});
	//   //$('#'+id).next().hide();
	//    return true;
	// }
	return true;
}

// Validation for branch

function validate_branch (id) {
	/*var pass1 = document.getElementById(id).value;  
  //alert(pass1);
  if(/^[A-z]+$/.test(pass1) && pass1.length <= 25)
  {
    $('#'+id).css({'border':'1px solid #ddd'});
    return true;
  }
  else if(!pass1.replace(/\s/g, '').length)
    {
      error_msg_alert('It Should not allow spaces.');
      $('#'+id).css({'border':'1px solid red'});  
      document.getElementById(id).value="";
      $('#'+id).focus();
      g_validate_status = false;
      return (false); 
       
    }  
  else
  {
   error_msg_alert('Please enter valid Branch name');
   $('#'+id).css({'border':'1px solid red'});  
   //alert("Use only letter in name!"); 
   document.getElementById(id).value="";
   $('#'+id).focus();   
   g_validate_status = false;
    return false;
  }  */
	return true;
}

// Validation for IFSC code
function validate_IFSC (id) {
	/*
  var pass1 = document.getElementById(id).value;  
  
  if( /^[A-Za-z]{4}\d{7}$/.test(pass1) && pass1.length <= 11)
  {
    $('#'+id).css({'border':'1px solid #ddd'});
    return true;
  }
  else
  {
   error_msg_alert('Please enter valid IFSC/Swift Code');
   $('#'+id).css({'border':'1px solid red'});  
   //alert("Use only letter in name!"); 
   document.getElementById(id).value="";
   $('#'+id).focus();   
   g_validate_status = false;
    return false;
  }  */
	return true;
}

// Validation for Airline
function validate_airline (id) {
	var pass1 = document.getElementById(id).value;

	if (/^[A-z0-9 ]+$/.test(pass1) && pass1.length <= 30) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid Airline');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}
// App Name
function validate_company (id) {
	var pass1 = document.getElementById(id).value;
	if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('It should not allow spaces');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (pass1.length > 35) {
		error_msg_alert('More than 35 characters are not allowed.');
		$('#' + id).css({ border: '1px solid red' });
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

//Validation for Airline Code
function validate_airlineCode (id) {
	/*var pass1 = document.getElementById(id).value;  
  //alert(pass1.length);
  if( /^[A-z0-9 ]+$/.test(pass1) && pass1.length <= 3)
  {
    $('#'+id).css({'border':'1px solid #ddd'});
    return true;
  }
  else
  {
   error_msg_alert('Please enter valid Airline Code');
   $('#'+id).css({'border':'1px solid red'});  
   //alert("Use only letter in name!"); 
   document.getElementById(id).value="";
   $('#'+id).focus();   
   g_validate_status = false;
    return false;
  }  */
	return true;
}

//Validation for Tour Capavity
function validate_tourCapacity (id) {
	var pass1 = document.getElementById(id).value;
	//alert(pass1);
	if (/^[0-9]+$/.test(pass1) && pass1.length > 0) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid Tour Capacity');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

// Validation for Overnightstay
function validate_overnightstay (id) {
	var iChars = '!@#$%^&*()+=-[]\\\';,./{}|":<>?';
	var obj = document.getElementById(id).value;
	for (var i = 0; i < obj.length; i++) {
		if (iChars.indexOf(obj.charAt(i)) != -1) {
			error_msg_alert('Please enter valid information.');
			$('#' + id).css({ border: '1px solid red' });
			document.getElementById(id).value = '';
			$('#' + id).focus();
			g_validate_status = false;
			return false;
		}
		else {
			$('#' + id).css({ border: '1px solid #ddd' });
			return true;
		}
	}
}

//Validation for City Name
function validate_city (id) {
	var pass1 = document.getElementById(id).value;
	if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('It Should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[a-zA-Z\s ]+$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid city');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

//Validation for City Name
function validate_state (id) {
	var pass1 = document.getElementById(id).value;
	if (/^[a-zA-Z\(0-9\)\s ]+$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid state');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

//Validation for PIN Code

function validate_PINCode (id) {
	/*var pass1 = document.getElementById(id).value;  
  if( /^\d{6}$/.test(pass1))
  {
    $('#'+id).css({'border':'1px solid #ddd'});
    return true;
  }
  else
  {
   error_msg_alert('Please enter valid PIN code');
   $('#'+id).css({'border':'1px solid red'});  
   //alert("Use only letter in name!"); 
   document.getElementById(id).value="";
   $('#'+id).focus();   
   g_validate_status = false;
    return false;
  }  */
	return true;
}

//Validation for vehicle
function validate_vehicle (id) {
	var obj = document.getElementById(id).value;
	//alert('hiii');
	if (!obj.replace(/\s/g, '').length) {
		error_msg_alert('It should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[A-Za-z0-9\s]+$/.test(obj)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid Vehicle Information.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}
function validate_CINCode (id) {
	/*var pass1 = document.getElementById(id).value;  
  if( /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/.test(pass1) && pass1.length <= 21)
  {
    $('#'+id).css({'border':'1px solid #ddd'});
    return true;
  }
  else
  {
   error_msg_alert('Please enter valid CIN code');
   $('#'+id).css({'border':'1px solid red'});  
   //alert("Use only letter in name!"); 
   document.getElementById(id).value="";
   $('#'+id).focus();   
   g_validate_status = false;
    return false;
  }*/
}
//validation for tax name
function validate_taxname (id) {
	/*var obj = document.getElementById(id).value;
    //alert('hiii');
    obj = obj.replace(/^\s+|\s+$/g, "");
    var CharArray = obj.split(" ");
    //alert(CharArray.length);
    if (CharArray.length <= 1 &&  /^[a-zA-Z]+$/.test(obj) ) 
    {
      $('#'+id).css({'border':'1px solid #ddd'}); 
      return (true); 

    }
    else
    {
      error_msg_alert('Please enter valid Tax Name.');
      $('#'+id).css({'border':'1px solid red'});  
      document.getElementById(id).value="";
      $('#'+id).focus();
      g_validate_status = false;
     return (false);
    }*/
	return true;
}

//Validation for PIN Code

//Validation for Image

function validate_image (id) {
	/*alert('hiiii');
   if (typeof ($("#"+id)[0].files) != "undefined") {
                var size = parseFloat($("#fileUpload")[0].files[0].size / 1024).toFixed(2);
                alert(size + " KB.");
            } else {
                alert("This browser does not support HTML5.");
            }*/
	return true;
}

//validation for not allow spaces and negative vlaues
function validate_spaces (id) {
	var obj = document.getElementById(id).value;
	//alert('hiii');
	// var decimal=  /^[a-zA-Z0-9_ ]*$/;

	if (!obj.replace(/\s/g, '').length) {
		error_msg_alert('It should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (parseInt(obj) < 0) {
		error_msg_alert('Please enter valid information.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}
//Validation for special character
function validate_specialChar (id) {
	var obj = document.getElementById(id).value;
	if (!obj.replace(/\s/g, '').length) {
		error_msg_alert('It should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		var iChars = '!@#$%^&*()+=-[]\\\';,./{}|":<>?';
		for (var i = 0; i < obj.length; i++) {
			if (iChars.indexOf(obj.charAt(i)) != -1) {
				error_msg_alert('It should not allow special character.');
				$('#' + id).css({ border: '1px solid red' });
				document.getElementById(id).value = '';
				$('#' + id).focus();
				g_validate_status = false;
				return false;
			}
			else {
				$('#' + id).css({ border: '1px solid #ddd' });
				return true;
			}
		}
	}
}

//Validation for decimal point
function validate_decimal (id) {
	var num = document.getElementById(id).value;
	var decimal = /^[-+]?[0-9]+\.[0-9]+$/;
	if (num.match(decimal) || num < 0) {
		error_msg_alert('Please enter valid information.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

//Validation for days and night
function validate_days (night, day) {
	var night = document.getElementById(night).value;
	var days = document.getElementById(day).value;
	var totalday = parseInt(days) - 1;
	if (night != totalday) {
		error_msg_alert('Number of days must be greater than night by 1.');
		$('#' + day).css({ border: '1px solid red' });
		document.getElementById(day).value = '';
		$('#' + day).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + day).css({ border: '1px solid #ddd' });
		return true;
	}
}

//validation for year
function validate_year (id) {
	var pass1 = document.getElementById(id).value;
	if (/^\d{4}$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('It should not allow spaces.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		error_msg_alert('Please enter valid Year');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

//function for valid date tariff
function validate_validDate (from, to) {
	
	var from_date = $('#' + from).val();
	var to_date = $('#' + to).val();

	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	var edate1 = to_date.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert('Date should not be greater than valid to date');
		$('#' + from).css({ border: '1px solid red' });
		document.getElementById(from).value = '';
		$('#' + from).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + from).css({ border: '1px solid #ddd' });
		return true;
	}
	return true;
}
function validate_validDatetime(from, to){
	var from_date = $('#' + from).val();
	var to_date = $('#' + to).val();

	from_date = from_date.split(' ')[0];
	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	to_date = to_date.split(' ')[0];
	var edate1 = to_date.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert('From date should not be greater than valid To date');
		$('#' + from).css({ border: '1px solid red' });
		document.getElementById(from).value = '';
		$('#' + from).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + from).css({ border: '1px solid #ddd' });
		return true;
	}
}
function validate_transportDate (from, to) {
	var from_date = $('#'+from).val(); 
  var from_parts = from_date.split(' ');
  var to_date = $('#'+to).val(); 
  var to_parts = to_date.split(' ');
  //alert(from_parts[0]);
  var parts = from_parts[0].split('-');
  var date = new Date();
  var new_month = parseInt(parts[1])-1;
  date.setFullYear(parts[2]);
  date.setDate(parts[0]);
  date.setMonth(new_month);
  var today = new Date();
  //alert(from_date);

  var parts1 = to_parts[0].split('-');
  var date1 = new Date();
  var new_month1 = parseInt(parts1[1])-1;
  date1.setFullYear(parts1[2]);
  date1.setDate(parts1[0]);
  date1.setMonth(new_month1);

  var one_day=1000*60*60*24;

  var from_date_ms = date.getTime();
  var to_date_ms = date1.getTime();
  //alert(from_date+','+to_date);

  if(from_date_ms < today){
  //alert(from_date_ms);
    error_msg_alert("Date cannot be past date");
    $('#'+from).css({'border':'1px solid red'});  
      document.getElementById(from).value="";
      $('#'+from).focus();
      g_validate_status = false;
    return false;
  } 
  else if(from_date_ms > to_date_ms ){
    error_msg_alert("Date should not be greater than arrival date");
    $('#'+from).css({'border':'1px solid red'});  
      document.getElementById(from).value="";
      $('#'+from).focus();
      g_validate_status = false;
    return false;
  } 
   else
    {
       $('#'+from).css({'border':'1px solid #ddd'}); 
      return (true);  
    }
	return true;
}

function validate_arrivalDate (from, to) {
  var from_date = $('#'+from).val(); 
  var from_parts = from_date.split(' ');
  var to_date = $('#'+to).val(); 
  var to_parts = to_date.split(' ');
  var parts = from_parts[0].split('-');
  var date = new Date();
  var today = new Date();
  var new_month = parseInt(parts[1])-1;
  date.setFullYear(parts[2]);
  date.setDate(parts[0]);
  date.setMonth(new_month);
  var today = new Date();

  var parts1 = to_parts[0].split('-');
  var date1 = new Date();
  var new_month1 = parseInt(parts1[1])-1;
  date1.setFullYear(parts1[2]);
  date1.setDate(parts1[0]);
  date1.setMonth(new_month1);

  var one_day=1000*60*60*24;

  var from_date_ms = date.getTime();
  var to_date_ms = date1.getTime();

  if(from_date_ms < today){
    error_msg_alert("Date cannot be past date");
    $('#'+to).css({'border':'1px solid red'});  
      document.getElementById(to).value="";
      $('#'+to).focus();
      g_validate_status = false;
    return false;
  } 
  else if(from_date_ms > to_date_ms ){
    error_msg_alert("Date should be greater than Departure date");
    $('#'+to).css({'border':'1px solid red'});  
      document.getElementById(to).value="";
      $('#'+to).focus();
      g_validate_status = false;
    return false;
  } 
   else
    {
       $('#'+to).css({'border':'1px solid #ddd'}); 
      return (true);  
    }
  
	return true;
}
//validation for balances
function validate_balance (id) {
	var num = document.getElementById(id).value;
	var decimal = /^[-+]?[0-9]+\.[0-9]+$/;
	if (parseInt(num) < 0) {
		error_msg_alert('It should not allow negative number.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[A-z ]+$/.test(num)) {
		error_msg_alert('It should not allow alphabets.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (!isNaN(num)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('It should not allow special character.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

//validation for sac
function validate_sac (id) {
	var pass1 = document.getElementById(id).value;
	if (/^\d{8,10}$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else if (!/^\d{8,10}$/.test(pass1)) {
		error_msg_alert('Enter 8 to 10 digit HSN/SAC code');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

//Validation for customer
function validate_customer (id) {
	var pass1 = document.getElementById(id).value;
	if (!pass1.replace(/\s/g, '').length) {
		error_msg_alert('Please enter valid information.');
		$('#' + id).css({ border: '1px solid red' });
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else if (/^[A-z ]+$/.test(pass1) && pass1.length <= 30) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid name');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

///validate followup date

function validate_followupDate (enquiry, followup) {
	/*var from_date = $('#'+enquiry).val(); 
  var to_date = $('#'+followup).val(); 
  var to_parts = to_date.split(' ');
  //alert(from_parts[0]);
  var parts = from_date.split('-');
  var date = new Date();
  var today = new Date();
  var new_month = parseInt(parts[1])-1;
  date.setFullYear(parts[2]);
  date.setDate(parts[0]);
  date.setMonth(new_month);
  var today = new Date();
  //alert(from_date);

  var parts1 = to_parts[0].split('-');
  var date1 = new Date();
  var new_month1 = parseInt(parts1[1])-1;
  date1.setFullYear(parts1[2]);
  date1.setDate(parts1[0]);
  date1.setMonth(new_month1);

  var one_day=1000*60*60*24;

  var from_date_ms = date.getTime();
  var to_date_ms = date1.getTime();
  //alert(from_date+','+to_date);

   if(from_date_ms > to_date_ms ){
    error_msg_alert("Date should be greater than enquiry date");
    $('#'+followup).css({'border':'1px solid red'});  
      document.getElementById(followup).value="";
      $('#'+followup).focus();
      g_validate_status = false;
    return false;
  } 
  if(from_date_ms == to_date_ms ){
    $('#'+followup).css({'border':'1px solid #ddd'}); 
      return (true);  
  } 
   else
    {
       $('#'+followup).css({'border':'1px solid #ddd'}); 
      return (true);  
    }
  */
	return true;
}

//validation for passport /^[A-PR-WY][1-9]\d\s?\d{4}[1-9]$/ig

function validate_passport (id) {
	/*var pass1 = document.getElementById(id).value;  
  if( /^[A-PR-WY][1-9]\d\s?\d{4}[1-9]$/ig.test(pass1))
  {
    $('#'+id).css({'border':'1px solid #ddd'});
    return true;
  }
  else
  {
   error_msg_alert('Enter valid passport details(first character is an upper case letter of the English alphabet, followed by 2 numbers, then an optional space followed by 5 numbers).');
   $('#'+id).css({'border':'1px solid red'});  
   //alert("Use only letter in name!"); 
   document.getElementById(id).value="";
   $('#'+id).focus();   
   g_validate_status = false;
    return false;
  }*/
	return true;
}
function percentage_validation(id){
	var value = document.getElementById(id).value;
	return ((value <= 100) && (value >= 0));
}
function flat_validation(id){
	var value = document.getElementById(id).value;
	return ((value <= 100000) && (value >= 0));
}
//Validation for Booking Date
function validate_bookingDate (booking, due) {
	/*var booking_date = $('#'+booking).val(); 
    var booking_parts = booking_date.split(' ');

    var due_date = $('#'+due).val(); 

    var parts = booking_parts[0].split('-');
    var date = new Date();
    var today = new Date();
    var new_month = parseInt(parts[1])-1;
    date.setFullYear(parts[2]);
    date.setDate(parts[0]);
    date.setMonth(new_month);
    var today = new Date();
    var parts1 = due_date.split('-');
    var date1 = new Date();
    var new_month1 = parseInt(parts1[1])-1;
    date1.setFullYear(parts1[2]);
    date1.setDate(parts1[0]);
    date1.setMonth(new_month1);

    var one_day=1000*60*60*24;

    var from_date_ms = date.getTime();
    var to_date_ms = date1.getTime();
   if(from_date_ms > to_date_ms ){
      error_msg_alert("Date should not be greater than Due date");
      $('#'+booking).css({'border':'1px solid red'});  
        document.getElementById(booking).value="";
        $('#'+booking).focus();
        g_validate_status = false;
      return false;
    } 
     else
      {
         $('#'+booking).css({'border':'1px solid #ddd'}); 
        return (true);  
      }*/
	return true;
}

//Validation for Due Date
function validate_dueDate (booking, due) {
	/*
    var booking_date = $('#'+booking).val(); 
    var booking_parts = booking_date.split(' ');

    var due_date = $('#'+due).val(); 

    var parts = booking_parts[0].split('-');
    var date = new Date();
    var today = new Date();
    var new_month = parseInt(parts[1])-1;
    date.setFullYear(parts[2]);
    date.setDate(parts[0]);
    date.setMonth(new_month);
    var today = new Date();
    //alert(from_date);

    var parts1 = due_date.split('-');
    var date1 = new Date();
    var new_month1 = parseInt(parts1[1])-1;
    date1.setFullYear(parts1[2]);
    date1.setDate(parts1[0]);
    date1.setMonth(new_month1);

    var one_day=1000*60*60*24;
    var from_date_ms = date.getTime();
    var to_date_ms = date1.getTime();

    if(from_date_ms > to_date_ms )
    {
      error_msg_alert("Date should be greater than booking date");
      $('#'+to).css({'border':'1px solid red'});  
      document.getElementById(to).value="";
      $('#'+to).focus();
      g_validate_status = false;
      return false;
    } 
   else if(from_date_ms==to_date_ms )
   {
    error_msg_alert("Please enter valid due date");
    $('#'+due).css({'border':'1px solid red'});  
    document.getElementById(due).value="";
    $('#'+due).focus();
    g_validate_status = false;
    return false;
   }
  else
  {
    $('#'+due).css({'border':'1px solid #ddd'}); 
    return (true);  
  }*/
	return true;
}

//validation for promotion limit
function validate_limit (id) {
	var pass1 = document.getElementById(id).value;
	if (pass1.length <= 350) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Do not enter more than 350 character');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}
//Get Date
function get_to_date (from_date, to_date) {
	var from_date1 = $('#' + from_date).val();
	if (from_date1 != '') {
		var edate = from_date1.split('-');
		e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
		var currentDate = new Date(new Date(e_date).getTime() + 24 * 60 * 60 * 1000);
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		if (day < 10) {
			day = '0' + day;
		}
		if (month < 10) {
			month = '0' + month;
		}
		$('#' + to_date).val(day + '-' + month + '-' + year);
	}
	else {
		$('#' + to_date).val('');
	}
}

//Get DateTime
function get_to_datetime (from_date, to_date) {
	var from_date1 = $('#' + from_date).val();
	if (from_date1 != '') {
		var edate = from_date1.split(' ');
		var edate1 = edate[0].split('-');
		var edatetime = edate[1].split(':');
		var e_date_temp = new Date(
			edate1[2],
			edate1[1] - 1,
			edate1[0],
			edatetime[0],
			edatetime[1],
			edatetime[2]
		).getTime();

		var currentDate = new Date(new Date(e_date_temp).getTime() + 24 * 60 * 60 * 1000);

		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		var hours = currentDate.getHours();
		var minute = currentDate.getMinutes();
		var seconds = currentDate.getSeconds();
		if (day < 10) {
			day = '0' + day;
		}
		if (month < 10) {
			month = '0' + month;
		}
		if (hours < 10) {
			hours = '0' + hours;
		}
		if (minute < 10) {
			minute = '0' + minute;
		}
		if (seconds < 10) {
			seconds = '0' + seconds;
		}
		$('#' + to_date).val(day + '-' + month + '-' + year + ' ' + hours + ':' + minute + ':' + seconds);
	}
	else {
		$('#' + to_date).val('');
	}
}

//Validation for special attration
function validate_spattration (id) {
	var obj = document.getElementById(id).value;
	obj = obj.replace(/^\s+|\s+$/g, '');
	if (obj.length >= 86) {
		error_msg_alert('Character limit for Special attraction is 85 characters');
		$('#' + id).css({ border: '1px solid red' });
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

//Validation for daywise program
function validate_dayprogram (id) {
	var obj = document.getElementById(id).value;
	obj = obj.replace(/^\s+|\s+$/g, '');
	if (obj.length >= 500) {
		error_msg_alert('Character limit for Day-program is 500 characters');
		$('#' + id).css({ border: '1px solid red' });
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}
//Validation for overnight stay
function validate_onstay (id) {
	var obj = document.getElementById(id).value;
	obj = obj.replace(/^\s+|\s+$/g, '');
	if (obj.length >= 31) {
		error_msg_alert('Character limit for Overnight stay is 30 characters');
		$('#' + id).css({ border: '1px solid red' });
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
}

function ValidateIPaddress (inputText) {
	var ipAdresses = $('#' + inputText).tagsinput('items');
	var flag = false;
	for (var i = 0; i < ipAdresses.length; i++) {
		if (
			!/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(
				ipAdresses[i]
			)
		) {
			// if(!ipAdresses[i].match(ipformat)){
			error_msg_alert('You have entered Invalid <br>IP Address->' + ipAdresses[i]);
			$('#' + inputText).css({ border: '1px solid red' });
			$('#' + inputText).focus();
			flag = false;
		}
		else {
			$('#' + inputText).css({ border: '1px solid #ddd' });
			flag = true;
		}
	}
	return flag;
}
function validate_char_size (id, char_limit) {
	
	var obj = document.getElementById(id).value;
	obj = obj.replace(/^\s+|\s+$/g, '');
	if (obj.length > char_limit) {
		error_msg_alert('Character limit for this field is ' + char_limit + ' characters');
		$('#' + id).css({ border: '1px solid red' });
		$('#' + id).focus();
		flag = false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		flag = true;
	}
	return flag;
}
function validURL(id) {

	var flag = true;
	var url = document.getElementById(id).value;
	var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
	if(url!=''){
		if (!re.test(url)) {

			error_msg_alert('Invalid url: '+url);
			$('#' + id).css({ border: '1px solid red' });
			$('#' + id).focus();
			flag = false;
		}
		else {
			$('#' + id).css({ border: '1px solid #ddd' });
		}
	}
	return flag;
}
function blockSpecialChar (e) {
	var k = e.keyCode;
	return (k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57);
}
