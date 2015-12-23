// Validate Data input from form
function load_task_data(inputId, regEx, errId){
	var inputType = document.getElementById(inputId).type;
	if (inputType = 'text') {
		// var re = new RegExp(/^[a-zA-Z0-9_\- ]+$/);
		var re = new RegExp(regEx);
		if(re.test(document.getElementById(inputId).value)){
			document.getElementById(inputId).style.background ='#ccffcc';
			document.getElementById(errId).style.display = "none";
			return true;
		} else {
			document.getElementById(inputId).style.background ='#e35152';
			document.getElementById(errId).style.display = "inline";
			document.getElementById(errId).innerHTML = "invalid input!";
			return false;
		}
	} else if (inputType = 'password') {
		var minLength = regEx;
		var inputLength = document.getElementById(inputId).value.length;
		if (inputLength < minLength){
			ocument.getElementById(inputId).style.background ='#e35152';
			document.getElementById(errId).style.display = "inline";
			document.getElementById(errId).innerHTML = "password must contain at least "+regEx+" characters!";
			return false;
		} else {
			document.getElementById(inputId).style.background ='#ccffcc';
			document.getElementById(errId).style.display = "none";
			return true;
		}
	}
}

function checkform(form) {
    // get all the inputs within the submitted form
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        // only validate the inputs that have the required attribute
        if(inputs[i].hasAttribute("required")){
            if(inputs[i].value == ""){
                // found an empty field that is required
                alert("Please fill all required fields");
                return false;
            }
        }
    }
    return true;
}