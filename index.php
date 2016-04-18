<?php
$json = file_get_contents("http://".$_SERVER['SERVER_NAME']."/status/status-api.php");
$infos = json_decode($json);

$percentageRAMClear = substr($infos->memPercentageUsed, 0, strlen($infos->memPercentageUsed) -2);
$percentageRAMClear = number_format($percentageRAMClear, 2, '.', '');
$percentageDiskClear = substr($infos->spacePercentageUsed, 0, strlen($infos->spacePercentageUsed) -2);
$percentageDiskClear = number_format($percentageDiskClear, 2, '.', '');

header("Refresh:10;url=index.php");
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Pi Status</title>
		<link rel="stylesheet" type="text/css" href="status.css">
		<link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="weather-icons-master/css/weather-icons.min.css">	
		<style>
			#progress1{
				width: <?php echo $percentageRAMClear; ?>%;
			}
			#progress2{
				width: <?php echo $percentageDiskClear; ?>%;
			}
		</style>
	</head>
	<body>
		<div id="main">
			<div id="header">
				Raspberry Pi - Status
			</div>
			<table class="infos" id="table1">
				<tr class="headline">
					<td>
						<div class="icon">
							<i class="fa fa-wifi fa-1x"></i><span class="icon-text">Uptime</span>
						</div>
					</td>
					<td colspan="2">
						<div class="icon">
							<i class="fa fa-tachometer fa-1x"></i><span class="icon-text">CPU-Load</span>
						</div>
					</td>
					<td>
						<div class="icon">
							<i class="wi wi-thermometer"></i><span class="icon-text">Temperature</span>
						</div>
					</td>
				</tr>
				<tr class="value">
					<td><?php echo $infos->uptime;?></td>
					<td colspan="2"><?php echo $infos->cpuLoad;?></td>
					<td><?php echo $infos->temperature;?></td>
				</tr>
			</table>
			<table class="infos">
				<tr class="headline">
					<td colspan="2">
						<div class="icon">
							<i class="fa fa-hdd-o fa-1x"></i><span class="icon-text">RAM</span>
						</div>
					</td>
					<td colspan="2">
						<div class="icon">
							<i class="fa fa-database fa-1x"></i><span class="icon-text">Disk</span>
						</div>
					</td>
				</tr>					
				<tr>
					<td colspan="2">
						<table class="details">
							<tr class="value">
								<td>Total:</td>
								<td class="right"><?php echo $infos->memTotal;?></td>
							</tr>
							<tr>
								<td>Free:</td>
								<td class="right"><?php echo $infos->memFree;?></td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="border">				
										<div class="bar">	
											<div class="percentage"><?php echo $infos->memPercentageUsed;?></div>	
											<div class="progress" id="progress1">
											</div>
										</div>		
									</div>									
								</td>
							</tr>
						</table>
					</td>
					<td colspan="2">
						<table class="details">
							<tr class="value">
								<td>Total:</td>
								<td class="right"><?php echo $infos->totalSpace;?></td>
							</tr>
							<tr>
								<td>Free:</td>
								<td class="right"><?php echo $infos->freeSpace;?></td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="border">				
										<div class="bar">	
											<div class="percentage"><?php echo $infos->spacePercentageUsed;?></div>	
											<div class="progress" id="progress2">
											</div>
										</div>		
									</div>								
								</td>
							</tr>
						</table>
					</td>
				</tr>					
			</table>			
		</div>		
	</body>
</html>