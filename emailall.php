<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installation and usage instructions 
Version: 4.1 	1/9/2012
-->

<?php
@ob_start();
session_start();

if (!$_SESSION['VNSB']) { 
?>
	<meta http-equiv="Refresh"content="0;url=adminlogin.php">
<?php
} else {
        $superbowlURL = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].trim($_SERVER['PHP_SELF'], "emailall.php");
        
	require_once('includes/dbTables.inc');
        $conn = dbConnection();
        if (!$conn) {
            die("Are you sure your database is setup correctly?   I'm giving up!".mysqli_connect_error());
        }
 
	$sendemails = $_POST['sendemails'];

	$LINKS = "
		<p>
		  <table width=\"50%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-family: verdana, arial; font-size: 12px\">
			<tr>
			<td width=\"33%\"><a href=\"$superbowlURL\" title=\"Home\">Home</a></td>
			<td width=\"34%\" align=\"center\"><a href=\"admin.php\" title=\"Administrator\">Admin</a></td>
			<td width=\"33%\" align=\"right\"><a href=\"adminlogout.php\" title=\"Admin logout\">Logout</a></td>
			</tr>
		  </table>
		</p>
	";


	require "includes/header.inc"; 

	function notify_admin ($mailto, $mailmessage, $mail_headers)
	{
		mail("$mailto", "Super Bowl Squares", "$mailmessage", "$mail_headers");
	}
?>

	<h3>Send Email to ALL</h3>
	<?php 
	if (!isset($sendemails)) { ?>
	  <table width="50%" cellpadding="5" style="font-family: verdana, arial; border: #FFCC99 1px solid">
		<tr> 
			<td height="28" colspan="3" align="center" style="font-size: 11px">
				<strong>Click the button below to send an email to everyone and let them know the numbers have been picked and assigned for them to view and print as needed.</strong>
			</td>
		</tr>
		<tr> 
		  <td width="" align="center" valign="top">
			<form name="approval"  action="emailall.php" method="post"> 
				<table width="100%" border="0" style="font-family: verdana, arial; font-size: 11px">
				  <tr>
					<td>&nbsp;</a></td>
					<td align="center"><br/><p><input type="submit" value="Send Emails" name="sendemails"></p></td>
				  </tr>
				</table>		
			</form>
			</td>
		</tr>
	  </table>
	<?php 
	echo $LINKS;

	} else {
		echo "<p>Emails send to:</p>";
		$bodyMessage = "\r\nNOTIFICATION\r\n";
		$bodyMessage .= "All squares have been selected and all numbers have been picked and assigned.\r\n";
		$bodyMessage .= "You can view and print your own sheet at $superbowlURL.\r\n\n";								
		$bodyMessage .= "Good Luck and enjoy the game.\r\n";
		$bodyMessage .= "The Commissioner\r\n";
		$headers = "From: $ADMIN_EMAIL\r\n";
		$sql="SELECT * FROM VNSB_squares ORDER BY EMAIL";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			echo mysqli_error();
			exit;
		}
		while ($record = mysqli_fetch_assoc($result)) {
			if ($USER_EMAIL != $record["EMAIL"]) {
				$USER_NAME = $record["NAME"];
				$USER_EMAIL = $record["EMAIL"];
				notify_admin($USER_EMAIL,$bodyMessage,$headers);
				echo "<p><b>".$USER_NAME."</b>: ".$USER_EMAIL."</p>";
			}
		}				

		echo $LINKS;
		unset($sendemails);
		$headers = "From: $ADMIN_EMAIL\r\n";
		notify_admin($ADMIN_EMAIL,$bodyMessage,$headers);
	} ?>
<?php require "includes/footer.inc"; 

}
?>
