<?php

session_start();

require('functionsLibrary.php');        // Functions Library

if ($_SESSION['isLogin'] != '22Qr' && !isset($_SESSION['email'])) {   // Check to see If the user is logged on.  (isLogin must be set to 22Qr to be stay on this page!)
    session_destroy();
   // header('Location: index.php');
}



if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (!empty($_POST['deleteSubmit'])) {
        if($_POST['delete'] == 'Yes') {
            deleteAccount($_SESSION['email']);
            session_destroy();
            header('Location: index.php');
            $msg = "This one!";
        }else {
            header('Location: profile.php');
            $msg = "This one";
        }
    }
}







echo <<< HTML
<html lang="en">
<head>
    <title>Delete Account</title>
<meta name="author" content="Michael Gardner" />
<meta name="owner" content="intellabuzz" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="290359817712-t9oua6eg7028bnqgs03am9o84u2os6iv.apps.googleusercontent.com">
<!--  ** Menu  ** -->
<script src="java/jquery.js" type="text/javascript"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>

<meta charset="UTF-8" />
<!--  ** CSS  ** -->
<link type="text/css" href="css/styles.css" rel="stylesheet" />
<link type="text/css" href="css/nav.css" rel="stylesheet" />

<!--  ** Java ** -->
<script src="java/Alpha.js" type="text/javascript"></script>

</head>


<body>

<span class="menu-trigger"><img id="menuButton" name="menuButton" src="img/3squaresWhite.png"/> </span>
<div class="nav-menu">
    <ul class="clearfix">
        <li><a href="profile.php">Profile</a></li>
        <li><a href="publicClanPage.php">Public Page</a></li>
        <li><a href="search.php">Search</a></li>
    </ul>
</div>



<img id="logo" name="logo" src="img/clanPages.png" alt="Clan Pages Logo" />
<span id="clanName">$clanName</span>   <!-- FIX THIS CLAN NAME Variable-->
<header>
</header>



<div  style="margin-top: 55px;">
            <form name="accountGone" id="accountGone" method="post" action="$PHP_SELF" );">
                <h2>Are you sure you want to delete your account?</h2>
                <p>$msg</p>
                <input type="radio" name="delete" value="Yes"><br> Yes
                <br>
                <input type="radio" name="delete" value="No" checked> <br>No
                <br>
                <input type="submit" id="deleteSubmit" name="deleteSubmit" value="Delete Account">
                <br> <br>
              
            </form>
        </div>
</body>
</html>
HTML;

?>