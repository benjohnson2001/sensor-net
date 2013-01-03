<?php

require('config.php');

session_start(); 

ini_set('session.use_only_cookies',1);

if (($_SESSION['logged_in'])==TRUE) 
{
	
	// check for unauthorized use of user sessions
	$iprecreate= $_SERVER['REMOTE_ADDR'];
	$useragentrecreate=$_SERVER["HTTP_USER_AGENT"];
	$signaturerecreate=$_SESSION['signature'];


	// extract original salt from authorized signature
	$saltrecreate = substr($signaturerecreate, 0, $length_salt);

	// extract original hash from authorized signature
	$originalhash = substr($signaturerecreate, $length_salt, 40);


	// re-create the hash based on the user IP and user agent
	$hashrecreate= sha1($saltrecreate.$iprecreate.$useragentrecreate);

	// compare authorized hash with hash submitted by user
	if (!($hashrecreate==$originalhash)) 
	{

		//block unauthorized access
		header(sprintf("Location: %s", $forbidden_url));	
		exit;    
		
	}

	// enforce session timeouts
	if ((isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessiontimeout))) 
	{

	session_destroy();   
	session_unset();  

	//re-authenticate user
	$redirectback=$domain.'index.php';
	header(sprintf("Location: %s", $redirectback));
	exit();
	}
	
	$_SESSION['LAST_ACTIVITY'] = time(); 

}


$validationresults=TRUE;
$registered=TRUE;
$recaptchavalidation=TRUE;

// defend against brute force attacks by requiring CAPTCHA
$iptocheck= $_SERVER['REMOTE_ADDR'];
$iptocheck= mysql_real_escape_string($iptocheck);

// if there are IP address records logged in the database
// get the total failed login attempts associated with this IP address 
if ($fetch = mysql_fetch_array( mysql_query("SELECT `loggedip` FROM `ipcheck` WHERE `loggedip`='$iptocheck'"))) 
{
	$resultx = mysql_query("SELECT `failedattempts` FROM `ipcheck` WHERE `loggedip`='$iptocheck'");
	$rowx = mysql_fetch_array($resultx);
	$loginattempts_total = $rowx['failedattempts'];

	if ($loginattempts_total>$maxfailedattempt) 
	{	
		// too many failed attempts allowed, redirect and give 403 forbidden.
		header(sprintf("Location: %s", $forbidden_url));	
		exit;
	}
	
}

// check if a user has logged-in
if (!isset($_SESSION['logged_in'])) 
{
    $_SESSION['logged_in'] = FALSE;
}

// if username and password has been submitted by the user
if ((isset($_POST["pass"])) && (isset($_POST["user"])) && ($_SESSION['LAST_ACTIVITY']==FALSE)) 
{

	//sanitize the submitted information
	function sanitize($data){
	$data=trim($data);
	$data=htmlspecialchars($data);
	$data=mysql_real_escape_string($data);
	return $data;
	
}

$user=sanitize($_POST["user"]);
$_SESSION['user_name'] = $user;
$pass= sanitize($_POST["pass"]);

// if user is not yet registered
if (!($fetch = mysql_fetch_array( mysql_query("SELECT `username` FROM `authentication` WHERE `username`='$user'")))) 
{
	$registered=FALSE;
}

if ($registered==TRUE) 
{

	// check MySQL database for a corresponding username
	$result1 = mysql_query("SELECT `loginattempt` FROM `authentication` WHERE `username`='$user'");
	$row = mysql_fetch_array($result1);
	$loginattempts_username = $row['loginattempt'];

}

if(($loginattempts_username>2) || ($registered==FALSE) || ($loginattempts_total>2)) 
{

	//require CAPTCHA to users with failed login attempts
	require_once('recaptchalib.php');
	$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) 
	{
		$recaptchavalidation=FALSE;
	} 
	else 
	{
		$recaptchavalidation=TRUE;	
	}
	
}

// get correct hashed password based on given username stored in MySQL database

if ($registered==TRUE) 
{	
	$result = mysql_query("SELECT `password` FROM `authentication` WHERE `username`='$user'");
	$row = mysql_fetch_array($result);
	$correctpassword = $row['password'];
	$salt = substr($correctpassword, 0, 64);
	$correcthash = substr($correctpassword, 64, 64);
	$userhash = hash("sha256", $salt . $pass);
}


