<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installation and usage instructions 
-->

<?php 
@ob_start();
session_start();
?>

<html>
<head>
<title>ADMIN - Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<center>
<?php
$email=$_POST['AdminEmail'];
$pass=$_POST['AdminPass'];

// check to see if details have been passed to the script by the form
if ($email && $pass) {
	if ($_SESSION['VNSB']) {
		echo $email.", you are already logged in.<br/><br/>";
		echo "<a href='admin.php'>Admin</a><br/><br/><a href='adminlogout.php'>Log out.</a>";
		exit;
	}
	// check input variables against database
        include('includes/dbTables.inc');
        $conn = dbConnection();
        if (!$conn) {
            die("Are you sure your database is setup correctly?   I'm giving up!". mysqli_connect_error());
        }

	$sql = "SELECT Admin_email, Admin_pwd FROM `VNSB_settings`";
	$result = mysqli_query($conn, $sql);									
	// in case of an error, throw up an error message and exit
	if (!$result) {
		echo "Sorry, there is a problem with accessing your database!!!";
		exit;
	} else {
		$record = mysqli_fetch_assoc($result);
		if ($email==$record['Admin_email'] AND md5($pass)==$record['Admin_pwd']) {
			$_SESSION['VNSB']=$record['Admin_email'];
			mysqli_close($conn);
			header ("Location: admin.php");
		} else {
			echo "<center><h1>Invalid login</h1><p><a href=\"adminlogin.php\">Admin login</a></p></center>";
			mysqli_close($conn);
			exit;
		}
	}
}

?>
<br />
<p>
<p style="width:60%"><strong>Welcome, Admin!</strong><br />
If you feel that the work I've done has value to you, I would greatly appreciate a paypal donation (click button below). I have spent many hours working on this project, and I will continue its development as I find the time. Again, I am very grateful for any and all contributions.</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="admin@vnlisting.com">
<input type="hidden" name="item_name" value="NFL Super Bowl Squares Scripts">
<input type="hidden" name="item_number" value="3">
<b>Enter Donation amount: $</b><input type="text" name="amount" value="" size=6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value="click here to Donate">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHNwYJKoZIhvcNAQcEoIIHKDCCByQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYA2estwKoVCckgAdhQywU8gbgrJxnSDQ7U3kcDzp9kVWh+ey7JmejervwbjeKiNvgmzBdJUD3irqnFiD88iiD3EnwrzJKNz7HYnh260uFNaUnhjWhalkK5aGgDzvI6vq7xQ1fRQu6AYbSr8IIqxpU/FyMvLdDP/LRt6BOTwEH3IgzELMAkGBSsOAwIaBQAwgbQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIH4rlyAySQpuAgZBZdfgl60vRvSNmf/jg7soyG4rj8L5IwDwAmx7vSnYQLqQUUOmyQ9ZPIoaUR7y8bwdf1Gzou86Q9mHu3eV3lvWQAyKi01BgYmDj0ENoycpQqDs8pBZzwY1qh6atvcc/+sLoHzZ5uUqBA3RWExEU1W4r36YnOni+AChBKfBB5PWv2/bzZSrO41LXN1CnWNcaN06gggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0wNjAxMjEwMDQ2MjZaMCMGCSqGSIb3DQEJBDEWBBTq5veqr7s7hYvPRjaEeymblr5ImjANBgkqhkiG9w0BAQEFAASBgAv448wf84lW4+N1Sd7g6Kt+SJ4gJ5goll8sDzSYz8aRxvLqx4P6ZLPxNOLOYTgTkGPzFY0D6m2kuFslf8usxGv8f8grSeN9rLdpAJfyNxdfKgsnCIke4Id25Tcj7nBvvL7fiRiQo8cTJHTg9SdJlfb6MkyZoZKN25xrNqman0cx-----END PKCS7-----
">
</form>

</p>
<br>
<h2>Admin login</h2>
 
<form method="post" action="adminlogin.php">
<p> Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="AdminEmail" type="email" size="30"></p>
<p> Password: <input name="AdminPass" type="password" size="30"></p>
<p> <input type="submit" value="Login"></p>
</form>

</center>
</body>
</html>
