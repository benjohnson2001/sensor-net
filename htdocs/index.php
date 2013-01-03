<?php
require('authenticate.php');


$ini_1 = parse_ini_file("data_processing/sensor1.conf");
$ini_2 = parse_ini_file("data_processing/sensor2.conf");
$ini_3 = parse_ini_file("data_processing/sensor3.conf");
$ini_4 = parse_ini_file("data_processing/sensor4.conf");

// R1 Control
// --------------------------------------------------

	if  (isset($_POST['r1_datasub'])) 
	{
		


		$r1_datastream = $_POST['r1_datastream'];

		switch ($r1_datastream)
		{
			
		case "sine":	
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_1[STATE]\nWAVEFORM=sine\n";
							
			$fh1 = fopen("data_processing/sensor1.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "triangle":
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_1[STATE]\nWAVEFORM=triangle\n";
			
			$fh1 = fopen("data_processing/sensor1.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "square":
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_1[STATE]\nWAVEFORM=square\n";
			
			$fh1 = fopen("data_processing/sensor1.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
									
		}
		
		
	}
	
	
	if (isset($_POST['r1_stopsub']))
	{
	
			$string1 = "# SENSOR CONFIGURATION\nSTATE=0\nWAVEFORM=$ini_1[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor1.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	
	}
	
	if (isset($_POST['r1_startsub']))
	{
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=1\nWAVEFORM=$ini_1[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor1.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	}
	

// r2 Control
// --------------------------------------------------

	if  (isset($_POST['r2_datasub'])) 
	{

		$r2_datastream = $_POST['r2_datastream'];

		switch ($r2_datastream)
		{
			
		case "sine":	
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_2[STATE]\nWAVEFORM=sine\n";
							
			$fh1 = fopen("data_processing/sensor2.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "triangle":
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_2[STATE]\nWAVEFORM=triangle\n";
			
			$fh1 = fopen("data_processing/sensor2.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "square":
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_2[STATE]\nWAVEFORM=square\n";
			
			$fh1 = fopen("data_processing/sensor2.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
									
		}
		
		
	}
	
	
	if (isset($_POST['r2_stopsub']))
	{
	
			$string1 = "# SENSOR CONFIGURATION\nSTATE=0\nWAVEFORM=$ini_2[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor2.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	
	}
	
	if (isset($_POST['r2_startsub']))
	{
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=1\nWAVEFORM=$ini_2[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor2.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	}
	
// r3 Control
// --------------------------------------------------

	if  (isset($_POST['r3_datasub'])) 
	{

		$r3_datastream = $_POST['r3_datastream'];

		switch ($r3_datastream)
		{
			
		case "sine":	
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_3[STATE]\nWAVEFORM=sine\n";
							
			$fh1 = fopen("data_processing/sensor3.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "triangle":
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_3[STATE]\nWAVEFORM=triangle\n";
			
			$fh1 = fopen("data_processing/sensor3.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "square":
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_3[STATE]\nWAVEFORM=square\n";
			
			$fh1 = fopen("data_processing/sensor3.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
									
		}
		
		
	}
	
	
	if (isset($_POST['r3_stopsub']))
	{
	
			$string1 = "# SENSOR CONFIGURATION\nSTATE=0\nWAVEFORM=$ini_3[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor3.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	
	}
	
	if (isset($_POST['r3_startsub']))
	{
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=1\nWAVEFORM=$ini_3[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor3.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	}
	
	
// r4 Control
// --------------------------------------------------

	if  (isset($_POST['r4_datasub'])) 
	{

		$r4_datastream = $_POST['r4_datastream'];

		switch ($r4_datastream)
		{
			
		case "sine":	
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_4[STATE]\nWAVEFORM=sine\n";
							
			$fh1 = fopen("data_processing/sensor4.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "triangle":
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_4[STATE]\nWAVEFORM=triangle\n";
			
			$fh1 = fopen("data_processing/sensor4.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
				
		case "square":
			
			$string1 = "# SENSOR CONFIGURATION\nSTATE=$ini_4[STATE]\nWAVEFORM=square\n";
			
			$fh1 = fopen("data_processing/sensor4.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);
			break;
									
		}
		
		
	}
	
	
	if (isset($_POST['r4_stopsub']))
	{
	
			$string1 = "# SENSOR CONFIGURATION\nSTATE=0\nWAVEFORM=$ini_4[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor4.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	
	}
	
	if (isset($_POST['r4_startsub']))
	{
		
			$string1 = "# SENSOR CONFIGURATION\nSTATE=1\nWAVEFORM=$ini_4[WAVEFORM]\n";
			
			$fh1 = fopen("data_processing/sensor4.conf",'w') or die("can't open file");
			fwrite($fh1, $string1);
			fclose($fh1);

	}
		
	
	
	
if ($_SESSION['user_name'] == "admin")
{
	
?>

	<html>

	<head>
	<style type="text/css">
	
		body 
		{
			background-color: #000000;
			color: #eeeeee;
			text-align: center;
			font-family: monospace, tahoma, arial, sans-serif;
			font-size: 10pt;
		}

		form, table {display:inline; margin:0px; padding:75px;}
		form.tight {display:inline; margin:0px; padding:0px;}

	</style>
	
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery.form.js"></script>
	<script type="text/javascript" src="smoothie.js"></script>
	<script type="text/javascript" src="admin_dashboard.js"></script>
	</head>
	
	<body onload="init()">

	<h1> SENSOR NETWORK </h1>


<!-- // R1														  -->
<!------------------------------------------------------------------>
	R1
	<canvas id="R1" width="500" height="100"></canvas>
	
	<p>
	<form action="index.php" method="post">
		
		<select name="r1_datastream">
			<option>sine</option>
			<option>triangle</option>
			<option>square</option>
		</select>
		
		<input type="submit" name="submit" value="submit" />
		<input type="hidden" name="r1_datasub" value="1" />
	</form>




	<form class="tight" action="index.php" method="post">
		<input type="submit" name="r1_stop" value="stop"  />
		<input type="hidden" name="r1_stopsub" value="1" />
	</form>	

	
	
	<form class="tight" action="index.php" method="post">
		<input type="submit" name="r1_start" value="start" />
		<input type="hidden" name="r1_startsub" value="1" />		
	</form>	
	</p>

	
<!-- // R2														  -->
<!------------------------------------------------------------------>
	R2
	<canvas id="R2" width="500" height="100"></canvas>
	
	<p>
	<form action="index.php" method="post">
		
		<select name="r2_datastream">
			<option>sine</option>
			<option>triangle</option>
			<option>square</option>
		</select>
		
		<input type="submit" name="submit" value="submit" />
		<input type="hidden" name="r2_datasub" value="1" />
	</form>




	<form class="tight" action="index.php" method="post">
		<input type="submit" value="stop" name="r2_stop"></input>
		<input type="hidden" name="r2_stopsub" value="1" /></input>	
	</form>	

	
	
	<form class="tight" action="index.php" method="post">
		<input type="submit" value="start" name="r2_start"></input>
		<input type="hidden" name="r2_startsub" value="1" /></input>		
	</form>	
	</p>

		
<!-- // R3														  -->
<!------------------------------------------------------------------>
	R3
	<canvas id="R3" width="500" height="100"></canvas>
	
	<p>
	<form action="index.php" method="post">
		
		<select name="r3_datastream">
			<option>sine</option>
			<option>triangle</option>
			<option>square</option>
		</select>
		
		<input type="submit" name="submit" value="submit" />
		<input type="hidden" name="r3_datasub" value="1" />
	</form>




	<form class="tight" action="index.php" method="post">
		<input type="submit" value="stop" name="r3_stop"></input>
		<input type="hidden" name="r3_stopsub" value="1" /></input>	
	</form>	

	
	
	<form class="tight" action="index.php" method="post">
		<input type="submit" value="start" name="r3_start"></input>
		<input type="hidden" name="r3_startsub" value="1" /></input>		
	</form>	
	</p>

		
<!-- // R4														  -->
<!------------------------------------------------------------------>
	R4
	<canvas id="R4" width="500" height="100"></canvas>
	
	<p>
	<form action="index.php" method="post">
		
		<select name="r4_datastream">
			<option>sine</option>
			<option>triangle</option>
			<option>square</option>
		</select>
		
		<input type="submit" name="submit" value="submit" />
		<input type="hidden" name="r4_datasub" value="1" />
	</form>


	<form class="tight" action="index.php" method="post">
		<input type="submit" value="stop" name="r4_stop"></input>
		<input type="hidden" name="r4_stopsub" value="1" /></input>	
	</form>	

	
	
	<form class="tight" action="index.php" method="post">
		<input type="submit" value="start" name="r4_start"></input>
		<input type="hidden" name="r4_startsub" value="1" /></input>		
	</form>	
	</p>

  </body>
</html>


<?php } else { ?>

<html>
<html>
  <head>
    <style type="text/css">
      
		body 
		{
			background-color: #000000;
			color: #eeeeee;
			text-align: left;
			font-family: monospace, tahoma, arial, sans-serif;
			font-size: 10pt;
			

    </style>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="smoothie.js"></script>
    <script type="text/javascript" src="admin_dashboard.js"></script>
  </head>
  <body onload="init()">

	<h1> SENSOR NETWORK </h1>

    <h4>R1</h4>
    <canvas id="R1" width="500" height="100"></canvas>

<br></br>


   
  </body>
</html>

<?php } ?>

<?php if (isset($_SESSION['logged_in'])) 
{ 

$_SESSION['refresh_ct'] = 1;

?>

<br />
<a href="logout.php?signature=<?php echo $_SESSION['signature']; ?>">Logout</a>

<br /><?php } ?>
