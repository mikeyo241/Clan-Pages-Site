/**
 * Created by mikey on 12/3/2016.
 */
$(document).ready(
    function() {
        $('#password').keyup(
            function() {
                verifyPassword();
            });
    })

$(document).ready(
    function() {
        $('#verifyPassword').keyup(
            function() {
                verifyPassword();
            });
    })


function verifyPassword() {

    var
        password,
        verifyPassword,
        isValid = false,
        passwordWarning;

    password = document.getElementById("password").value;		// The value of gallons field inputed by the user
    verifyPassword = document.getElementById("verifyPassword").value;

    if (!password == verifyPassword) {
        passwordWarning = "Passwords Don't Match!";
        document.getElementById("password").style.backgroundColor = "#F2ED55";
        document.getElementById("verifyPassword").style.backgroundColor = "#F2ED55";
    }else if (password.length <6 && verifyPassword.length <6 ) {
        passwordWarning = "Password must be at least 6 characters";
        document.getElementById("password").style.backgroundColor = "#F2ED55";
        document.getElementById("verifyPassword").style.backgroundColor = "#F2ED55";
    } else {
        passwordWarning = "";
        isValid = true;
        document.getElementById("password").style.backgroundColor = "white";
        document.getElementById("verifyPassword").style.backgroundColor = "white";
    }
    document.getElementById("notify").innerHTML = passwordWarning;

    return isValid;
}

function verify() {
    var
        passValidate = false;
    passValidate = verifyPassword();

    if (passValidate) {
        document.getElementById("changePword").submit();
    }

}
