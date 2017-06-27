<?php
                /******************************************************
                 ***            Forgot Password                     ***
                 ***                                                ***
                 ***    Created by:         Michael A Gardner       ***
                 ***    Updated:            26 September 2016       ***
                 ***    Class:              CPT - 283-001           ***
                 ***    Document:           forgotPassword.php      ***
                 ***    CSS:                mainCss.css             ***
                 ***    jQuery:             NONE                    ***
                 ***                                                ***
                 ******************************************************/






/*
 * It would probably be better if the password wasn't changed on this page.
 * Instead send an email with a link to the page to change the password on
 * for now the password will be changed here and also displayed here because
 * I can't figure out how to send an email with the cit server
 */
 session_start();
$password = '';
error_reporting(E_ALL); ini_set('display_errors', 1);
require('functionsLibrary.php');


$msg = '';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    //get the data from the form
    if (!empty($_POST['emailSubmit'])) {
        $email = $_POST['email'];
        $email = checkEmail($email);
        $email = fixSql($email);
        if($pass = sendNewPass($email)) {
            $msg = "An Email was send to: $email. It will be coming from intellabuzz@gmail.com. If it is not in your inbox check your Spam folder.";
            setChangedPWord($email, 'Y');
        }else $msg = "Password reset failed.";
    }else {
        $msg = '';      $password = '';
    }
}
 echo <<< HTML
<html>

<head>
  <title>Clan Pages</title>
  <meta name="author" content="Michael Gardner" />
  <meta name="owner" content="intellabuzz" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8" />
  
  <!--  **** CSS  **** -->
  
  <style>
    @font-face{
      font-family: clash;
      src: url(css/clash.ttf);
    }
  </style>

  <!-- **** Latest compiled Bootstrap CSS **** -->
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
  <img id="clashLogo" name="clashLogo" src="img/clanPages.png" alt="Custom Clan Pages" style="width: 4em;
    position: fixed;
    left: 47%;
    z-index: 1050;
    top: 4px;"/>
  <nav class="navbar navbar-inverse navbar-fixed-top">

    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="index.php" style="font-family: clash">Clan Pages</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
  
        </ul>
        <ul class="nav navbar-nav navbar-right">
  
        </ul>
      </div>
    </div>
  </nav>

<div class="col-sm-12" style="height: 50px;"></div>  <!-- This is used as a padding so the nothing is under the nav bar.   -->

  <!--  **** END NAVIGATION BAR   *****   -->
 
  <!--  **** MAIN FORGOT PASSWORD FORM  *******    -->
  
    <div class="col-sm-3"></div>
    <div class="col-sm-6 well">
      <h3 class="text-center">Enter your account email below to reset your password</h3>
      <h4 style="color: red">$msg</h4>
      <form name="forgot" id="forgot" method="post" action="$PHP_SELF">
        <div class="form-group row">
          <input class="form-control form-control-lg" type="email" name="email" id="email" placeholder=" Email">
        </div>
        <div class="form-group row">
            <input type="submit" class="btn btn-primary" name="emailSubmit" id="emailSubmit">
            <button class="btn btn-info" onclick="location.href='index.php';">Return Home</button>
        </div>
      </form>
      $password
    </div>
<!--    *****    END FORGOT PASSWORD FORM  --->




<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled BOOTSTRAP JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>








HTML;
