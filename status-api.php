<?php
//uptime
$uptime = shell_exec('uptime');
$start = strpos($uptime, "up") + 3;
$uptime = substr($uptime, $start, strpos($uptime, ",", $start) - $start);

//RAM
$memTotal = shell_exec('cat /proc/meminfo | grep MemTotal | cut -d: -f2 | tr -d " "') / 1024;
$memTotal = substr($memTotal, 0, strlen($memTotal)-3);
$memFree = shell_exec('cat /proc/meminfo | grep MemFree | cut -d: -f2 | tr -d " "') / 1024;
$memFree = substr($memFree, 0, strlen($memFree)-3);

$memUsed = $memTotal - $memFree;
$memPercentageUsed =  ($memUsed / $memTotal) * 100;

$memPercentageUsed = number_format($memPercentageUsed, 2, ',', '')." %";
$memTotal = number_format($memTotal, 2, ',', '')." MB";
$memFree = number_format($memFree, 2, ',', '')." MB";

//disk space
$totalSpace = disk_total_space("/") / 1024 / 1024;
$freeSpace = disk_free_space("/") / 1024 / 1024;

$usedSpace = $totalSpace - $freeSpace;
$percentage =  $usedSpace / $totalSpace;
$percentage *= 100;

$percentage = number_format($percentage, 2, ',', '')." %";
$totalSpace = number_format($totalSpace/1024, 2, ',', '')." GB";
$freeSpace = number_format($freeSpace/1024, 2, ',', '')." GB";

//temp
$currentTemp = shell_exec('cat /sys/class/thermal/thermal_zone0/temp') / 1000;
$currentTemp = number_format($currentTemp, 2, ',', '')." &deg;C";

//cpu
$load = shell_exec("top -bn 2 -d 0.01 | grep '%Cpu' | tail -n 1 | awk '{print $2+$4+$6}'");
$load = trim(preg_replace('/\s+/', ' ', $load))." %";
$load = str_replace(".", ",", $load);

//json
$infos = array(
'uptime' => $uptime,
'memTotal' => $memTotal,
'memFree' => $memFree,
'memPercentageUsed' => $memPercentageUsed,
'totalSpace' => $totalSpace,
'freeSpace' => $freeSpace,
'spacePercentageUsed' => $percentage,
'temperature' => $currentTemp,
'cpuLoad' => $load
);

echo json_encode($infos);
?>