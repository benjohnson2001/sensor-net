<?php

//require user configuration and database connection parameters

// start of user configuration

//Define MySQL database parameters

$username = "root";
$password = "!here!I!go!!AGAIN!";
$hostname = "127.0.0.1";
$database = "userlogin";

//Define your canonical domain including trailing slash!, example:
$domain= "http://192.168.1.107/";

//Define sending email notification to webmaster

$email='youremail@example.com';
$subject='New user registration notification';
$from='From: www.example.com';

//Define Recaptcha parameters
$privatekey ="6Lfk5NgSAAAAANN2qFcBcg572Nhd9pgFJq8C0N9p";
$publickey = "6Lfk5NgSAAAAABC-xf9kXbXKQvxlZltbVNh6H1BK";

//Define length of salt,minimum=10, maximum=35
$length_salt=15;

//Define the maximum number of failed attempts to ban brute force attackers
//minimum is 5
$maxfailedattempt=200;

//Define session timeout in seconds
//minimum 60 (for one minute)
$sessiontimeout=600;

// end of user configuration


$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle)
or die("Could not select $database");
$loginpage_url= $domain.'index.php';
$forbidden_url= $domain.'403forbidden.php';
?>
