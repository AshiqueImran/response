<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Acme&display=swap" rel="stylesheet">

	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<script type="text/javascript" src="js/jquery.3.3.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<title>Fiberization Database [<?php echo basename($_SERVER['REQUEST_URI'],".php"); ?>]</title>

	<style type="text/css">
		body{
			font-family: Cambria;
		}
		.mainDiv{
		    background-image: url(img/64857.jpg);
		    background-position: center;
		    background-size: cover;
		    background-repeat: no-repeat;
		    height: 100vh;
		    /*opacity: 0.75;*/
		}

		.content{
		    background: rgba(0, 0, 0, 0.85);
		    height: 100vh;
		    width: 100vw;
		    z-index: 1;
		}
		.fullOpacity{
			opacity: 100% !important;
			z-index: 5;
		}
		.headLine
		{
			color:#3ae374;
			font-family: 'Acme', sans-serif;
			font-size: 3.5em;
			font-weight: 900;
			text-transform: uppercase;
			text-shadow: 1.5px 3.0px black;
		}
		.rounded
		{
			border-radius: 40px !important;
			min-width: 300px;
		}
		/* landing page ends */

	</style>

</head>
<body>

	<?php 

	ini_set('memory_limit', '8048M');
	ini_set('max_execution_time', '20000');
	ini_set('upload_max_filesize', '2000M');
	ini_set('post_max_size', '2000M');
	ini_set('auto_detect_line_endings', true);
	date_default_timezone_set("Asia/Dhaka");


	function isValidSiteCode($siteCode)
	{
	    if(preg_match('([a-z,A-Z,_]+\d{2,4})',$siteCode) or preg_match('([A-Z,a-z]+\d{2})',$siteCode))
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}

	$GLOBALS['resultDatabaseFile']='fiberization_Database.csv';
	$GLOBALS['resultDatabasePivotFileName']='1'.$GLOBALS['resultDatabaseFile']; // pivot file (1filename.csv) will be generated first

	
	if (file_exists($GLOBALS['resultDatabaseFile']))
	{
		$GLOBALS['lastModified']= filemtime($GLOBALS['resultDatabaseFile']);
	}
	else
	{
		$GLOBALS['lastModified']="File does not exist.";
	}

	?>