<?php
                /******************************************************
                 ***               Private Profile                  ***
                 ***                                                ***
                 ***    Created by:         Michael A Gardner       ***
                 ***    Updated:            26 September 2016       ***
                 ***    Class:              CPT - 283-001           ***
                 ***    Document:           profile.php             ***
                 ***    CSS:                styles.css, nav.css     ***
                 ***    jQuery:             jQuery.js, Alpha.js     ***
                 ***                                                ***
                 ******************************************************/





session_start();

require('functionsLibrary.php');        // Functions Library

if ($_SESSION['isLogin'] != '22Qr' && !isset($_SESSION['id'])) {   // Check to see If the user is logged on.  (isLogin must be set to 22Qr to be stay on this page!)
    session_destroy();
   header('Location: index.php');
}

//  ** Variables  **
$msg = '';                                  // Message area to let the user know if the page has been updated
$data = getDataProfile($_SESSION['email']);        // $data Holds all the data that the user inputs into the forms that is currently in mysql.
$accInfo = getAccNew($_SESSION['email']);   // This is used to get the account holders username data from mysql
$user = getUsername($_SESSION['email']);
$img = $_SESSION['img'];
//$_SESSION['email'] = getClanTag($_SESSION['email']);


if ($_SERVER['REQUEST_METHOD']=='POST') {
        if (update()) {                     // Update all the data in mysql to the data on the profile.
            $msg = "Update Successful";
            header('Refresh:0');            // The page needs to be refreshed to get the right data in the form input boxes.
        } else $msg = "Update Failed";

}


if(!empty($_POST['logout'])) {
    $_SESSION['isLogin'] = '00';
    $_SESSION['id'] = '';
    session_destroy();
    header('Location: index.php');
}
if(!empty($_POST['deleteAccount'])) {
    header('Location: deleteAccount.php');
}

?>


<html lang="en">
<head>
    <title> <?PHP echo $data['CLAN_NAME'];?></title>
    <meta name="author" content="Michael Gardner" />
    <meta name="owner" content="intellabuzz" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  ** Menu  ** -->
    <script src="java/jquery.js" type="text/javascript"></script>


    <meta charset="UTF-8" />
    <!--  ** CSS  ** -->
    <link type="text/css" href="css/styles.css" rel="stylesheet" />
    <link type="text/css" href="css/nav.css" rel="stylesheet" />

    <!--  ** Java ** -->
    <script src="java/Alpha.js" type="text/javascript"></script>


</head>


<body>

<form name="update" id="update" method="post" action="<?php echo $PHP_SELF; ?>");">
<span class="menu-trigger"><img id="menuButton" name="menuButton" src="<?php echo $img; ?>"/> </span>
<div class="nav-menu">
    <ul class="clearfix">
        <li><a href="publicClanPage.php">Public Page</a></li>
        <li><a href="search.php">Search</a></li>
        <li><input type="submit" name="submit" value="Update Clan Page"></li>
        <li><input type="submit" name="deleteAccount" value="Delete Account"</li>
        <li><button onclick="signOut();">Sign Out</button> </li>
    </ul>
</div>



    <img id="logo" name="logo" src="img/clanPages.png" alt="<?PHP echo $data['CLAN_NAME'];?>" />
    <span id="clanName"><?PHP echo $data['CLAN_NAME'];?></span>   <!-- FIX THIS CLAN NAME Variable-->
    <header>
    </header>



