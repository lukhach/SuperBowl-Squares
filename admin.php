<?php 
session_start();
@ob_start();
 
#www.vnlisting.com
#Online Super Bowl Squares Script
#Please read the "Readme.txt for license agreement, installation and usage instructions 


if (!isset($_SESSION['VNSB'])) { 
?>
        <meta http-equiv="Refresh"content="0;url=adminlogin.php">
<?php
} else {

	require "includes/dbTables.inc"; 
        $conn = dbConnection();
	if (!$conn) {
	    die("Are you sure your database is setup correctly?   I'm giving up!". mysqli_connect_error());
	}

        $superbowlURL = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].trim($_SERVER['PHP_SELF'], "admin.php");
	$confirmation = $_POST['Confirmation'];
	$SQUARE = $_POST['square'];
	$CONFIRM = $_POST['confirm'];
	$RELEASE = $_POST['release'];
	$NOTES = $_POST['body'];

	require "includes/header.inc"; 

	//$headers = "From: $ADMIN_EMAIL\r\nBcc: $ADMIN_EMAIL\r\n";

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$headers .= "From: Admin <$ADMIN_EMAIL>" . "\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	$headers .= 'Bcc: Admin <$ADMIN_EMAIL>' . "\r\n";


				
	function notify_admin ($mailto, $mailmessage, $mail_headers)
	{
		mail("$mailto", "Super Bowl Squares", "$mailmessage", "$mail_headers");
		//echo "mail(\"$mailto\", \"Super Bowl Squares\", \"$mailmessage\", \"$mail_headers\")</br>;";
	}
	?>

	<h3>ADMINISTRATOR APPROVAL</h3>

	<?php 
	if (!isset($confirmation)) { ?>
	  <table width="50%" cellpadding="5" style="font-family: verdana, arial; border: #FFCC99 1px solid">
		<tr> 
			<td height="28" colspan="3" align="center" style="font-size: 11px">
				<strong>Confirm user selected square when payment is verified, or release the square if allowed time for payment has expired.</strong>
			</td>
		</tr>
		<tr> 
		  <td width="" align="center" valign="top">
			<form name="approval"  action="admin.php" method="post" enctype="multipart/form-data"> 
				<table width="100%" border="0" style="font-family: verdana, arial; font-size: 11px">
				  <tr>
					<td><b>Square</b></td>
					<td>
						<select name="square[]" id="square" size="11" multiple>
							<!--<option value="">Select One</option>-->
							<?php
								$sql="SELECT * FROM `VNSB_squares` WHERE NAME!='AVAILABLE' AND NAME!='' AND CONFIRM='0' ORDER BY NAME, SQUARE";
								$result = mysqli_query($conn, $sql);
								if (!$result) {
									echo mysqli_error();
									exit;
								}
								while ($record = mysqli_fetch_assoc($result)) {
									echo "<option value = '".$record['SQUARE']."'>".$record["NAME"]." - ".$record["SQUARE"]."</option>";
								}
							?>
						</select>
					</td>
				  </tr>
				  <tr>
					<td><b>Confirm</b></td>
					<td><input type="checkbox" name="confirm" value="1"></td>
				  </tr>
				  <tr>
					<td><b>Release</b></td>
					<td><input type="checkbox" name="release" value="1"></td>
				  </tr>
				  <tr>
					<td><b>Notes to User</b></td>
					<td><textarea name="body" rows="3" cols="50" wrap="virtual" style="font-family: verdana, arial; font-size: 10px"></textarea></td>
				  </tr>
				  <tr>
					<td>&nbsp;</a></td>
					<td><br/><p><input type="submit" value="Confirmation" name="Confirmation"></p></td>
				  </tr>
				</table>		
			</form>
			</td>
		</tr>
	  </table>
	 <p>
	  <table width="50%" border="0" cellspacing="0" cellpadding="0" style="font-family: verdana, arial; font-size: 12px">
		<tr>
		<td width="25%"><a href="<?php echo $superbowlURL; ?>" title="Home">Home</a></td>
		<td width="25%" align="center"><a href="randomnumber.php" title="Random Numbers">Numbers</a></td>
		<td width="25%" align="center"><a href="scores.php" title="Enter scores">Scores</a></td>
		<td width="25%" align="right"><a href="adminlogout.php" title="Admin logout">Logout</a></td>
		</tr>
	  </table>
	</p>
	<?php 
	} else {
		if (count($SQUARE) > 0){
			$input = "";
			$whereclause = "(";
			
			for($e=0; $e<count($SQUARE); $e++){ 
				$whereclause = $whereclause . "SQUARE = '" . trim($SQUARE[$e]) . "' OR ";
				$square_list = $square_list .", ".$SQUARE[$e];
			}
			
			$whereclause = substr_replace($whereclause,"",-3);  // strip off ' OR'
			$whereclause = $whereclause .")";
		
			$square_list = substr_replace($square_list,"",0,2);
			//echo $square_list."</br>";
			
			$sql="SELECT * FROM `VNSB_squares` WHERE $whereclause";
			//echo $sql."</br>";
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				echo mysqli_error();
				exit;
			}
			
			$USER_EMAIL_LIST = '';
			while ($record = mysqli_fetch_assoc($result)) {
				$USER_EMAIL = '';
				$USER_EMAIL = $record["EMAIL"];
				
				$pos = strpos($USER_EMAIL_LIST,$USER_EMAIL);
				if($pos === false) {
					// string $USER_EMAIL NOT found in $USER_EMAIL_LIST
					$USER_EMAIL_LIST = $USER_EMAIL_LIST .",".$USER_EMAIL;
				}
			}
			$USER_EMAIL_LIST = substr_replace($USER_EMAIL_LIST,"",0,1);
						
			$bodyMessage = "\r\nNOTIFICATION\r\n";
			//echo $bodyMessage."</br>";
			if ($CONFIRM==1 AND $RELEASE!=1) {
				$sql="UPDATE `VNSB_squares` SET CONFIRM='1' WHERE $whereclause";			
				$bodyMessage .= "Your square $square_list is now confirmed.\r\n\n";
			} else if ($RELEASE==1 AND $CONFIRM!=1) {
				$sql="UPDATE `VNSB_squares` SET NAME='AVAILABLE', EMAIL='', NOTES='', DATE='', CONFIRM='0' WHERE $whereclause";
				$bodyMessage .= "Your square $square_list selection is now released due to no payment.\r\n";
				$bodyMessage .= "If this is an error, please contact me or re-select your square.\r\n\n";
			} else if (($CONFIRM!=1 AND $RELEASE!=1) OR ($RELEASE==1 AND $CONFIRM==1) ) {
				echo "<p>Must select ONLY one 'Confirm' or 'Release' !!!</p>";
				echo "<p><a href='javascript:onClick=history.go(-1);'>Back</a></p>";
				exit;
			}
			//echo $sql."</br>";
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				echo mysqli_error();
			} else {
				$bodyMessage .= $NOTES."\r\n\n";								
				$bodyMessage .= "Good Luck and enjoy the game.\r\n";
				$bodyMessage .= "The Commissioner\r\n";
				$bodyMessage .= "$superbowlURL\r\n";		
							
				notify_admin($USER_EMAIL_LIST,$bodyMessage,$headers);
				echo "<p>Square(s) <b>".$square_list."</b> updated successful</p>";
				echo "<p>Emailed to: ".$USER_EMAIL_LIST."</p>";
				echo "
					<p>
					  <table width=\"50%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-family: verdana, arial; font-size: 12px\">
						<tr>
						<td width=\"33%\"><a href=\"$superbowlURL\" title=\"Administrator\">Home</a></td>
						<td width=\"34%\" align=\"center\"><a href=\"./admin.php\" title=\"Administrator\">Admin</a></td>
						<td width=\"33%\" align=\"right\"><a href=\"adminlogout.php\" title=\"Admin logout\">Logout</a></td>
						</tr>
					  </table>
					</p>";
				unset($confirmation, $SQUARE, $CONFIRM, $RELEASE, $NOTES, $ADM_EMAIL, $ADM_PASSWORD);
			}
		}else{
			echo "<p>Must select at least one Square to Confirm or Release' !!!</p>";
			echo "<p><a href='javascript:onClick=history.go(-1);'>Back</a></p>";
			exit;
		}

	} ?>
	<p align="center" style="">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="admin@vnlisting.com">
		<input type="hidden" name="item_name" value="NFL Super Bowl Squares Scripts">
		<input type="hidden" name="item_number" value="3">
