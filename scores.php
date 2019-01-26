<?php
@ob_start();
session_start();
if (!$_SESSION['VNSB']) { 
?>
	<meta http-equiv="Refresh"content="0;url=adminlogin.php">
<?php
} 
?>

<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installation and usage instructions 
Version: 4.2 	1/24/2013

TODO:
- email winners
- "0" score is not working
-->


<?php 

require_once('config.php'); 
require "header.inc"; 


$EMAIL = $_REQUEST['m'];
$NFC = array();
$AFC = array();
$NAME = array();
$NFC_1 = $_POST['NFC_1'];
$NFC_2 = $_POST['NFC_2'];
$NFC_3 = $_POST['NFC_3'];
$NFC_4 = $_POST['NFC_4'];
$AFC_1 = $_POST['AFC_1'];
$AFC_2 = $_POST['AFC_2'];
$AFC_3 = $_POST['AFC_3'];
$AFC_4 = $_POST['AFC_4'];

// Update
if (isset($_REQUEST['addscores'])) {
	$query="INSERT INTO VNSB_scores (NFC_FIRST, NFC_HALF, NFC_THIRD, NFC_FINAL, AFC_FIRST, AFC_HALF, AFC_THIRD, AFC_FINAL) VALUES ($NFC_1, $NFC_2, $NFC_3, $NFC_4, $AFC_1, $AFC_2, $AFC_3, $AFC_4)";
	$result = mysql_query($query);
	if (!$result) {
		echo mysql_error();
		echo "<BR>Sorry, Technical problem occurred... your scores were not added.<br><br> Email this problem to <a href=\"mailto:".$ADMIN_EMAIL."\">".$ADMIN_EMAIL."</a>";
		exit;
	}
}

function email_notify ($mailto)
{
	$mail_headers = "From: $ADMIN_EMAIL\r\n";
	$mail_subject = "Super Bowl Squares :: You are the winner";
	$mailmessage = "\r\nCongratulations\r\n";
	$mailmessage .= "You are the lucky winner for our Super Bowl Squares for $SB_DATE \r\n\n";								
	$mailmessage .= "Contact us to collect your winning.\r\n";
	$mailmessage .= "The Commissioner\r\n";
	
	mail("$mailto", "$mail_subject", "$mailmessage", "$mail_headers");
}
	
$query="SELECT * FROM `VNSB_scores`";
$result = mysql_query($query);
if (!$result) {
	echo mysql_error();
	exit;
}

$scores = mysql_fetch_assoc($result);
$NFC_FIRST=$scores['NFC_FIRST'];
$AFC_FIRST=$scores['AFC_FIRST'];
$NFC_HALF=$scores['NFC_HALF'];
$AFC_HALF=$scores['AFC_HALF'];
$NFC_THIRD=$scores['NFC_THIRD'];
$AFC_THIRD=$scores['AFC_THIRD'];
$NFC_FINAL=$scores['NFC_FINAL'];
$AFC_FINAL=$scores['AFC_FINAL'];

if (!isset($NFC_FINAL) && !isset($AFC_FINAL) ) { $ADD_SCORES = 1; } else { $ADD_SCORES = 0; };

//Get assigned numbers
$query="SELECT * FROM VNSB_numbers";
$result = mysql_query($query);
if (!$result) {
	echo mysql_error();
	exit;
}
$cnt=0;
while ($record = mysql_fetch_assoc($result)) {
	$cnt++;
	$NFC[$cnt]=$record['NFC'];
	$AFC[$cnt]=$record['AFC'];
}

// Get name for each squares
$query="SELECT * FROM VNSB_squares";
$result = mysql_query($query);
if (!$result) {
	echo mysql_error();
	exit;
}

while ($record = mysql_fetch_assoc($result)) {	
	$NAME[$record['SQUARE']] = $record['NAME'];
	$EMAIL[$record['SQUARE']] = $record['EMAIL'];
}


