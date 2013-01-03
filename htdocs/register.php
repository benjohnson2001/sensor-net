<?php

	//require user configuration and database connection parameters
	require('config.php');

	//pre-define validation parameters

	$usernamenotempty=TRUE;
	$usernamevalidate=TRUE;
	$usernamenotduplicate=TRUE;
	$passwordnotempty=TRUE;
	$passwordmatch=TRUE;
	$passwordvalidate=TRUE;
	$captchavalidation= TRUE;

	//Check if user submitted the desired password and username
	if ((isset($_POST["desired_password"])) && (isset($_POST["desired_username"])) && (isset($_POST["desired_password1"])))  {
		
	//Username and Password has been submitted by the user
	//Receive and validate the submitted information

	//sanitize user inputs

	function sanitize($data){
	$data=trim($data);
	$data=htmlspecialchars($data);
	$data=mysql_real_escape_string($data);
	return $data;
	}

	$desired_username=sanitize($_POST["desired_username"]);
	$desired_password=sanitize($_POST["desired_password"]);
	$desired_password1=sanitize($_POST["desired_password1"]);

	//validate username

	if (empty($desired_username)) {
	$usernamenotempty=FALSE;
	} else {
	$usernamenotempty=TRUE;
	}

	if ((!(ctype_alnum($desired_username))) || ((strlen($desired_username)) >11)) {
	$usernamevalidate=FALSE;
	} else {
	$usernamevalidate=TRUE;
	}

	if (!($fetch = mysql_fetch_array( mysql_query("SELECT `username` FROM `authentication` WHERE `username`='$desired_username'")))) {
	//no records for this user in the MySQL database
	$usernamenotduplicate=TRUE;
	}
	else {
	$usernamenotduplicate=FALSE;
	}

	//validate password

	if (empty($desired_password)) {
	$passwordnotempty=FALSE;
	} else {
	$passwordnotempty=TRUE;
	}

	if ((strlen($desired_password)) < 6) {
	$passwordvalidate=FALSE;
	} else {
	$passwordvalidate=TRUE;
	}

	if ($desired_password==$desired_password1) {
	$passwordmatch=TRUE;
	} else {
	$passwordmatch=FALSE;
	}

	//Validate recaptcha
	require_once('recaptchalib.php');
	$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) 
	{
		$captchavalidation=FALSE;
	} 
	else 
	{
		$captchavalidation=TRUE;	
	}

	if 	(($usernamenotempty==TRUE) && ($usernamevalidate==TRUE) && 
		($usernamenotduplicate==TRUE) && ($passwordnotempty==TRUE) && 
		($passwordmatch==TRUE) && ($passwordvalidate==TRUE) && ($captchavalidation==TRUE)) 
	{
		//The username, password and recaptcha validation succeeds.


		// This is a secure hashing algorithm using sha256 and a highly randomized salt
		// credits: http://crackstation.net/hashing-security.html		
		function HashPassword($input)
		{
			$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)); 
			$hash = hash("sha256", $salt . $input); 
			$final = $salt . $hash; 
			return $final;
		}

			$hashedpassword= HashPassword($desired_password);

			//Insert username and the hashed password to MySQL database

			mysql_query("INSERT INTO `authentication` (`username`, `password`) VALUES ('$desired_username', '$hashedpassword')") or die(mysql_error());
			//Send notification to webmaster
			$message = "New member has just registered: $desired_username";
			mail($email, $subject, $message, $from);
			//redirect to login page
			header(sprintf("Location: %s", $loginpage_url));	
			exit;
	}



}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Register as a Valid User</title>
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
			text-align: left;
			font-family: monospace, tahoma, arial, sans-serif;
			font-size: 10pt;
			
		.left_content 
		{ 
			float: left;
			text-align: justify;
			width: 444px;
			padding: 20px 0 5px 25px;
			margin: 0;
		}	
			
		}	
</style>
</head>
<body >
<h2>Register for access!</h2>
<br />
The interesting content on this website is restricted, but there is limited access for guests to view a subset of data streaming in real-time.
<br /><br />
Please register to view the content, no special characters please.
<br /><br />

<!-- Start of registration form -->

<div class="left_content">

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">

Username: <input type="text" 
class="<?php if (($usernamenotempty==FALSE) || ($usernamevalidate==FALSE) || ($usernamenotduplicate==FALSE))  echo "invalid"; ?> " 
id="desired_username" name="desired_username"><br /><br />

Password: <input name="desired_password" type="password" 
class="<?php if (($passwordnotempty==FALSE) || ($passwordmatch==FALSE) || ($passwordvalidate==FALSE)) echo "invalid"; ?>" 
id="desired_password" ><br /><br />

Password again: <input name="desired_password1" type="password" class="<?php if (($passwordnotempty==FALSE) || ($passwordmatch==FALSE) || ($passwordvalidate==FALSE)) echo "invalid"; ?>" id="desired_password1" ><br />
<br /><br />
Enter captcha: <br /> <br />


<?php
require_once('recaptchalib.php');
echo recaptcha_get_html($publickey);
?>

<br /><br />
<input type="submit" value="Register">

<a href="index.php"><br /><br />back</a><br /><br />

<!-- Display validation errors -->
<?php if ($captchavalidation==FALSE) echo '<font color="red">bad captcha!</font><br />'; ?>
<?php if ($usernamenotempty==FALSE) echo '<font color="red">empty username!</font><br />'; ?>
<?php if ($usernamevalidate==FALSE) echo '<font color="red">username not alphanumeric or too big!</font><br />'; ?>
<?php if ($usernamenotduplicate==FALSE) echo '<font color="red">username already exists!<br /></font>'; ?>
<?php if ($passwordnotempty==FALSE) echo '<font color="red">empty password!</font><br />'; ?>
<?php if ($passwordmatch==FALSE) echo '<font color="red">bad password!</font><br />'; ?>
<?php if ($passwordvalidate==FALSE) echo '<font color="red">password must be greater than 6 characters!</font><br />'; ?>
<?php if ($captchavalidation==FALSE) echo '<font color="red">bad captcha!</font><br />'; ?>

</form>

</div>
<!-- End of registration form -->

</body>
</html>
