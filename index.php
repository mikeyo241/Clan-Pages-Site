<?php
                /******************************************************
                 ***            Clan Pages - Home Page              ***
                 ***                                                ***
                 ***    Created by:         Michael A Gardner       ***
                 ***    Updated:            26 September 2016       ***
                 ***    Class:              CPT - 283-001           ***
                 ***    Document:           profile.php             ***
                 ***    CSS:                mainCss.css             ***
                 ***    jQuery:             NONE                    ***
                 ***                                                ***
                 ******************************************************/





session_start();
$msg = '';
$displayResults = 'none';
$_SESSION['attempts'] = 0;
require('functionsLibrary.php');

if ($_SERVER['REQUEST_METHOD']=='POST') {
    //get the data from the form
    if(!empty($_POST['createSubmit'])) {
        $uname = checkEmail($_POST['eMail']);
        $pword = checkPass($_POST['pWord']);
        $fName = fixSql($_POST['fName']);
        $lName = fixSql($_POST['lName']);
        $cName = fixSql($_POST['cName']);
        $clanName= fixSql($_POST['clanName']);

        if (strlen($pword) < 6) {
            $msg = 'Password must be 6 characters long, please try again';
        } else if (strlen($uname) < 1) {
            $msg = 'Email required, please try again';
        } else if (addAcct($uname, $pword, $fName, $lName, $cName, $clanName)) {
            $msg = "Account Added";
        } else $msg = "Invalid Account Name";
    }
    if(!empty($_POST['loginSubmit'])) {
        $lEmail = checkEmail($_POST['logEmail']);;
        $lPass = checkPass($_POST['logPWord']);
        if (strlen($lPass) < 6) {
            $msg = 'Password must be at least 6 characters long, please try again';
            $_SESSION['isLogin'] = '0';
        } else if (strlen($lEmail) < 1) {
            $msg = 'Email required, please try again';
            $_SESSION['isLogin'] = '0';
        } else if ($_SESSION['attempts'] >= 5) {
            $msg = "Please use the forgot password link to reset your password. ";

        } else if (checkLogin($lEmail, $lPass)) {
            $msg = "Login Success";
            $_SESSION['email'] = $lEmail;
            $_SESSION['isLogin'] = '22Qr';
            //if(getChangedPWord($lEmail) == 'Y'){
            //    header('Location: changePword.php');
            //} else
          header('Location: profile.php');

        } else {
            $msg = "Login Failed";
            $_SESSION['isLogin'] = '0';
            $_SESSION['attempts'] = $_SESSION['attempts'] + 1;
        }
    }
    if(!empty($_POST['findSubmit'])) {

        $fCT = fixSql($_POST['findClanTag']);
        $searchResult = checkPage($fCT);
        if (strlen($fCT) < 1) {
            $msg = 'Clan Tag Required';
        }else if ($searchResult == false) {
            $displayResults = 'none';
            $clansFound[0] = 'There are no clans with that name.';
        }
        else {
            if($searchResult->num_rows > 0){
                $displayResults = 'block';
                $i = 0;
                while($row = $searchResult->fetch_assoc()) {
                    $clanTag = $row['CLAN_TAG'];
                    $clanName = $row['CLAN_NAME'];
                    $clanLeader = $row['CLAN_LEADER'];
                    $clansFound[$i] = "<input type='radio' name='clanSelected' value='$clanTag' required >Clan Name: $clanName <br>Clan Leader: $clanLeader <br> ";
                    $i++;
                }
            }else{
                $displayResults = 'none';
                $clansFound[0] = 'There are no clans with that name.';}
        }

    }
    if(!empty($_POST['chosenClan'])) {
        $clanTag = $_POST['clanSelected'];
        if($clanTag != null) {
            $_SESSION['TAG'] = $clanTag;
            header('Location: clashGen.php');
        }

    }
}



echo <<< HTML
<html>

<head>
<title>Clash Pages</title>
<meta name="author" content="Michael Gardner" />
<meta name="owner" content="intellabuzz" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8" />