// Admin add scores
if ($ADD_SCORES) {
?>
	<form method="post" action="">
	<table width="" cellpadding="0" cellspacing="10" style="font-family: Verdana,Ariel; font-size: 12px">
		<tr><td align="center" colspan="5" style="font-weight:bold;">QUARTERLY SCORES</td></tr>
		<tr>
		<tr>
			<td align="right" valign="bottom" style="color:#232b85; font-weight:bold"><?php echo $NFC_TEAM ?></td>
			<td align="center" style="font-weight:bold;">First<br><input type="text" name="NFC_1" size="5" maxlength="2" value="<?php echo $NFC_FIRST ?>"></input></td>
			<td align="center" style="font-weight:bold;">Half<br><input type="text" name="NFC_2" size="5" maxlength="2" value="<?php echo $NFC_HALF ?>"></input></td>
			<td align="center" style="font-weight:bold;">Third<br><input type="text" name="NFC_3" size="5" maxlength="2" value="<?php echo $NFC_THIRD ?>"></input></td>
			<td align="center" style="font-weight:bold;">Final<br><input type="text" name="NFC_4" size="5" maxlength="2" value="<?php echo $NFC_FINAL ?>"></input></td>
		</tr>
		<tr>
			<td align="right" style="color:#db2824; font-weight:bold"><?php echo $AFC_TEAM ?></td>
			<td style="font-weight:bold;"><input type="text" name="AFC_1" size="5" maxlength="2" value="<?php echo $AFC_FIRST ?>"></input></td>
			<td style="font-weight:bold;"><input type="text" name="AFC_2" size="5" maxlength="2" value="<?php echo $AFC_HALF ?>"></input></td>
			<td style="font-weight:bold;"><input type="text" name="AFC_3" size="5" maxlength="2" value="<?php echo $AFC_THIRD ?>"></input></td>
			<td style="font-weight:bold;"><input type="text" name="AFC_4" size="5" maxlength="2" value="<?php echo $AFC_FINAL ?>"></input></td>
		</tr>
		<tr>
			<td align="center" colspan="5">
				<input type="submit" name="addscores" value="Submit"></input>
			</td>
		</tr>
	</table>
	</form>
<?php
}
?>

<p>
<table width="50%" style="font-family: Verdana,Ariel; font-size: 12px; border: #009900 1px solid">
<tr><td colspan="4" align="center"><strong>The Payout:</strong></td></tr>
<tr>
<td>
<li>End of first quarter: </li>
<li>End of second quarter: </li>
<li>End of third quarter: </li>
<li>Final Score: </li>
</td>
<td>
<dt><strong><font color="#232B85"><?=$NFC_FIRST?></font> &nbsp;&nbsp;&nbsp; <font color="#DB2824"><?=$AFC_FIRST?></font></strong></dt>
<dt><strong><font color="#232B85"><?=$NFC_HALF?></font> &nbsp;&nbsp;&nbsp; <font color="#DB2824"><?=$AFC_HALF?></font></strong></dt>
<dt><strong><font color="#232B85"><?=$NFC_THIRD?></font> &nbsp;&nbsp;&nbsp; <font color="#DB2824"><?=$AFC_THIRD?></font></strong></dt>
<dt><strong><font color="#232B85"><?=$NFC_FINAL?></font> &nbsp;&nbsp;&nbsp; <font color="#DB2824"><?=$AFC_FINAL?></font></strong></dt>
</td>
<td >
<dt><?=$WIN_FIRST?>%</dt>
<dt><?=$WIN_SECOND?>%</dt>
<dt><?=$WIN_THIRD?>%</dt>
<dt><?=$WIN_FINAL?>%</dt>
</td>
<td width="15%" align="right" style="font-weight: 600px">
<dt><strong>$<?=$FIRST?></strong></dt>
<dt><strong>$<?=$SECOND?></strong></dt>
<dt><strong>$<?=$THIRD?></strong></dt>
<dt><strong>$<?=$FINAL?></strong></dt>
</td>
</tr>
</table>
</p>
<?php
echo "<p>";

