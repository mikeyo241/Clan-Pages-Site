<?php
                /******************************************************
                 ***               Functions Library                ***
                 ***                                                ***
                 ***    Created by:         Michael A Gardner       ***
                 ***    Updated:            26 September 2016       ***
                 ***    Class:              CPT - 283-001           ***
                 ***    Document:           functionsLibrary.php    ***
                 ***                                                ***
                 ******************************************************/







//   ** Variables  **
$PHP_SELF = htmlspecialchars($_SERVER['PHP_SELF']);




/**********************************************************************************
 ***                        Functions List                                      ***
 ***                                                                            ***
 ***    dbConnect       ( $hostname, $db_user, $db_pword, $db_database )        ***
 ***    cleanIt         ( $data )                                               ***
 ***    checkEmail      ( $email )                                              ***
 ***    checkPass       ( $txt )                                                ***
 ***    fixSql          ( $data )                                               ***
 ***    isAvailable     ( $email )                                              ***
 ***    addAcct         ( $email, $pw, $fName, $lName, $userName, $clanName )   ***
 ***    checkLogin      ( $email, $pw )                                         ***
 ***    checkPage       ( $clanName )                                           ***
 ***    getData         ( $tag )                                                ***
 ***    getDataProfile  ( $email )                                              ***
 ***    getAccNew       ( $email )                                              ***
 ***    update          ()                                                      ***
 ***    sendNewPass     ( $email )                                              ***
 ***    random_string   ( $length, $characters )                                ***
 ***    change_password ( $pass, $email )                                       ***
 ***                                                                            ***
 **********************************************************************************
 */





/** Function:       dbConnect
 * Last Modified:   2 November 2016
 * @param string    $hostname - host name of the server.
 * @param string    $db_user - the database user name.
 * @param string    $db_pword - the database password.
 * @param string    $db_database - the database to use.
 * @return          mysqli - is the mysqli link to the server make sure to close the connection when done!
 * Description:     This is used to connect to the database unless spcified uses default values.
 */
function dbConnect($hostname = 'localhost',$db_user='USERNAME',$db_pword='PASSWORD',$db_database='DATABASE')
{
    $link = mysqli_connect($hostname, $db_user, $db_pword, $db_database) or die ("failed to connect");
    return $link;
}







/**  Function:      cleanIT
 * Last Modified:   2 November 2016
 * @param           $data - Will be trim(),stripslashes(), and htmlspacialchar() so that nothing bad remains in the variable.
 * @return          string - That has been cleaned as described.
 * Description:		This function is used to test the input and stop possible security threats.
 */
function cleanIt($data) {
    $data = trim($data);					// Strip any extra white space. ex. http://php.net/manual/en/function.trim.php
    $data = stripslashes($data);			// Strip any slashes in the input.  ex. http://php.net/manual/en/function.stripslashes.php
    $data = htmlspecialchars($data);		// This changes Special characters to non html special characters.  ex. http://php.net/manual/en/function.htmlspecialchars.php
    return $data;
}







/** Function:   checkEmail
 * Last Modified:   2 November 2016
 * @param           $email - user imputed E-Mail Address.
 * @return          mixed|string - Returns a cleaned E-Mail Address.
 * Description:     Used clean and verify that the user imputed email address is clean and correct.
 */
function checkEmail($email){
    $email = cleanIt($email);                                       // See cleanIt function above.
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);              // Removes all characters except letters, digits and !#$%&'*+-=?^_`{|}~@.[].
    if (!$email = filter_var($email,FILTER_VALIDATE_EMAIL)) {       // Validates whether the value is a valid e-mail address. In general, this validates e-mail addresses against the syntax in RFC 822, with the exceptions that comments and whitespace folding and dotless domain names are not supported.
        $email = 'NOT Valid';
    }
    $email = fixSql($email);
    // Need to check to see if the username matches the password.
    RETURN  $email;
}



function googlesign() {
    $clientid = 'Private ID';
    $clientSecret = 'Private Secret';
}



/** Function:   checkPass
 * Last Modified:   2 November 2016
 * @param       $txt -   Password    -- Before md5 Encryption --
 * @return      mixed|string - Returns a cleaned Password.
 * Description: Used to clean the user entered password.
 */
