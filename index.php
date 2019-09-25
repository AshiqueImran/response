<?php require 'header.php'; ?>

<div class="container-fluid mainDiv">

	<div class="row content">
		<!-- <a href="sync.php">sync</a> -->

		<div class="col-md-8 offset-md-2 text-center my-auto fullOpacity">

			<h1 class="headLine">Fiberization Database</h1>

			<p class="text-white">Last update : 
				<b>
					<?php
						if ($GLOBALS['lastModified']=='File does not exist.')
						{
							echo $GLOBALS['resultDatabaseFile'].' '.$GLOBALS['lastModified'];
						}
						else
						{
							echo date("d/m/Y, h:i A",$GLOBALS['lastModified']);
						}
					?>
				</b>
			</p>

			<a href=<?php echo ' " '.$GLOBALS['resultDatabaseFile'].' " '; ?> target="_blank"><button class="btn btn-outline-warning btn-lg mx-1 rounded my-2">Download</button></a>

			<a href="sync.php"><button class="btn btn-outline-danger btn-lg mx-1 rounded my-2">Update</button></a>
			
		</div>


	</div>

</div> <!-- container -->

</body>
</html>