<?php
session_start();
if(!isset($_SESSION['loggedIn']))
{
    header('Location: login.php');
    exit;	
}
//$uptime = shell_exec('sudo shutdown -r now');

?>