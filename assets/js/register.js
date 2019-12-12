$(document).ready(function() {

	//On click Sign Up, Hide Login Page and Show Registration
	$("#signup").click(function() {
		$("#first").slideUp("slow", function() {
			$("#second").slideDown("slow");
		});

	});

	//On click Sign In, Hide Registration Page and Show Login
	$("#signin").click(function() {
		$("#second").slideUp("slow", function() {
			$("#first").slideDown("slow");
		});

	});
});