<!--  ** CSS  **
    <link type="text/css" href="css/mainCss.css" rel="stylesheet" />  -->
    
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
@media (min-width: 768px) {
    .dropdown-menu {
        width: 300px !important;  /* change the number to whatever that you need */
    }
}

@font-face{
    font-family: clash;
    src: url(css/clash.ttf);
}

</style>

</head>

<body>
<img id="clashLogo" name="clashLogo" src="img/clanPages.png" alt="Custom Clan Pages" style="width: 4em;
    position: fixed;
    left: 47%;
    z-index: 1050;
    top: 4px;"/>
<nav class="navbar navbar-inverse  navbar-fixed-top">

  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#" style="font-family: clash">Clan Pages</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
      <!-- This is where horizontal links go place them in <li><a href=""></li>'s to get desired affect.  -->

      </ul>
      <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-log-in"></span> Login
        <span class="caret"></span></a>
      <ul class="dropdown-menu col-xs-15">
        <div class="form-group row">
          <form name="login" id="login" method="post" action="$PHP_SELF"> 
            <li><h3 class="text-center" style="font-family: clash">Enter Credentials</h3></li>
            <li><div class="col-xs-10 col-md-offset-1 text-center"><input class="form-control" maxlength="40" type="email" name="logEmail" id="logEmail" placeholder="Email"></div></li>
            <li><div class="col-xs-10 col-md-offset-1 text-center"><input class="form-control" maxlength="100" type="password" name="logPWord" id="logPWord" placeholder="Password"></div></li>
            <br> <br> <br> <br>
            <li class="text-center" ><a href="forgotPassword.php"><span>Forgot your password?</span></a></li>
            <li><div class="col-xs-10 col-md-offset-4"><input class="btn" type="submit" name="loginSubmit" value="Login" style="margin: 10px;"></div></li>
            
          </form>
        </div>

      </ul>
    </div>
  </div>
</nav>
<div class="col-sm-12" style="height: 50px;"></div>  <!-- This is used as a padding so the nothing is under the nav bar.   -->

<!--  **** END NAVIGATION BAR   *****   -->



    

    <div class="col-sm-1"></div>
    
    
        <div class="col-sm-5" >
    <form method="post" action="$PHP_SELF">   
        <h2 class="text-center" style="font-family: clash">Create an Account</h2>
        
           <input class="form-control " type="text" name="fName" placeholder=" First name" maxlength="20" autocomplete="off" required>
           <input class="form-control" type="text" name="lName" placeholder=" Last name" maxlength="20" autocomplete="off" required>       
           <input class="form-control" type="email" name="eMail" placeholder=" Email" maxlength="40" autocomplete="off" required>
           <input class="form-control" type="password" name="pWord" placeholder=" Password" maxlength="25" autocomplete="off" required>
           <input class="form-control" type="text" name="cName" placeholder=" User Name"maxlength="30" autocomplete="off" required>
           <input class="form-control" type="text" name="clanName" placeholder=" Clan Name "maxlength="45" autocomplete="off" required>        
           <div class="col-xs-10 col-md-offset-4"><input class="btn text-center" type="submit" name="createSubmit" value="Sign Up"></div>
    </form>
    <br> <br> <br>
  </div>
  
  
    <div class="col-sm-4" >
        <div id="clanPages" name="clanPages">
        <h1 class="text-center" style="font-family: clash" >Find A Clan</h1>
        <p style="color: red">$msg</p>
        <p>Search for an existing clan</p>
        <form class="form-inline" method="post" action="$PHP_SELF">
          <div class="form-group">
            <input class="form-control"type="text" id="search" name="findClanTag" placeholder=" Clan Name" maxlength="20" required>
          </div>
            <input class="btn" type="submit" id = "findSubmit" name="findSubmit" value="Search">
       
        </form>
        <form method="post" action="$PHP_SELF" >
HTML;
    if(isset($clansFound)) {
        foreach ($clansFound as $value) {
            echo $value;
        }
    }
echo <<< HTML
            <input style="display: $displayResults;" type="submit" id = "chosenClan" name="chosenClan" value="Search">
        </form>
        </div>
        
 
   



</div>
</body>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>

HTML;

?>