function checkPass($txt)
{
    $txt = cleanIt($txt);
    $txt = filter_var($txt, FILTER_SANITIZE_STRING);    // Strip tags, optionally strip or encode special characters.
    $txt = fixSql($txt);
    // Make sure there is no sequence.
    // Make sure the password doesn't form a word in the english language.
    // Make sure they can't put dumb passwords like 'password'
    // Check the min length requirement.
    return $txt;
}











/** Function:       fixSql
 * Last Modified:   26 November 2016
 * @param           $data -  The data tha needs to be filtered.
 * @return          string - Characters encoded are NUL (ASCII 0), \n, \r, \, ', ", and Control-Z.
 * Description:     Used to clean any form input that will go into the database.
 */
function fixSql($data) {
    $data = cleanIt($data);
    $link = dbConnect();
    $data = mysqli_real_escape_string($link, $data);/*  Characters encoded are NUL (ASCII 0), \n, \r, \, ', ", and Control-Z.   */
    $link->close();
    return $data;
}











/** Function:       isAvailable
 * Last Modified:   2 November 2016
 * @param           $email - User imputed Email address     (40 characters MAX)
 * @return          bool - Returns True if the Username is already Taken.
 * Description:     Used to check if an email is in the database.  (email is the primary key for all tables)
 */
function isAvailable($email){

//      *** Establish a connection to the database  ***
    $link = dbConnect();

//      *** Database Query ***
    $qry = "SELECT ACC_EMAIL FROM MAG_ACCOUNT WHERE ACC_EMAIL = '$email'";

    if($result = mysqli_query($link,$qry)) {            // Implement query
        if (mysqli_num_rows($result) > 0) {             // If there are any matches to the email return true
            $link->close();
            return true;                                // True - There is an account with that email -- User can't make an account with that email!!--
        }
    }else {  // Query Failed - Error Messages Not shown !!!!
//        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;                                   // False - There is no account with that email -- User can make an account! --
    }
    return false;
}

















/** Function:   addAcct    ***
 * Last Modified:   23 November 2016
 * @param           $email      -   Email address  40 characters long
 * @param           $pw         -   Password    md5 Encrypted password      Always 32 characters long
 * @param           $fName      -   First Name  20 characters long
 * @param           $lName      -   Last Name   20 characters long
 * @param           $userName   -   User Name   30 characters long
 * @param           $clanName   -   Clan Name   45 characters long
 * @return          bool        -   Returns True if the new user is successfully entered into the database.
 * Description:     This is used to add a new account to the database.
 */

function addAcct($email, $pw, $fName, $lName, $userName, $clanName)
{
//      ** Check input for database exploits **
    checkEmail($email); checkPass($pw);
    fixSql($email);     fixSql($pw);        fixSql($fName);
    fixSql($lName);     fixSql($userName);  fixSql($clanName);

    $pw = md5($pw);
    if (isAvailable($email)) {
        return false;  // if checkLogin is true then the username is taken
    } else {

//      *** Establish a connection to the database  ***
        $link = dbConnect();


//      *** Database Query's  ***

        $qry = "INSERT INTO MAG_ACCOUNT (ACC_EMAIL, ACC_PASS) VALUES ('$email', '$pw')";
        $qry2 = "INSERT INTO MAG_PERSON (ACC_EMAIL, PER_FNAME, PER_LNAME, PER_CNAME) VALUES ('$email','$fName','$lName','$userName')";
        $qry3 = "INSERT INTO MAG_TEMP (CLAN_NAME, ACC_EMAIL, CLAN_LEADER) VALUES ('$clanName','$email','$userName')";

//      *** Implement Query's   ***

       if( mysqli_query($link, $qry));
        else {             // Query Failed - Error Messages Not shown !!!!
        echo "Error Qry 1: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
      }
        if(mysqli_query($link, $qry2));
        else {             // Query Failed - Error Messages Not shown !!!!
          echo "Error Qry 2: " . $qry . "<br>" . mysqli_error($link);
          $link->close();
          return false;
        }
        if(mysqli_query($link, $qry3));
        else {             // Query Failed - Error Messages Not shown !!!!
          echo "Error Qry 3: " . $qry . "<br>" . mysqli_error($link);
          $link->close();
          return false;
        }

//      ***     Close Connection    ***
        $link->close();
        return true;
    }
}












/** Function:       checkLogin
 * Last Modified:   2 November 2016
 * @param           $email - Email address  (40 characters MAX)
 * @param           $pw -    Password    md5 Encrypted password      Always 32 characters long
 * @return          bool - Will return true if the user exists and the password is correct.
 * Description:     This function is used to determine if the Email and password entered on the
 *                  login page match the username and password in the database.
 */

