<?php
/**
 * Created by PhpStorm.
 * User: mikey
 * Date: 12/5/2016
 * Time: 7:54 PM
 *//* 	Programmer: 		Michael A Gardner
 * 	Class:				CPT - 283-001
 *	Date:				12/5/2016
 *	Document: 			
 */
session_start();

require('functionsLibrary.php');        // Functions Library
$id = $_POST['idtoken'];
$fName = $_POST['fname'];
$lName = $_POST['lName'];
$img = $_POST['img'];
$email = $_POST['email'];

$_SESSION['id'] = $id;
$_SESSION['fName'] = $fName;
$_SESSION['lName'] = $lName;
$_SESSION['img'] = $img;
$_SESSION['email'] = $email;

if(checkLogin($id)){
    echo 'Account Exists';
    $_SESSION['isLogin'] == '22Qr';
}else if (createAccount($email,$id,$img,$fName,$lName)) {
    echo 'Account Created';
    $_SESSION['isLogin'] == '22Qr';
}else {
    echo 'Unknown Account Error Occurred';
}

