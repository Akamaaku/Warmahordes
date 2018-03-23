/**
 * Project: WarmaHordes CMS
 * Author: Mark_Nunez
 * Date Created: 2018-03-19
 * Last Modified: 2018-03-19
 */
var fnameError;
var lnameError;
var emailError;
var cityError;
var dobError;
var dnameError;
var pswrdError;
var cnfrmError;
var matchError;
var companyError;
var phoneError;


function load(){
	fnameError = document.getElementById("fnameError");
	lnameError = document.getElementById("lnameError");
	emailError = document.getElementById("emailError");
	cityError = document.getElementById("cityError");
	dnameError = document.getElementById("dnameError");
	pswrdError = document.getElementById("pswrdError");
	cnfrmError = document.getElementById("cnfrmError");
	matchError = document.getElementById("matchError");
	companyError = document.getElementById("companyError");
	phoneError = document.getElementById("phoneError");
	dobError = document.getElementById("dobError");
	hideErrors();

	document.getElementById("submit").addEventListener("click", validate);
	document.getElementById("reset").addEventListener("click", resetForm);
}

function hideErrors()
{
	fnameError.style.display = "none";
	lnameError.style.display = "none";
	emailError.style.display = "none";
	cityError.style.display = "none";
	dobError.style.display = "none";
	dnameError.style.display= "none";
	pswrdError.style.display = "none";
	cnfrmError.style.display = "none";
	matchError.style.display = "none";
	companyError.style.display = "none";
	phoneError.style.display = "none";
}

function resetForm(e)
{
	// Confirm that the user wants to reset the form.
	if ( confirm("Are you sure you want to reset?") )
	{
		hideErrors();
		
		document.getElementById("fname").focus();
		
		return true;
	}

	e.preventDefault();
	
	return false;	
}

function validate(e)
{
	hideErrors();

	if(formHasErrors())
	{
		e.preventDefault();
		return false;
	}

	return true;
}

function formHasErrors()
{
	var errorFlag = false;
	// var fname = document.getElementById("fname");
	// var lname= document.getElementById("lname");
	// var dname = document.getElementById("dname");
	// var city = document.getElementById("city");
	// var email = document.getElementById("email");


	var textArray = ["fname", "lname", "city", "email", "dname", "pswrd", "cnfrm"];
	
	for(var i = 0; i< textArray.length; i++)
	{
		var formItem = document.getElementById(textArray[i]);

		if(!formFieldHasInput(formItem))
		{
			var hasError = document.getElementById(textArray[i] + "Error");
			hasError.style.display="block";

			if(!errorFlag)
			{
				formItem.focus();
				formItem.select();
			}

			errorFlag = true;
		}
	}

	//	Checks to see if the email is in proper format only.

	var emailRegex = new RegExp(/^\w+([\.-]?\ w+)*@\w+([\.-]?\ w+)*(\.\w{2,3})+$/, "i");
	var email = document.getElementById("email");
	if (!formFieldHasInput(email))
	{
		document.getElementById("emailError").style.display = "block";
		if(!errorFlag)
		{
			email.focus();
			email.select();
		}

		errorFlag = true;
	}
	else if(!emailRegex.test(email.value))
	{
		document.getElementById("emailError").style.display = "block";
		if(!errorFlag)
		{
			email.focus();
			email.select();
		}

		errorFlag = true;
	}

	//Confirms passwords match
	var pswrd = document.getElementById("pswrd").value;
	var cnfrm= document.getElementById("cnfrm").value;
	
	if(!(pswrd === cnfrm))
	{
		errorFlag = true;
		matchError.style.display="block";
	}

	//Confirms proper date of birth and age
	var year = parseInt(document.getElementById("year").value);
	var month = parseInt(document.getElementById("month").value);
	var day = parseInt(document.getElementById("days").value);
	var age = 0;
	var errorMessage = "Date does not exist. Please put in correct date.";
	switch(month)
	{
		case 0:
			errorFlag = true;
			dateError(errorMessage);
		case 2:
			if((year % 4 == 0 && year % 100 != 0) || year % 400 == 0)
			{
				if(day > 29)
				{
					errorFlag = true;
					dateError(errorMessage);
				}
				else
				{
					age = calculateAge(year,month,day);
				}
			}
			else
			{
				if(day > 28)
				{
					errorFlag = true;
					dateError(errorMessage);
				}
				else
				{
					age = calculateAge(year,month,day);
				}
			}
			break;
		
		case 4:
			if(day > 30)
			{
				errorFlag = true;
				dateError(errorMessage);
			}
			else
			{
				age = calculateAge(year,month,day);
			}
			break;
		
		case 6:
			if(day > 30)
			{
				errorFlag = true;
				dateError(errorMessage);
			}
			else
			{
				age = calculateAge(year,month,day);
			}
			break;
		
		case 9:
			if(day > 30)
			{
				errorFlag = true;
				dateError(errorMessage);
			}
			else
			{
				age = calculateAge(year,month,day);
			}
			break;
		
		case 11:
			if(day > 30)
			{
				errorFlag = true;
				dateError(errorMessage);
			}
			else
			{
				age = calculateAge(year,month,day);
			}
			break;
		
		default:
			if(day > 31)
			{
				errorFlag = true;
				dateError(errorMessage);
			}
			else
			{
				age = calculateAge(year,month,day);
			}
			break;
	}

	if(age < 12)
	{
		errorFlag = true;
		errorMessage = "To join the community minimum age of 12 is required.";
		dateError(errorMessage);
	}


	return errorFlag;
}

function dateError(errorMessage)
{
	dobError.innerHTML = errorMessage;
	dobError.style.display="block";
}

function calculateAge(birthYear, birthMonth, birthDay) 
{
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth();
    var currentDay = currentDate.getDate(); 
    var calculatedAge = currentYear - birthYear;

    if (currentMonth < birthMonth - 1) {
        calculatedAge--;
    }
    if (birthMonth - 1 == currentMonth && currentDay < birthDay) {
        calculatedAge--;
    }
    return calculatedAge;
}

function formFieldHasInput(fieldElement)
{
	if (fieldElement.value == null || trim(fieldElement.value) == "" )
	{
		// Invalid entry
		return false;
	}
	
	// Valid entry
	return true;

	//return fieldElement.Value && trim(fieldElement);
}

function trim(str) 
{
	// Uses a regex to remove spaces from a string.
	return str.replace(/^\s+|\s+$/g,"");
}

 document.addEventListener("DOMContentLoaded", load);