function checkLogin($eMail, $password){
//      ** Check input for database exploits **
    fixSql($eMail);
    $password = md5($password);



//      *** Establish a connection to the database  ***
    $link = dbConnect();

//      *** Database Query's    ***
    $qry = "SELECT * FROM MAG_ACCOUNT WHERE ACC_EMAIL = '$eMail'";

    if($result = mysqli_query($link,$qry)) {                // Implement the query
        if (mysqli_num_rows($result) == 1) {                // There can only be 1 entry for email no duplicates.
            $res = mysqli_fetch_assoc($result);             // Put the result into an array
            $_SESSION['email'] = $res['ACC_EMAIL'];         // Session variable is set -- email is used to get any information about the user from the database --
            $link->close();
            if($password == $res['ACC_PASS']) return true;
            else return false;
        }
    }else {             // Query Failed - Error Messages Not shown !!!!
        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
    }
    return false;
}









/**Function:        checkPage
 * Last Modified:   25 November 2016
 * @param           $clanName - The name of a Clan to search for.
 * @return          bool|mysqli_result - (CLAN_NAME, CLAN_TAG, CLAN_LEADER) or false if clan not found.
 * Description:     This function searches for a specified clan name and returns the Clan Name, Clan Tag, and Clan Leader if found.
 */
function checkPage($clanName){

//      ** Check input for database exploits **
    fixSql($clanName);

//      *** Establish a connection to the database  ***
    $link = dbConnect();

//      *** Database Query **
    $qry = "SELECT CLAN_NAME, CLAN_TAG, CLAN_LEADER FROM MAG_TEMP WHERE CLAN_NAME LIKE '%$clanName%'";

    if($result = mysqli_query($link,$qry)) {       // Implement query
        if (mysqli_num_rows($result) >= 1) {       // If there is 1 or more clans with the name entered return all the clans with that name
            $link->close();
            return $result;
        }
    }else {     // Query Failed - Error Messages Not shown !!!!
//        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
    }
}






function getUsername($email) {
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "SELECT PER_CNAME FROM MAG_PERSON WHERE ACC_EMAIL= '$email'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $res = mysqli_fetch_assoc($result);
        $link->close();
        return $res['PER_CNAME'];
    }
}









/** function:       getData
 * Last Modified:   25 November 2016
 * @param           $tag - Clan Tag
 * @return          array|bool|null - Returns all Clan data or False if no clan has the clan_tag.
 * Description:     Used to get all the data for a clan by searching for the clans CLAN_TAG in the database.
 */
function getData($tag){
    $link = dbConnect();
    $qry = "SELECT * FROM MAG_TEMP WHERE CLAN_TAG='$tag'";
    if($result = mysqli_query($link,$qry)) {
        $res = mysqli_fetch_assoc($result);
        $link->close();
        return $res;
    }else {    // Query Failed - Error Messages Not shown !!!!
        $link->close();
        return false;
    }
}












/** Function:       getDataProfile
 * Last Modified:   25 November 2016
 * @param           $email  -   Email Address   (40 characters MAX)
 * @return          array|bool|null
 * Description:     Used to get all the data for a clan by searching for the clans CLAN_TAG in the database.
 */
function getDataProfile($email ){
    $link = dbConnect();
    $qry = "SELECT * FROM MAG_TEMP WHERE ACC_EMAIL ='$email'";
    if($result = mysqli_query($link,$qry)) {
        $res = mysqli_fetch_assoc($result);
        $link->close();
        return $res;

    }else {   // Query Failed - Error Messages Not shown !!!!
//        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
    }
}
























/**Function:        getAccNew
 * Last Modified:   25 November 2016
 * @param           $email  -   Email Address       (40 characters MAX)
 * @return          array|bool|null
 * Description:     Used to get all the data for a clan by searching for the clans CLAN_TAG in the database.
 */
function getAccNew($email){
    $link = dbConnect();
    $qry = "SELECT * FROM MAG_ACCOUNT WHERE ACC_EMAIL= '$email'";
    if($result = mysqli_query($link,$qry)) {
        $res = mysqli_fetch_assoc($result);
        $link->close();
        return $res;

    }else {    // Query Failed - Error Messages Not shown !!!!
//        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
    }
}





















/**Function:        update()
 * Last Modified:   25 November 2016
 * @return bool
 * Description:     Used to get all the data for a clan by searching for the clans CLAN_TAG in the database.
 */
