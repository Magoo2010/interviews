$(document).ready(function(){    
$("#createNewUserButton").click(function() {
	$("#createNewUserButton").addClass("disabled");
	
	var title = $("input#inputTitle").val();
	var forenames = $("input#inputForenames").val();
	var surname = $("input#inputSurname").val();
	var course = $("input#inputCourse").val();
	var location_type = $("select#inputStudentLocationType").val();
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
	var optout = $("input#inputOptOut").val();
	
	var sendemail = $("input#sendEmail").val();
	
	// url we're going to send the data to
	var url = "modules/students/actions/create.php";
	
	$.post(url,{
		title: title,
		forenames: forenames,
		surname: surname,
		course: course,
		location_type: location_type,
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
		optout: optout,
		sendemail: sendemail
	}, function(data) {
		$("#responseAdded").append(data);
	},'html');
	
	return false;
});

$("#updateUserButton").click(function() {
	$("#updateUserButton").addClass("disabled");
	
	var userUID = $("input#userUID").val();
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
	var optout = $('input#inputOptOut').prop('checked');
	
	if (optout == true) {
		var optout = '1';
	} else {
		var optout = '0';
	}
	
	var sendemail = $("input#sendEmail").val();
	
	// url we're going to send the data to
	var url = "modules/students/actions/update.php";
	
	$.post(url,{
		uid: userUID,
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
		optout: optout,
		sendemail: sendemail
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

$(".deleteUserButton").click(function() {
	var r=confirm("Are you sure you want to delete this booking?");
	
	if (r==true) {
		var uid = $(this).attr('id');
		
		var url = 'modules/students/actions/delete.php';
		
		// perform the post to the action (take the info and submit to database)
		$.post(url,{
		    uid: uid
		}, function(data){
			$(this).parent().parent().parent().parent().parent().fadeOut();
		},'html');
	} else {
	}
	
	return false;
});

});