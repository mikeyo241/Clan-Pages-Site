<?php
/**
 * Created by PhpStorm.
 * User: mikey
 * Date: 12/2/2016
 * Time: 11:02 PM
 *//* 	Programmer: 		Michael A Gardner
 * 	Class:				CPT - 283-001
 *	Date:				12/2/2016
 *	Document: 			
 */
 $displayResults = 'none';
$msg = '';
require('functionsLibrary.php');        // Functions Library

if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (!empty($_POST['findSubmit'])) {

        $fCT = fixSql($_POST['clanNameInput']);
        $searchResult = checkPage($fCT);
        if (strlen($fCT) < 1) {
            $msg = 'Clan Tag Required';
        } else if ($searchResult == false) {
            $displayResults = 'none';
            $clansFound[0] = 'There are no clans with that name.';
        } else {
            if ($searchResult->num_rows > 0) {
                $displayResults = 'block';
                $i = 0;
                while ($row = $searchResult->fetch_assoc()) {
                    $clanTag = $row['CLAN_TAG'];
                    $clanName = $row['CLAN_NAME'];
                    $clanLeader = $row['CLAN_LEADER'];
                    $clansFound[$i] = "<input type='radio' name='clanSelected' value='$clanTag' required >Clan Name: $clanName <br>Clan Leader: $clanLeader <br> ";
                    $i++;
                }
            } else {
                $displayResults = 'none';
                $clansFound[0] = 'There are no clans with that name.';
            }
        }
    }
}

echo <<< HTML
<html lang="en">
<head>
    <title>Search For a Clan</title>
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
        <li><a href="index.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="index.php">don't</a></li>
     
        
    </ul>
</div>



    <img id="logo" name="logo" src="img/clanPages.png" alt="Clan Pages Logo" />
    <span id="clanName">Clan Pages</span>   <!-- FIX THIS CLAN NAME Variable-->
    <header>
    </header>

<div id="clanPagesSmall" name="clanPagesSmall" style="margin-top: 150px">
        <p style="color: red">$msg</p>
        <p>Search for an existing clan</p>
             <form method="post" action="$PHP_SELF");">
                <input type="text" id="clanNameInput" name="clanNameInput" placeholder=" Clan Name" maxlength="20" required>
                <br>
                <input type="submit" id = "findSubmit" name="findSubmit" value="Search">
            </form>
            <form id="smallResults" method="post" action="$PHP_SELF" >
HTML;
if(isset($clansFound)) {
    foreach ($clansFound as $value) {
        echo $value;
    }
}
echo <<< HTML
            <input style="display: $displayResults;" type="submit" id = "chosenClan" name="chosenClan" value="Visit Clan Page" style="background-color: #52627b; color: #99cccc; font-weight: bold;">
        </form>
        </div>
</body>
</html>
HTML;