function update(){
    $data = getDataProfile($_SESSION['email']);
    $email = fixSql($_SESSION['email']);
    $b = fixSql($_POST['topFirst']);      $c = fixSql($_POST['topFirstDon']);
    $d = fixSql($_POST['topSecond']);     $e = fixSql($_POST['topSDon']);       $f = fixSql($_POST['topThird']);        $g = fixSql($_POST['topTDon']);
    $h = fixSql($_POST['topBestDonor']);  $i = fixSql($_POST['topBDon']);       $j = fixSql($_POST['topBestClanDon']);  $k = fixSql($_POST['purgeMemReq']);
    $l = fixSql($_POST['purgeEldReq']);   $m = fixSql($_POST['purgeCoReq']);    $n = fixSql($_POST['elderReq']);        $o = fixSql($_POST['coReq']);
    $p = fixSql($_POST['miscRule']);      $q = fixSql($_POST['clanLeader']);    $r = fixSql($_POST['clanLeaderDesc']);  $s = fixSql($_POST['secondInCommand']);
    $t = fixSql($_POST['secondInDesc']);  $u = fixSql($_POST['clanColeaders']);
    $id = fixSql($_SESSION['id']);

    if ($b == '') $b = $data['TOP_FIRST'];
    if ($c == '') $c = $data['TOP_FIRSTDONATIONS'];
    if ($d == '') $d = $data['TOP_SECOND'];
    if ($e == '') $e = $data['TOP_SDON'];
    if ($f == '') $f = $data['TOP_THIRD'];
    if ($g == '') $g = $data['TOP_TDON'];
    if ($h == '') $h = $data['TOP_BESTDON'];
    if ($i == '') $i = $data['TOP_BDON'];
    if ($j == '') $j = $data['TOP_BESTCLANDON'];
    if ($k == '') $k = $data['PURGE_MEMREQ'];
    if ($l == '') $l = $data['PURGE_ELDREQ'];
    if ($m == '') $m = $data['PURGE_COREQ'];
    if ($n == '') $n = $data['ELDER_REQ'];
    if ($o == '') $o = $data['CO_REQ'];
    if ($p == '') $p = $data['MISC_RULE'];
    if ($q == '') $q = $data['CLAN_LEADER'];
    if ($r == '') $r = $data['CLAN_LEADERDESC'];
    if ($s == '') $s = $data['CLAN_SECONDINCOMMAND'];
    if ($t == '') $t = $data['CLAN_SECONDINDESC'];
    if ($u == '') $u = $data['CLAN_COLEADERS'];

    $link = dbConnect();
    $qry = "UPDATE MAG_TEMP SET TOP_FIRST='$b', TOP_FIRSTDONATIONS='$c', TOP_SECOND='$d', TOP_SDON='$e', TOP_THIRD='$f', TOP_TDON='$g', TOP_BESTDON='$h', TOP_BDON='$i',
 TOP_BESTCLANDON='$j', PURGE_MEMREQ='$k', PURGE_ELDREQ='$l', PURGE_COREQ='$m', ELDER_REQ='$n',
  CO_REQ='$o', MISC_RULE='$p', CLAN_LEADER='$q', CLAN_LEADERDESC='$r', CLAN_SECONDINCOMMAND='$s', CLAN_SECONDINDESC='$t', CLAN_COLEADERS='$u'
            WHERE ACC_EMAIL='$email'";

    if($result = mysqli_query($link,$qry)) {

        $link->close();
        return true;

    }else {    // Query Failed - Error Messages Not shown !!!!
        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
    }
}

function getFname($id){
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "SELECT PER_FNAME FROM MAG_PERSON WHERE ACC_ID= '$id'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $res = mysqli_fetch_assoc($result);
        $link->close();
        return $res['PER_FNAME'];
    }
}

function getClanTag($email) {


//      *** Establish a connection to the database  ***
        $link = dbConnect();
//      *** Database Query **
        $qry = "SELECT CLAN_TAG FROM MAG_TEMP WHERE ACC_EMAIL= '$email'";
        if($result = mysqli_query($link,$qry)) {       // Implement query
            $res = mysqli_fetch_assoc($result);
            $link->close();
            return $res['CLAN_TAG'];
        }

}