if ((!($userhash == $correcthash)) || ($registered==FALSE) || ($recaptchavalidation==FALSE)) 
{

	//user login validation fails

	$validationresults=FALSE;

	//log login failed attempts to database

	if ($registered==TRUE) 
	{
		$loginattempts_username= $loginattempts_username + 1;
		$loginattempts_username=intval($loginattempts_username);

		//update login attempt records

		mysql_query("UPDATE `authentication` SET `loginattempt` = '$loginattempts_username' WHERE `username` = '$user'");

		//Possible brute force attacker is targeting registered usernames
		//check if has some IP address records

		if (!($fetch = mysql_fetch_array( mysql_query("SELECT `loggedip` FROM `ipcheck` WHERE `loggedip`='$iptocheck'")))) 
		{
				
			// no records, insert failed attempts
			$loginattempts_total=1;
			$loginattempts_total=intval($loginattempts_total);
			mysql_query("INSERT INTO `ipcheck` (`loggedip`, `failedattempts`) VALUES ('$iptocheck', '$loginattempts_total')");	
			
		} 
		else 
		{
			// records exist, increment attempts
			$loginattempts_total= $loginattempts_total + 1;
			mysql_query("UPDATE `ipcheck` SET `failedattempts` = '$loginattempts_total' WHERE `loggedip` = '$iptocheck'");
		}
	}



	if ($registered==FALSE) 
	{

		if (!($fetch = mysql_fetch_array( mysql_query("SELECT `loggedip` FROM `ipcheck` WHERE `loggedip`='$iptocheck'")))) 
		{		
			//no records
			//insert failed attempts
			$loginattempts_total=1;
			$loginattempts_total=intval($loginattempts_total);
			mysql_query("INSERT INTO `ipcheck` (`loggedip`, `failedattempts`) VALUES ('$iptocheck', '$loginattempts_total')");	
		} 
		else 
		{
			//has some records, increment attempts
			$loginattempts_total= $loginattempts_total + 1;
			mysql_query("UPDATE `ipcheck` SET `failedattempts` = '$loginattempts_total' WHERE `loggedip` = '$iptocheck'");
		}
	}

} 
else 
{
		
	// user successfully authenticates with the provided username and password

	// reset login attempts for a specific username to 0
	// reset ip address
	$loginattempts_username=0;
	$loginattempts_total=0;
	$loginattempts_username=intval($loginattempts_username);
	$loginattempts_total=intval($loginattempts_total);
	mysql_query("UPDATE `authentication` SET `loginattempt` = '$loginattempts_username' WHERE `username` = '$user'");
	mysql_query("UPDATE `ipcheck` SET `failedattempts` = '$loginattempts_total' WHERE `loggedip` = '$iptocheck'");

	// generate unique signature of the user based on IP address and the browser 
	// append this to the session to authenticate the user 

	//generate random salt
	//credits: http://bit.ly/a9rDYd	
	function genRandomString() 
	{
		$length = 50;
		$characters = "0123456789abcdef";
		      
		for ($p = 0; $p < $length ; $p++) 
		{
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		
		return $string;
	}
	
	$random=genRandomString();
	$salt_ip= substr($random, 0, $length_salt);

	//hash the ip address, user-agent and the salt
	$useragent=$_SERVER["HTTP_USER_AGENT"];
	$hash_user= sha1($salt_ip.$iptocheck.$useragent);

	//concatenate the salt and the hash to form a signature
	$signature= $salt_ip.$hash_user;

	// regenerate session id prior to setting any session variable
	// this will mitigate session fixation attacks

	session_regenerate_id();

		// store user unique signature in the session and set 
		// logged_in to TRUE as well as start activity time		
		
		$_SESSION['signature'] = $signature;
		$_SESSION['logged_in'] = TRUE;
		$_SESSION['LAST_ACTIVITY'] = time(); 
		$_SESSION['refresh_ct'] = 0;



}

} 


if (!$_SESSION['logged_in']): 

?>


	<!DOCTYPE HTML>
	<html>
	<head>
	<title>Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<style type="text/css">
	
		.invalid 
		{
			border: 1px solid #000000;
			background: #FF00FF;
		}
		
		body 
		{
			background-color: #000000;
			color: #eeeeee;
			text-align: center;
			font-family: monospace, tahoma, arial, sans-serif;
			font-size: 11pt;
		}	
		
		.container 
		{
			width: 300px;
			clear: both;
		}
		
		.container input 
		{
			width: 50%;
			clear: both;
		}
		
		.left_content 
		{ 
			float: left;
			text-align: justify;
			width: 444px;
			padding: 0px 0 5px 25px;
			margin: 0;
		}
		
		.center_content 
		{ 
			display: block;
			margin-left:auto;
		}					
		
		.right_content 
		{ 
			float: left;
			text-align: justify;
			width: 444px;
			padding: 20px 0 5px 25px;
			margin: 0;
		}						
		
	</style>
	</head>
	
	<body >
	


	
	<img src="system_diagram.png"></img><br />
	
	<!-- START OF LOGIN FORM -->	
	<div class="left_content">
	
	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

	Username:  <input type="text" class="<?php if ($validationresults==FALSE) echo "invalid"; ?>" id="user" name="user"><br />
	Password:  <input name="pass" type="password" class="<?php if ($validationresults==FALSE) echo "invalid"; ?>" id="pass" ><br />

	
	<?php if (($loginattempts_username > 2) || ($registered==FALSE) || ($loginattempts_total>2)) { ?>
	Type the captcha below:
	<br /> <br />
	
	<?php
	require_once('recaptchalib.php');
	echo recaptcha_get_html($publickey);
	?>
	<br />
	
	<?php } ?>

	<?php if ($validationresults==FALSE) echo '<font color="red">Enter your username and password.</font>'; ?>
	<div class="center_content">
	<input type="submit" value="Login">                   
	</div>
	</form>
	<!-- END OF LOGIN FORM -->
	</div>
	<br />
	<a href="register.php">register</a> for a guest account
	</body>
	</html>
	
	<?php
	exit();
	endif;
	?>