<!--					<b>Enter Donation amount: $</b><input type="text" name="amount" value="" size=6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value="click here to Donate">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
		<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHNwYJKoZIhvcNAQcEoIIHKDCCByQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYA2estwKoVCckgAdhQywU8gbgrJxnSDQ7U3kcDzp9kVWh+ey7JmejervwbjeKiNvgmzBdJUD3irqnFiD88iiD3EnwrzJKNz7HYnh260uFNaUnhjWhalkK5aGgDzvI6vq7xQ1fRQu6AYbSr8IIqxpU/FyMvLdDP/LRt6BOTwEH3IgzELMAkGBSsOAwIaBQAwgbQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIH4rlyAySQpuAgZBZdfgl60vRvSNmf/jg7soyG4rj8L5IwDwAmx7vSnYQLqQUUOmyQ9ZPIoaUR7y8bwdf1Gzou86Q9mHu3eV3lvWQAyKi01BgYmDj0ENoycpQqDs8pBZzwY1qh6atvcc/+sLoHzZ5uUqBA3RWExEU1W4r36YnOni+AChBKfBB5PWv2/bzZSrO41LXN1CnWNcaN06gggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0wNjAxMjEwMDQ2MjZaMCMGCSqGSIb3DQEJBDEWBBTq5veqr7s7hYvPRjaEeymblr5ImjANBgkqhkiG9w0BAQEFAASBgAv448wf84lW4+N1Sd7g6Kt+SJ4gJ5goll8sDzSYz8aRxvLqx4P6ZLPxNOLOYTgTkGPzFY0D6m2kuFslf8usxGv8f8grSeN9rLdpAJfyNxdfKgsnCIke4Id25Tcj7nBvvL7fiRiQo8cTJHTg9SdJlfb6MkyZoZKN25xrNqman0cx-----END PKCS7-----
		">
		</form>
	</p>
	<?php require "includes/footer.inc"; 
}
?>
