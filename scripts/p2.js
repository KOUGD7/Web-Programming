// Below Function Executes On Form Submit
function validate() {

// Storing Field Values In Variables															

	var code = document.getElementById("courseCode").value;
	var title = document.getElementById("courseTitle").value;
	var discip = document.getElementById("courseDiscipline").value;
	var level = document.getElementById("level").value;
	var credit = document.getElementById("credit").value;
	var semester = document.getElementById("semester").value;
	var author = document.getElementById("author").value;

	//alert('Form submitted!');


// Regular Expression For Course Code, Discipline and Semester
	//var codereg = /^([a-zA-Z]{4}[0-9]{4})$/
	var codemat = /^([0-9]{4})$/
	var discipmat = /^([a-zA-Z]{4})$/
	var semestermat= /^([1-3]{1})$/ 

// Conditions
	//None of the text fields are empty.
	if (code != '' && title != '' && discip != '' && level != '' && credit != '' && semester != '' && author != '0') {
		if(code.match(codemat)){							//The course code is a four-digit integer
			if (discip.match(discipmat)){					//The course discipline is a four-letter string
				if (credit>=0 && credit <9){				//Credits is a number greater than zero and less than or equal to 8
					if (semester.match(semestermat)){			//The semester offered field is either 1, 2, or 3. 
						alert('Form submitted!');
						return true;
					}
					else{
						document.getElementById("courseCode").className = "valid";
						document.getElementById("courseTitle").className = "valid";
						document.getElementById("courseDiscipline").className = "valid";
						document.getElementById("level").className = "valid";
						document.getElementById("credit").className = "valid";
						document.getElementById("semester").className = "invalid";
						document.getElementById("author").className = "valid";
						alert('Invalid Semester!');
						return false;
					}
					
				}
				else{
					document.getElementById("courseCode").className = "valid";
					document.getElementById("courseTitle").className = "valid";
					document.getElementById("courseDiscipline").className = "valid";
					document.getElementById("level").className = "valid";
					document.getElementById("credit").className = "invalid";
					document.getElementById("semester").className = "valid";
					document.getElementById("author").className = "valid";
					alert('Credit Invalid');
					return false;
				}
			}
			else{
				document.getElementById("courseCode").className = "valid";
				document.getElementById("courseTitle").className = "valid";
				document.getElementById("courseDiscipline").className = "invalid";
				document.getElementById("level").className = "valid";
				document.getElementById("credit").className = "valid";
				document.getElementById("semester").className = "valid";
				document.getElementById("author").className = "valid";
				alert('Course Discip Invalid');
				return false;
			}
		}
		else{
			document.getElementById("courseCode").className = "invalid";
			document.getElementById("courseTitle").className = "valid";
			document.getElementById("courseDiscipline").className = "valid";
			document.getElementById("level").className = "valid";
			document.getElementById("credit").className = "valid";
			document.getElementById("semester").className = "valid";
			document.getElementById("author").className = "valid";
			alert('Course Code Invalid');
			return false
		}
	} 
	else {
	document.getElementById("courseCode").className = "invalid";
	document.getElementById("courseTitle").className = "invalid";
	document.getElementById("courseDiscipline").className = "invalid";
	document.getElementById("level").className = "invalid";
	document.getElementById("credit").className = "invalid";
	document.getElementById("semester").className = "invalid";
	document.getElementById("author").className = "invalid";
	alert("All fields are required.....!");
	return false;
	}
}
/*
function isNotValid(Value){
	document.getElementById("courseCode").className = "valid";
	document.getElementById("courseTitle").className = "valid";
	document.getElementById("courseDiscipline").className = "valid";
	document.getElementById("level").className = "valid";
	document.getElementById("credit").className = "valid";
	document.getElementById("semester").className = "valid";
	document.getElementById("author").className = "valid";
	//alert(""+ Value);

	if (document.getElementById("courseCode").className = Value){
		document.getElementById("courseCode").className = "invalid";
		alert(""+ Value);
	}
	else if (document.getElementById("courseTitle").className = Value){
		document.getElementById("courseTitle").className = "invalid";
		alert(""+ Value);
	}
	else if (document.getElementById("courseDiscipline").className = Value){
		document.getElementById("courseDiscipline").className = "invalid";
		alert(""+ Value);
	}
	else if (document.getElementById("level").className = Value){
		document.getElementById("level").className = "invalid";
		alert(""+ Value);
	}
	else if (document.getElementById("credit").className =Value){
		document.getElementById("credit").className = "invalid";
		alert(""+ Value);
	}
	else if (document.getElementById("semester").className = Value){
		document.getElementById("semester").className = "invalid";
		alert(""+ Value);
	}
	else if (document.getElementById("author").className =Value){
		document.getElementById("author").className = "invalid";
		alert(""+ Value);
	}

}*/