function getChangedPWord($email) {

    fixSql($email);
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "SELECT ACC_CHANGEDPWORD FROM MAG_ACCOUNT WHERE ACC_EMAIL= '$email'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $res = mysqli_fetch_assoc($result);
        $link->close();
        return $res['ACC_CHANGEDPWORD'];
    }
}
function setChangedPWord($email, $value) {
    fixSql($email);
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "UPDATE MAG_ACCOUNT SET ACC_CHANGEDPWORD= '$value' WHERE ACC_EMAIL= '$email'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $link->close();
        return true;
    }else return false;
}

function setUserName($id, $userName){
    fixSql($userName);
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "UPDATE MAG_PERSON SET PER_CNAME= '$userName' WHERE ACC_ID= '$id'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $link->close();
        setClanLeader($id, $userName);
        return true;
    }else return false;
}
function setClanLeader($id, $leaderName) {
    fixSql($leaderName);
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "UPDATE MAG_TEMP SET CLAN_LEADER= '$leaderName' WHERE ACC_ID= '$id'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $link->close();
        return true;
    }else return false;
}
function setClanName($id, $clanName) {
    fixSql($clanName);
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "UPDATE MAG_TEMP SET CLAN_NAME= '$clanName' WHERE ACC_ID= '$id'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $link->close();
        return true;
    }else return false;

}
function setAccNotNew($id) {
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "UPDATE MAG_ACCOUNT SET ACC_NEW= 'false' WHERE ACC_ID= '$id'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        $link->close();
        return true;
    }else return false;
}

function head()
{
    echo <<< HTML

<html lang="en">
<head>
    <title>Clan Pages</title>
    <meta name="author" content="Michael Gardner" />
    <meta name="owner" content="intellabuzz" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="290359817712-t9oua6eg7028bnqgs03am9o84u2os6iv.apps.googleusercontent.com">

    <!--  ** Menu  ** -->
    <script src="java/jquery.js" type="text/javascript"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="java/Alpha.js" type="text/javascript"></script>
    <script src="java/Alpha.js" type="text/javascript"></script>
    <meta charset="UTF-8" />
    <!--  ** CSS  ** -->
    <link type="text/css" href="css/styles.css" rel="stylesheet" />
    <link type="text/css" href="css/nav.css" rel="stylesheet" />

    <!--  ** Java ** -->

</head>
<body>

    <img id="logo" name="logo" src="img/clanPages.png" alt="Clan Pages" />
        <span id="clanName">Clan Pages</span>   <!-- FIX THIS CLAN NAME Variable-->
    <header>
    </header>
HTML;
}



/** Function:   addAcct    ***
 * Last Modified:   23 November 2016
 * @param           $email -   Email address  40 characters long
 * @param $id
 * @param $img
 * @param           $fName -   First Name  20 characters long
 * @param           $lName -   Last Name   20 characters long
 * @return bool -   Returns True if the new user is successfully entered into the database.
 * Description:     This is used to add a new account to the database.
 * @internal param $pw -   Password    md5 Encrypted password      Always 32 characters long
 * @internal param $userName -   User Name   30 characters long
 * @internal param $clanName -   Clan Name   45 characters long
 */

function createAccount($email, $id, $img, $fName, $lName)
{
//      ** Check input for database exploits **
    fixSql($email);        fixSql($fName);
    fixSql($lName);

//      *** Establish a connection to the database  ***
        $link = dbConnect();
//      *** Database Query's  ***
        $qry = "INSERT INTO MAG_ACCOUNT (ACC_EMAIL, ACC_ID, ACC_IMG) VALUES ('$email', '$id', '$img')";
        $qry2 = "INSERT INTO MAG_PERSON (ACC_EMAIL, ACC_ID, PER_FNAME, PER_LNAME) VALUES ('$email','$id','$fName','$lName')";
        $qry3 = "INSERT INTO MAG_TEMP (ACC_ID, ACC_EMAIL) VALUES ('$id','$email')";
//      *** Implement Query's   ***
        if(mysqli_query($link, $qry)) {
        }    else {     // Query Failed - Error Messages Not shown !!!!
        echo "Error: " . $qry . "<br>" . mysqli_error($link);
    $link->close();
    return false;
}
        mysqli_query($link, $qry2);
        mysqli_query($link, $qry3);
//      ***     Close Connection    ***
        $link->close();
        return true;

}
function isAccNew($id) {
//      *** Establish a connection to the database  ***
    $link = dbConnect();
//      *** Database Query **
    $qry = "SELECT ACC_NEW FROM MAG_ACCOUNT WHERE ACC_ID= '$id'";
    if($result = mysqli_query($link,$qry)) {       // Implement query
        if (mysqli_num_rows($result) >= 1) {       // If there is 1 or more clans with the name entered return all the clans with that name
            $link->close();
            $newAccount = $result['ACC_NEW'];
            if ($newAccount == 'A') {
                return true;
            }
            return false;
        }
    }else {     // Query Failed - Error Messages Not shown !!!!
//        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
    }
}

