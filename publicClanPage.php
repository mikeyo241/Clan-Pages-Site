<?php
/******************************************************
 ***         Public Clan Page Generator             ***
 ***                                                ***
 ***    Created by:         Michael A Gardner       ***
 ***    Updated:            26 September 2016       ***
 ***    Class:              CPT - 283-001           ***
 ***    Document:           clashGen.php            ***
 ***    CSS:                styles.css, nav.css     ***
 ***    jQuery:             jQuery.js, Alpha.js     ***
 ***                                                ***
 ******************************************************/






session_start();
require('functionsLibrary.php');
if ($_SESSION['isLogin'] != '22Qr' && !isset($_SESSION['email'])) {   // Check to see If the user is logged on.  (isLogin must be set to 22Qr to be stay on this page!)
    session_destroy();
    header('Location: index.php');
}
if (!isset($_SESSION['TAG'])) {   // Check to see If TAG Variable is set if not send the user back to the homepage.
    session_destroy();
    header('Location: index.php');
}

//    ***  Variables  ***
$clanTag = $_SESSION['TAG'];                // Get the Clan Tag number from the Session variable.
$data= getData($clanTag);                   // Get the clan data from mySql
$clanName = $data['CLAN_NAME'];

//   **  Top 3 Donors Section  ***
$first = $data['TOP_FIRST'];
$firstDonations = $data['TOP_FIRSTDONATIONS'];
$second = $data['TOP_SECOND'];
$secondDonations = $data['TOP_SDON'];
$third = $data['TOP_THIRD'];
$thirdDonations = $data['TOP_TDON'];

//  ***  Top Clan Records  ***
$topDonationsMem = $data['TOP_BESTDON'];
$topDonations = $data['TOP_BDON'];
$bestClanDonations = $data['TOP_BESTCLANDON'];

// *** Clan Guide Section ***
$purgeMemberReq = $data['PURGE_MEMREQ'];
$purgeElderReq = $data['PURGE_ELDREQ'];
$purgeCoLeaderReq = $data['PURGE_COREQ'];
$elderReq = nl2br($data['ELDER_REQ']);
$coLeaderReq = nl2br($data['CO_REQ']);
$miscRule = nl2br($data['MISC_RULE']);

// *** Clan Leaders Section  ***
$clanLeader = $data['CLAN_LEADER'];
$clanLeaderDesc = nl2br($data['CLAN_LEADERDESC']);
$secondInCommand = $data['CLAN_SECONDINCOMMAND'];
$secondInCommandDesc = nl2br($data['CLAN_SECONDINDESC']);
$coLeaders = nl2br($data['CLAN_COLEADERS']);



echo <<< HTML

<head>
    <title>$clanName</title>
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
    <link type="text/css" href="css/publicClanPage.css" rel="stylesheet" />
    <!--  ** Java ** -->
    <script src="java/Alpha.js" type="text/javascript"></script>

</head>


<body style="text-align: left;">
<span class="menu-trigger"><img id="menuButton" name="menuButton" src="img/3squaresWhite.png"/> </span>
<div class="nav-menu">
    <ul class="clearfix">
        <li><a href="profile.php">Profile</a></li>
        <li><a href="search.php">Search</a></li>
    </ul>
</div>



    <img id="logo" name="logo" src="img/clanPages.png" alt="Clan Pages Logo" />
    <span id="clanName">$clanName</span>   <!-- FIX THIS CLAN NAME Variable-->
    <header>
    </header>

<section>

    <div id="leaderboard" style="margin-top: 65px">
        <h1 id="top5" style="text-align: center">Top 3 Donors</h1>
        <table style="width: 100%; font-size: 1.3em; text-align: center;">
            <tr>
                <td>1st  </td>
                <td>$first</td>
                <td>$firstDonations</td>
            </tr>
            <tr>
                <td>2nd  </td>
                <td>$second</td>
                <td>$secondDonations</td>
            </tr>
            <tr>
                <td>3rd  </td>
                <td>$third</td>
                <td>$thirdDonations</td>
        </table>

        <h2 style="text-align: center">Records</h2>
        <dl>
            <dt>Most Donations in one week!</dt>
            <dd>$topDonationsMem  -> $topDonations </dd>  <!-- Member with the most donations and how many trophies they have!!  -->

            <dt>Best clan Donations</dt>
            <dd>$bestClanDonations</dd>
        </dl>



    </div>
    <div id="events" >
        <h1>Upcoming Events!</h1>
        <h3>Biweekly Clan Purge</h3>
        <ul>
            <li id="purgeDate"></li>

            <li>Anyone with less than $purgeMemberReq donations</li>

            <li>Elders with Less than $purgeElderReq donations</li>

            <li>Co-Leaders with less than $purgeCoLeaderReq donations</li>
        </ul>
    </div>

    <div id="clanguide" >

        <h1>Clan Guide</h1>
        <h2>Want to become an Elder?</h2>
        <ul>
            <li>$elderReq</li>
        </ul>
        <h2>Want to become a <br>Co-Leader?</h2>
        <ul>
            <li>$coLeaderReq</li>
        </ul>
        <h2>Misc.</h2>
        <ul>
            <li>$miscRule</li>
        </ul>


    </div>

    <div id="ourClan">
        <h1>Our Clan Leader!</h1>
        <h2>$clanLeader</h2>
        <p>$clanLeaderDesc</p>

        <h1>Second in command</h1>
        <h2>$secondInCommand</h2>
        <p>$secondInCommandDesc</p>

        <h1>Co-Leaders</h1>
        <p>$coLeaders</p>


    </div>



</section>

</body>
HTML;