// Display only on date of superbowl or later
// sb_date in the VNSB_settings must be in this format (February 3, 2013) for this to work correctly 
if ( (strtotime(trim($SB_DATE)) <= strtotime(date("F j, Y"))) && ( $NFC_FIRST && $AFC_FIRST ) ) { 

	echo ('<a href="'.$REQUEST_URI.'?m=yes">email winners</a>'); 

	$cnt=0;
	for ($y=1; $y<=10; $y++) {	
		for ($x=1; $x<=10; $x++) {
			if ($cnt<10) { $square = "0".$cnt; } else { $square = $cnt; }
			if ( ($NFC[$x] == substr($NFC_FIRST, -1)) && ($AFC[$y] == substr($AFC_FIRST, -1)) && ( $NFC_FIRST && $AFC_FIRST ) ) { 
				echo "<p>1st Quarter Winner ($NFC[$x],$AFC[$y]) &nbsp;&nbsp;&nbsp; Square #$square (".$NAME[$square].")</p>"; 
				mysql_query("UPDATE VNSB_squares SET FIRST='1' WHERE SQUARE='$square' LIMIT 1");
				if ( $EMAIL=="yes" ) { notify_email($EMAIL[$square]); }
			}
			if ( ($NFC[$x] == substr($NFC_HALF, -1)) && ($AFC[$y] == substr($AFC_HALF, -1)) && ( $NFC_HALF && $AFC_HALF ) ) { 
				echo "<p>Halftime Winner ($NFC[$x],$AFC[$y]) &nbsp;&nbsp;&nbsp; Square #$square (".$NAME[$square].")</p>"; 
				mysql_query("UPDATE VNSB_squares SET HALF='1' WHERE SQUARE='$square' LIMIT 1");
				if ( $EMAIL=="yes" ) { notify_email($EMAIL[$square]); }
			}
			if ( ($NFC[$x] == substr($NFC_THIRD, -1)) && ($AFC[$y] == substr($AFC_THIRD, -1)) && ( $NFC_THIRD && $AFC_THIRD ) ) { 
				echo "<p>3rd Quarter Winner ($NFC[$x],$AFC[$y]) &nbsp;&nbsp;&nbsp; Square #$square (".$NAME[$square].")</p>"; 
				mysql_query("UPDATE VNSB_squares SET THIRD='1' WHERE SQUARE='$square' LIMIT 1");
				if ( $EMAIL=="yes" ) { notify_email($EMAIL[$square]); }
			}
			if ( ($NFC[$x] == substr($NFC_FINAL, -1)) && ($AFC[$y] == substr($AFC_FINAL, -1) && ( $NFC_FINAL && $AFC_FINAL )) ) { 
				echo "<p>Final Winner ($NFC[$x],$AFC[$y]) &nbsp;&nbsp;&nbsp; Square #$square (".$NAME[$square].")</p>"; 
				mysql_query("UPDATE VNSB_squares SET FINAL='1' WHERE SQUARE='$square' LIMIT 1");
				if ( $EMAIL=="yes" ) { notify_email($EMAIL[$square]); }
			}
			$cnt++;
		}
	}
}

echo "</p>";
?>
<p><br><br>
  <table width="50%" border="0" cellspacing="0" cellpadding="0" style="font-family: verdana, arial; font-size: 12px">
	<tr>
	<td width="33%"><a href="<?=$superbowlURL?>" title="Administrator">Home</a></td>
	<td width="34%" align="center"><a href="./admin.php" title="Administrator">Admin</a></td>
	<td width="33%" align="right"><a href="adminlogout.php" title="Admin logout">Logout</a></td>
	</tr>
  </table>
</p>
					
<?php require "footer.inc"; ?>
