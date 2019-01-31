<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installtion and usage instructions 
-->

<?php
// Full URL path to your superbowl. ex. www.yoursite.com/superbowl
$superbowlURL = "http://www.vnlisting.com/superbowl";

//make changes accordingly to your database
$hostname = "localhost";
$database = "superbowl";
$username = "superbowl";
$password = "password";
$db = mysql_connect($hostname, $username, $password);
$db_select = mysql_select_db($database, $db) or mysql_error();
?>
