<?php



session_start();
$msg = '';

require('functionsLibrary.php');        // Functions Library

if ($_SESSION['isLogin'] != '22Qr' && !isset($_SESSION['email'])) {   // Check to see If the user is logged on.  (isLogin must be set to 22Qr to be stay on this page!)
session_destroy();
header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
        $Password = checkPass($_POST['password']);
        $vPassword = checkPass($_POST['verifyPassword']);
        if ($Password == $vPassword){
            if(change_password($Password, $_SESSION['email'])) {
                setChangedPWord($_SESSION['email'], 'N');
                $msg = "Success";
                header('Location: profile.php');
            } else $msg =  "Password Reset Failed";
        } else $msg = "Password Not Equal";
}


echo <<< HTML

<head>
    <title>Change Password</title>
    <meta name="author" content="Michael Gardner" />
    <meta name="owner" content="intellabuzz" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  ** Menu  ** -->
    <script src="java/jquery.js" type="text/javascript"></script>

    <meta charset="UTF-8" />
    <!--  ** CSS  ** -->
    <link type="text/css" href="css/styles.css" rel="stylesheet" />
    <link type="text/css" href="css/nav.css" rel="stylesheet" />
    <link type="text/css" href="css/publicClanPage.css" rel="stylesheet" />
    <!--  ** Java ** -->
    <script src="java/jquery.js" type="text/javascript"></script>
    <script src="java/validatePword.js" type="text/javascript"></script>
    <style type="text/css">
    input {
            width: 75%;
            height: 41px;
            margin: 3px;
            font-weight: bold;
            font-size: 20px;
            border-radius: 20px;
    }
    button {
            width: 75%;
            height: 41px;
            margin: 3px;
            background-color: #52627b;
            color: #99cccc;
            font-weight: bold;
            font-size: 20px;
            border-radius: 20px;
    }
</style>

</head>


<body style="text-align: left;">




    <img id="logo" name="logo" src="img/clanPages.png" alt="Clan Pages Logo" />
    <span id="clanName">Clan Pages</span>   <!-- FIX THIS CLAN NAME Variable-->
    <header>
    </header>
    
    
    <div id="loginSmall" style="    margin: 65px auto 10px auto; text-align: center;">
        <h2>Change your temporary password</h2>
            <form name="changePword" id="changePword" method="post" action="$PHP_SELF");">
                <span id="notify">$msg</span>
                <br>
                <input type="password" name="password" placeholder=" Password" id="password">
                <br>
                <input type="password" name="verifyPassword" placeholder=" Re-Type Password" id="verifyPassword"> 
                <br> <br>
                <button type="button" onclick="verify()">Change Password</button>  
            </form>
    </div>
    
    
    
</body>
HTML;
