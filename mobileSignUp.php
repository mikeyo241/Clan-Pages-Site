<?php
                /******************************************************
                 ***            Mobile Sign Up Page                 ***
                 ***                                                ***
                 ***    Created by:         Michael A Gardner       ***
                 ***    Updated:            26 September 2016       ***
                 ***    Class:              CPT - 283-001           ***
                 ***    Document:           mobileSignUp.php        ***
                 ***    CSS:                mobileSignUp.css        ***
                 ***    jQuery:             NONE                    ***
                 ***                                                ***
                 ******************************************************/







session_start();
require('functionsLibrary.php');

 if ($_SERVER['REQUEST_METHOD']=='POST') {
    //get the data from the form
    if (!empty($_POST['createSubmit'])) {
        $uname = checkEmail($_POST['eMail']);
        $pword = checkPass($_POST['pWord']);
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $cName = $_POST['cName'];
        $clanName = $_POST['clanName'];

        if (strlen($pword) < 1) {
            $msg = 'Password required, please try again';
        } else if (strlen($uname) < 1) {
            $msg = 'Email required, please try again';
        } else if (addAcct($uname, $pword, $fName, $lName, $cName, $clanName)) {
            $_SESSION['email'] = $uname;
            $_SESSION['isLogin'] = '22Qr';
            header('Location: profile.php');
        } else $msg = "Invalid Account Name";
    }
}



echo <<< HTML

<head>
<title>Clan Pages</title>
<meta name="author" content="Michael Gardner" />
<meta name="owner" content="intellabuzz" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8" />

<!--  ** CSS  ** -->
    <link type="text/css" href="css/mobileSignUp.css" rel="stylesheet" />
</head>

<header>
        <span id="Clan">Clan</span>
        <img id="clashLogo" name="clashLogo" src="img/clanPages.png" alt="Custom Clan Pages" />
        <span id="Pages">Pages</span>
</header>
<body>
<section id="signUp" >
    <form method="post" action="$PHP_SELF") ;">
    <table>
        <h2>Create a page for your clan</h2>
        <tbody>
            
            <tr><td><input type="text" name="fName" placeholder=" First name" maxlength="20" required></td></tr>
            <tr><td><input type="text" name="lName" placeholder=" Last name" maxlength="20" required></td></tr>      
            <tr><td colspan="2"><input type="email" name="eMail" placeholder=" Email" maxlength="40" required></td></tr>
            <tr><td colspan="2"><input type="password" name="pWord" placeholder=" Password" maxlength="25" required></td></tr>
            <tr><td colspan="2"><input type="text" name="cName" placeholder=" User Name"maxlength="30" required></td></tr>   
            <tr><td colspan="2"><input type="text" name="clanName" placeholder=" Clan Name "maxlength="45" required></td></tr>            
            <tr><td colspan="2"><input type="submit" id="createSubmit" name="createSubmit" value="Sign Up"></td></tr>
                   
        </tbody>
    </table>
    </form>
    <br>
    <input type="button" id="returnHome" value="Return Home"onclick="location.href='index.php';"
 </section>
</body>

HTML;

?>