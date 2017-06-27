// The Java
window.onload = purgeDate;

jQuery(document).ready(function() {
	jQuery(".menu-trigger").click(function(){
		
		jQuery(".nav-menu").slideToggle(600, function() {
			jQuery(this).toggleClass("nav-expanded").css('display', '');
		});
		
	});
	
});

function password() {
	document.getElementById("pass").innerHTML= "Password = WvsP__826__";
	document.getElementById("Tname").innerHTML= "Tournament Name = Wolfpack vs Pride"
}

function purgeDate() {
	var startingDate = new Date("October 09, 2016");
	var currentDate = new Date();
	while(currentDate > startingDate) {
		startingDate = addDays(startingDate, 14);
	}
	document.getElementById("purgeDate").innerHTML = "Date: " + startingDate.toDateString();
}
function addDays(date, days) {
	var result = new Date(date);
	result.setDate(result.getDate() + days);
	return result;
}


function onLoad() {
	gapi.load('auth2', function() {
		gapi.auth2.init();
	});
}
function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
		window.location = "signOut.php";
		console.log('User signed out.');
	});
}