<section>
    <div id="welcome">
        <h3>Welcome <?php echo $user; ?></h3>
        <p>Enter data from your clan below to get started. When you are finished click the menu button then
        press the update button. View your live clan page by pressing Public Page.</p>
    </div>

    <div id="leaderboard">
        <h3 style="color: red;"><?php echo $msg; ?></h3>
        <h2 id="top5" style="text-align: center">Top 3 Donors</h2>
        1st Place<br>
        <input type="text" name="topFirst" maxlength="40" placeholder=" <?PHP echo $data['TOP_FIRST'];?>"><br>
        <input type="text" name="topFirstDon" maxlength="11" placeholder=" <?PHP echo $data['TOP_FIRSTDONATIONS'];?>"><br>

        2nd Place<br>
        <input type="text" name="topSecond" maxlength="40" placeholder=" <?PHP echo $data['TOP_SECOND'];?>"><br>
        <input type="text" name="topSDon" maxlength="11" placeholder=" <?PHP echo $data['TOP_SDON'];?>"><br>

        3rd Place<br>
        <input type="text" name="topThird" maxlength="40" placeholder=" <?PHP echo $data['TOP_THIRD'];?>"><br>
        <input type="text" name="topTDon" maxlength="11" placeholder=" <?PHP echo $data['TOP_TDON'];?>"><br>


        <h2 style="text-align: center">Records</h2>
        <dl>
            <dt>Most Donations</dt>
            <dd><input type="text" name="topBestDonor" maxlength="40" placeholder="<?php echo $data['TOP_BESTDON']?>"> --> <input type="text" name="topBDon" maxlength="11" placeholder=" <?php echo $data['TOP_BDON']?>"> </dd>  <!-- Member with the most donations and how many trophies they have!!  -->

            <dt>Best clan Donations</dt>
            <dd><input type="text" name="topBestClanDon" maxlength="11" placeholder=" <?PHP echo $data['TOP_BESTCLANDON'];?>"></dd>
        </dl>



      class HR_Controller extends Controller
      {
      //
      public function index() {
      $employees =  DB::table('employees')->get()->where('deleted', '==' , 0);
      return view('hrSystem', compact('employees'));
      }

      public function user_delete(){
      $id = Input::get('del_id');
      DB::table('HR_SYSTEM')
      ->where('id',$id)
      ->update(['deleted'=>1]);
      return redirect('datamanager');
      }
      }




      public function up()
      {
      //  Create a Database to store employee data
      Schema::create('employees', function ($employee) {
      $employee->increments('id');
      $employee->string('name');
      $employee->integer('age');
      $employee->string('sex', 4);
      $employee->string('office');
      $employee->timestamps();
      $employee->boolean('deleted')->default(0);
      $employee->boolean('is_supervisor')->default(0);
      $employee->integer('supervisor')->default(NULL);
      });

      }

      /**
      * Reverse the migrations.
      *
      * @return void
      */
      public function down()
      {
      // Drop table commands
      Schema::drop('employees');
      }
      }
    </div>
    <div id="events" >
        <h2>Upcoming Events!</h2>
        <h3>Biweekly Clan Purge</h3>
        <ul>
            <li id="purgeDate"></li>

            <li>Members with less than <input type="text" name="purgeMemReq" maxlength="11" placeholder=" <?PHP echo $data['PURGE_MEMREQ'];?>"> donations will be kicked</li>

            <li>Elders with Less than <input type="text" name="purgeEldReq" maxlength="11" placeholder="<?PHP echo $data['PURGE_ELDREQ'];?>"> donations will be demoted</li>

            <li>Co-Leaders with less than <input type="text" name="purgeCoReq" maxlength="11" placeholder=" <?PHP echo $data['PURGE_COREQ'];?> ">donations will be demoted</li>
        </ul>
    </div>

    <div id="clanguide" name="clanguide" >

        <h1>Clan Guide</h1>
        <h2>Want to become an Elder?</h2>
            <textarea rows="6" cols="40" name="elderReq" maxlength="2000" form="update"><?PHP echo $data['ELDER_REQ'];?></textarea>
        <h2>Want to become a Co-Leader?</h2>
            <textarea rows="15" cols="40" name="coReq" maxlength="2000" form="update"><?PHP echo $data['CO_REQ'];?></textarea>
        <h2>Misc.</h2>
            <textarea rows="15" cols="40" name="miscRule" maxlength="2000" form="update"><?PHP echo $data['MISC_RULE'];?></textarea>


    </div>

    <div id="ourClan">
        <h1>Our Clan Leader!</h1>
        <h2><input type="text" name="clanLeader" maxlength="40" placeholder="<?PHP echo $data['CLAN_LEADER'];?>"></h2>
        <textarea rows="15" cols="40" name="clanLeaderDesc" maxlength="2000" form="update"><?PHP echo $data['CLAN_LEADERDESC'];?></textarea>


        <h1>Second in command</h1>
        <h2><input type="text" name="secondInCommand" maxlength="40" placeholder=" <?PHP echo $data['CLAN_SECONDINCOMMAND'];?>"></h2>
        <textarea rows="15" cols="40" name="secondInDesc" maxlength="2000" form="update"><?PHP echo $data['CLAN_SECONDINDESC'];?></textarea>


        <h1>Co-Leaders</h1>
        <textarea rows="15" cols="40" name="clanColeaders" maxlength="2000" form="update"><?PHP echo $data['CLAN_COLEADERS'];?></textarea>




    </div>
   
</section>


</body>

</html>




