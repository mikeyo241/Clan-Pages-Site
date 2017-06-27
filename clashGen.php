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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />

<!-- **** Latest compiled Bootstrap CSS ****                                                                -->
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
<!--      ****      CSS         ****                                                                        -->
  
  <style>
    @font-face{
      font-family: clash;
      src: url(css/clash.ttf);
    }
    h1{
      font-family: clash, sans-serif;
    }
  </style>
<!--        *******     END CSS       *********                                                             -->

<!--          *****          JavaScript        ********                                                     -->
    <script src="java/Alpha.js" type="text/javascript"></script>

</head>


<body>
<!-- <img id="clashLogo" name="clashLogo" src="img/clanPages.png" alt="Custom Clan Pages" style="width: 4em;
    position: fixed;
    left: 47%;
    z-index: 1050;
    top: 4px;"/>     -->
  <nav class="navbar navbar-inverse navbar-fixed-top">

    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>

        <a class="navbar-brand" href="index.php" style="font-family: clash" >$clanName </a>
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

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-4"  id="leaderboard">
      <div class="well">
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
    </div>
    
    <div class="col-sm-4"  id="events" >
      <div class="well">
        <h1>Upcoming Events</h1>
        <h3>Biweekly Clan Purge</h3>
        <ul>
            <li id="purgeDate"></li>

            <li>Members with less than $purgeMemberReq donations will be kicked</li>

            <li>Elders with Less than $purgeElderReq donations will be demoted</li>

            <li>Co-Leaders with less than $purgeCoLeaderReq donations will be demoted</li>
        </ul>
      </div>    <!--  **  END DIV WELL  **          -->
    </div>    <!--   ** END DIV COL-SM-4 **       -->
  </div>   <!--   ****  END DIV ROW   ******  -->

<!--________________________________________________________-->

  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-4" id="clanguide" >
      <div class="well">
        <h1>Clan Guide</h1>
        <h2>Elder Requirements</h2>
        <ul>
            <li>$elderReq</li>
        </ul>
        <h2>Want to become a Co-Leader?</h2>
        <ul>
            <li>$coLeaderReq</li>
        </ul>
        <h2>Misc.</h2>
        <ul>
            <li>$miscRule</li>
        </ul>

      </div>
    </div>

    <div class="col-sm-4" id="ourClan">
      <div class="well">
        <h1>Clan Leader</h1>
        <h2>$clanLeader</h2>
        <p>$clanLeaderDesc</p>

        <h1>Second in command</h1>
        <h2>$secondInCommand</h2>
        <p>$secondInCommandDesc</p>

        <h1>Co-Leaders</h1>
        <p>$coLeaders</p>

      </div>  <!-- ** END WELL  ** -->
    </div>  <!--  ** END COLUMN SIZE 4  -->



</div>  <!--  **  END CONTAINER **                                           -->

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled BOOTSTRAP JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
HTML;
