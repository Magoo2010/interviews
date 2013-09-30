$("#submit_form").click(function() {
	$("#submit_form").addClass("disabled");
	
	// validate and process form here
	// jobUID
	var userUID = $("input#userUID").val();
	if (userUID == "") {
		alert("There is no user UID specified.  Please contact an Administrator.");
		
		return false;
	}
	
	var title = $("input#inputTitle").val();
	var forenames = $("input#inputForenames").val();
	var surname = $("input#inputSurname").val();
	var course = $("input#inputCourse").val();
	var add1 = $("input#inputAdd1").val();
	var add2 = $("input#inputAdd2").val();
	var add3 = $("input#inputAdd3").val();
	var add4 = $("input#inputAdd4").val();
	var add5 = $("input#inputAdd5").val();
	var email = $("input#inputEmail").val();
	var phone = $("input#inputPhone").val();
	var skype = $("input#inputSkype").val();
	var arrival_date = $("input#userUID").val();
	var arrival_time = $("input#userUID").val();
	var disability = $("textarea#inputDisability").val();
	var diet = $("textarea#inputDiet").val();
	var feedback = $("input#inputFeedback").val();
	
	// url we're going to send the data to
	var url = "modules/students/actions/update.php";
	
	$.post(url,{
		userUID: userUID,
		title: title,
		forenames: forenames,
		surname: surname,
		course: course,
		add1: add1,
		add2: add2,
		add3: add3,
		add4: add4,
		add5: add5,
		email: email,
		phone: phone,
		skype: skype,
		arrival_date: arrival_date,
		arrival_time: arrival_time,
		disability: disability,
		diet: diet,
		feedback: feedback
	}, function(data) {
		$("#response_added").append(data);
	},'html');
	
	return false;
});

$("#submit_contact_form").click(function() {
	// validate and process form here
	var email = $("input#inputEmail").val();
	if (email == "") {
		alert("Please enter a valid E-Mail address");
		return false;
	}
	var ucas = $("input#inputUCAS").val();
	var course = $("input#inputCourse").val();
	var name = $("input#inputName").val();
	var description = $("textarea#inputDescription").val();
	
	// provide feedback - disable button for double submit
	$("#submit_contact_form").addClass("disabled");
	$("#submit_contact_form").html("Submitting");
	
	// url we're going to send the data to
	var url = "actions/contact_email.php";
	
	$.post(url,{
		email: email,
		ucas: ucas,
		course: course,
		name: name,
		description: description
	}, function(data) {
		$("#response_added").append(data);
		
		$("#submit_contact_form").removeClass("disabled");
		$("#submit_contact_form").html("Submit");

	},'html');
	
	return false;
});

$.fn.extend({
	insertAtCaret: function(myValue){
		var obj;
		if( typeof this[0].name !='undefined' ) obj = this[0];
		else obj = this;
		
		if ($.browser.msie) {
			obj.focus();
			sel = document.selection.createRange();
			sel.text = myValue;
			obj.focus();
		} else if ($.browser.mozilla || $.browser.webkit) {
			var startPos = obj.selectionStart;
			var endPos = obj.selectionEnd;
			var scrollTop = obj.scrollTop;
			obj.value = obj.value.substring(0, startPos)+myValue+obj.value.substring(endPos,obj.value.length);
			obj.focus();
			obj.selectionStart = startPos + myValue.length;
			obj.selectionEnd = startPos + myValue.length;
			obj.scrollTop = scrollTop;
		} else {
			obj.value += myValue;
			obj.focus();
		}
	}
});

$("#email_insert_uid").click(function() {
	$('#confirmation_email').insertAtCaret("{{uid}}");
});
$("#email_insert_ucas").click(function() {
	$('#confirmation_email').insertAtCaret("{{ucas}}");
});
$("#email_insert_confirmed_attendance").click(function() {
	$('#confirmation_email').insertAtCaret("{{confirmed_attendance}}");
});
$("#email_insert_title").click(function() {
	$('#confirmation_email').insertAtCaret("{{title}}");
});
$("#email_insert_forenames").click(function() {
	$('#confirmation_email').insertAtCaret("{{forenames}}");
});
$("#email_insert_surname").click(function() {
	$('#confirmation_email').insertAtCaret("{{surname}}");
});

$('#dp3').datepicker();