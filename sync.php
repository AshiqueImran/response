<?php require 'header.php'; ?>

<div class="container mt-3"> <!-- container -->

<div class="row">
	<div class="col-md-6 offset-md-3">
		<h3 class="text-center bg-info text-white p-3">Making the Database</h3>
	</div>
</div>

<div class="row"> <!-- table ROW -->
	
	<div class="col-md-6 my-3">
		<?php 
			echo '<a href="'.$GLOBALS['resultDatabaseFile'].'" target="_blank"><button type="button" class="btn btn-outline-success">Download Database</button></a>';
		?>
	</div>

	<div class="col-md-6 my-3">
		 <a href="index.php">
		 	<button type="button" class="btn btn-outline-dark float-right">Home</button>
		 </a>

	</div>

	<div class="table-responsive">          
	<table class="table table-hover table-bordered">
	<thead>
	<tr>
		<th>Serial</th>
		<th>Site</th>
		<th>VLAN</th>
		<th>Service</th>
		<th>Bl Fo Mini Hubs</th>
	</tr>
	</thead>
	<tbody>
<?php 

$mainURL='http://172.16.7.128:8080/iptoolmanagement/public/index.php/get_search_field_data_on_change';
$allSitesResponse = file_get_contents($mainURL);
$allSitesResponse = json_decode($allSitesResponse, true);

$allSitesResponse=$allSitesResponse["site_names"];

// $site='DHK_X1200';

$file = fopen($GLOBALS['resultDatabasePivotFileName'],"w");
$row1="Site".','."VLAN".','."Service".','."	Bl Fo Mini Hubs";

fputcsv($file,explode(',',$row1));

$serial=0;
foreach ($allSitesResponse as $site) 
{
	if (isValidSiteCode($site))
	{
		// echo '<h4 class="text-success">'.$site."</h4><br>";

		$url='http://172.16.7.128:8080/iptoolmanagement/public/index.php/get_search_field_data_on_change?site_name='.$site;

		$url = preg_replace("/ /", "", $url); // removes blank spaces

		// $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		// $context = stream_context_create($opts);
		// $get_data = file_get_contents($url,false,$context);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
		$get_data = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($get_data, true);

		$services=$response["services"];
		$bl_fo_mini_hubs=$response["bl_fo_mini_hubs"];
		$site_names=$response["site_names"];
		$service_vlans=$response["service_vlans"];

		if (!empty($services) and !empty($bl_fo_mini_hubs) and !empty($site_names))
		{
			// print_r ($services);
			// print_r ($bl_fo_mini_hubs);
			// print_r ($site_names);
			// print_r ($service_vlans);

			if (sizeof($service_vlans)==0)
			{
			//vlan array empty means all the vlans under

				if (sizeof($services)>=1)
				{
					echo "<tr>";
					$serial++;
					echo "<td>".$serial."</td>";
					echo '<td>'.$site_names[0].'</td>';
					$vlan='';
					if (sizeof($service_vlans)>=1)
					{
						$vlan=$service_vlans[0];
						echo '<td>'.$service_vlans[0].'</td>';
					}
					else
					{
						$vlan='';
						echo '<td>'.''.'</td>';
					}
					echo '<td>'.$services[0].'</td>';
					echo '<td>'.$bl_fo_mini_hubs[0].'</td>';
					echo "</tr>";

					fputcsv($file,[$site_names[0],$vlan,$services[0],$bl_fo_mini_hubs[0]]);
				}
				if (sizeof($services)==2)
				{
					echo "<tr>";
					$serial++;
					echo "<td>".$serial."</td>";
					echo '<td>'.$site_names[0].'</td>';
					$vlan='';
					$minihub='';
					if (sizeof($service_vlans)>=2)
					{
						$vlan=$service_vlans[1];
						echo '<td>'.$service_vlans[1].'</td>';
					}
					else if (sizeof($service_vlans)>=1)
					{
						$vlan=$service_vlans[0];
						echo '<td>'.$service_vlans[0].'</td>';
					}
					else
					{
						$vlan='';
						echo '<td>'.''.'</td>';
					}
					echo '<td>'.$services[1].'</td>';
					if(sizeof($bl_fo_mini_hubs)>=2)
					{
						$minihub=$bl_fo_mini_hubs[1];
						echo '<td>'.$bl_fo_mini_hubs[1].'</td>';
					}
					else
					{
						$minihub=$bl_fo_mini_hubs[0];
						echo '<td>'.$bl_fo_mini_hubs[0].'</td>';
					}
					echo "</tr>";

					fputcsv($file,[$site_names[0],$vlan,$services[1],$minihub]);
				}

				if (sizeof($services)==3 and strpos($services[2],"OM")==False)
				{
					echo "<tr>";
					$serial++;
					echo "<td>".$serial."</td>";
					echo '<td>'.$site_names[0].'</td>';
					$vlan='';
					if (sizeof($service_vlans)>=3)
					{
						$vlan=$service_vlans[2];
						echo '<td>'.$service_vlans[2].'</td>';
					}
					else if (sizeof($service_vlans)>=2)
					{
						$vlan=$service_vlans[1];
						echo '<td>'.$service_vlans[1].'</td>';
					}
					else if (sizeof($service_vlans)>=1)
					{
						$vlan=$service_vlans[0];
						echo '<td>'.$service_vlans[0].'</td>';
					}
					else
					{
						$vlan='';
						echo '<td>'.''.'</td>';
					}
					echo '<td>'.$services[1].'</td>';
					if(sizeof($bl_fo_mini_hubs)>=3)
					{
						echo '<td>'.$bl_fo_mini_hubs[2].'</td>';
					}
					else if(sizeof($bl_fo_mini_hubs)>=2)
					{
						echo '<td>'.$bl_fo_mini_hubs[1].'</td>';
					}
					else
					{
						echo '<td>'.$bl_fo_mini_hubs[0].'</td>';
					}
					echo "</tr>";

					fputcsv($file,[$site_names[0],$vlan,$services[1],$bl_fo_mini_hubs[0]]);
				}
			}

		}
		else
		{
			echo "<h5 class='text-danger'>".$site." not found !! </h5>";
		}
	}
}

fclose($file);

?>
	</tbody>
</table>
</div>

</div> <!-- table ROW Ends -->
<div class="row">
	<div class="col-md-6 offset-md-3 mt-5 text-center">
		<p>&copy Developed by 
			<a href="https://github.com/AshiqueImran" target="_blank">Md. Ashique Imran</a>
		</p>
	</div>
</div>


</div> <!-- container -->

</body>
</html>

<?php
	if(file_exists($GLOBALS['resultDatabaseFile']))
	{
		unlink($GLOBALS['resultDatabaseFile']); // deletes old file
	}

	if (file_exists($GLOBALS['resultDatabasePivotFileName']))
	{
		rename($GLOBALS['resultDatabasePivotFileName'],$GLOBALS['resultDatabaseFile']); // renames pivot file to original name
	}
?>