function reDir($location) {
    header("Location: $location");
}







/** Function:       sendNewPass()
 * Last Modified:   25 November 2016
 * @param           $email  -   (40 characters MAX)
 * @return          bool|string
 * Description:     Used to get all the data for a clan by searching for the clans CLAN_TAG in the database.
 */
function sendNewPass($email)
{
    if ($email != 'Not Valid') {
        if (isAvailable($email)) {           // If isAvailable returns true then someone has the email.
            $pass = random_string(8);       // Generate a random password
            if (sendEmail($email, $pass, getFname($email), getUsername($email))) {
                change_password($pass, $email);
                return true;
            }
        }else  return false;
    } else return false;
}



function sendEmail($email, $password, $fName, $userName)
{
    require 'PHPMailer/PHPMailer-master/PHPMailerAutoload.php';

    $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                                         // Enable verbose debug output

    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                             // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
    $mail->Username = 'intellabuzz@gmail.com';                  // SMTP username
    $mail->Password = 'Ghy65rtp$2000';                          // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                          // TCP port to connect to

    $mail->setFrom('intellabuzz@gmail.com');
    $mail->addAddress("$email", "$userName");                   // Add a recipient

    $mail->isHTML(true);                                        // Set email format to HTML

    $mail->Subject = 'Password Reset';
    $mail->Body = "Hello $fName, <br> Your password has been reset! Your new password is: $password";
    $mail->AltBody = "Hello, $fName Your password has been reset! Your new password is: $password";

    if (!$mail->send()) {
        return false;
  //      echo 'Message could not be sent.';
 //       echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return true;
      //  echo 'Message has been sent';
    }
}









/** Function:       random_string
 * Last Modified:   26 November 2016
 * @param           $length
 * @param           string $characters
 * @return          string
 * @throws          Exception
 * Description:     Used to get all the data for a clan by searching for the clans CLAN_TAG in the database.
 */
function random_string(
    $length,
    $characters = '0123456789!@#$%^&*abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
) {
    $string = '';
    $max = mb_strlen($characters, '8bit') -1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $string .= $characters[random_int(0, $max)];
    }
    return $string;
}  // End random_string!


















/** Function:       change_password()
 * Last Modified:   2 November 2016
 * @param           $pass   -   Password    md5 Encrypted password      Always 32 characters long
 * @param           $email  -   Email Address   (40 characters MAX)
 * @return          bool
 * Description:     Used to get all the data for a clan by searching for the clans CLAN_TAG in the database.
 *
 */
function change_password($pass  , $email) {

//      ***  Encrypt Password  **
    $pass = md5($pass);

//      ** Establish a connection to the database **
    $link = dbConnect();

//      ** Database Query **
    $qry = "UPDATE MAG_ACCOUNT SET ACC_PASS = '$pass' WHERE ACC_EMAIL = '$email'";

//      ** Implement the Query
    if($result = mysqli_query($link,$qry)) {
        $link->close();
        return true;            // True - Password was changed and an Email was sent.
    }else {    // Query Failed - Error Messages Not shown !!!!
//        echo "Error: " . $qry . "<br>" . mysqli_error($link);
        $link->close();
        return false;
    }

}

function deleteAccount($email) {
//      ** Establish a connection to the database **
    $link = dbConnect();

//      *** Database Query's  ***

    $qry = "DELETE FROM  MAG_ACCOUNT WHERE ACC_EMAIL = '$email'";
    $qry2 = "DELETE FROM  MAG_PERSON WHERE ACC_EMAIL = '$email'";
    $qry3 = "DELETE FROM  MAG_TEMP WHERE ACC_EMAIL = '$email'";


//      *** Implement Query's   ***

    mysqli_query($link, $qry3);
    mysqli_query($link, $qry2);
    mysqli_query($link, $qry);

//      ***     Close Connection    ***
    $link->close();


}

/*******************************
 ***  End Of Functions List  ***
 *******************************/