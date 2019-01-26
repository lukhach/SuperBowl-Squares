<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installation and usage instructions 
-->


<?php 
require_once('config.php'); 
require "header.inc";

//$square = $_POST['square'];
$sqTotal = $_POST["sqTotal"];
for ($i=1;$i<=$sqTotal;$i++) {
$sqSelect[$i] = $_POST["square_$i"];
//echo $sqSelect[$i];
}

$name = $_POST['realname'];
$email = $_POST['email'];
$notes = $_POST['body'];
$date = date("Y-m-d h:i:s");
$confirm = $_POST['confirmation'];

for ($i=1;$i<=$sqTotal;$i++) {
$query="SELECT * FROM VNSB_squares WHERE SQUARE='".$sqSelect[$i]."'";
$result = mysql_query($query);
if (!$result) {
	//echo mysql_error();
	echo "\n\n\t***** Invalid square selected *****\n\n";
	echo "<a href='javascript:onClick=history.go(-2);'>Back</a>";
	exit;
} else {
	$record = mysql_fetch_assoc($result);
}
}
//continue only if the square is available
if ($record['DATE'] == "0000-00-00 00:00:00") {


//check for required fields
for ($i=1;$i<=$sqTotal;$i++) {
if (($sqSelect[$i] >= 00 OR $sqSelect[$i] < 100) AND $name != '' AND $email != '') {

	$query="UPDATE VNSB_squares SET NAME='".$name."', EMAIL='".$email."', NOTES='".$notes."', DATE='".$date."', CONFIRM='".$confirm."' WHERE SQUARE='".$sqSelect[$i]."' LIMIT 1";
	$result = mysql_query($query);
	if (!$result) {
		echo mysql_error();
		echo "<BR>Sorry, Technical problem occurred... your selection was not added.<br><br> Email this problem to <a href=\"mailto:".$ADMIN_EMAIL."\">".$ADMIN_EMAIL."</a>";
		exit;
	}
} else {
	echo "<p align='center'><br/><font color='#ff0000', size='3'>Required fields are missing!</font><br/><br/><a href='javascript:onClick=history.go(-1);'>Back</a></p>";
	exit;
}
}

//email
//$headers = "From: $ADMIN_EMAIL\r\nBcc: $ADMIN_EMAIL\r\n";
$headers = "From: $ADMIN_EMAIL"."\r\n"."Bcc: $ADMIN_EMAIL";
function notify_admin ($mailto, $mailmessage, $mail_headers)
{
	mail("$mailto", "Super Bowl Squares", "$mailmessage", "$mail_headers");
}

$selectedSQUARES="";
for ($i=1;$i<=$sqTotal;$i++) { $selectedSQUARES .= $sqSelect[$i]." "; }
?>

<table width="60%" cellspacing="0" cellpadding="0" style="border: #FFCC99 1px solid; font-family:verdana, arial; font-size:12px; font-color:#0033cc">
	<tr>
		<td align="center">
			<p><font size="4" color="#ffcc00"><h2>GOOD LUCK</h2></font></p>				
			<p>Your request has been recieved and an email was sent to your email address given.</p>
			<p>The square(s) <strong><font color="#ff0000"><?=$selectedSQUARES?></font></strong> is(are) temporary reserved in your name "<font color="#ff0000"><?=$name?></font>", pending confirmation.</p>
			<p>IF YOUR PAYMENT CAN NOT BE VERIFIED WITHIN 24 HOURS, YOU WILL LOOSE THE SQUARE(S).</p>								
			<p>Good Luck and enjoy the game.</p>
			<p>The Commissioner</p>
			<!-- <p>You may make your payment thru Paypal if you preferred. <br/>There will be an additional $1 for each payment up to $20 to cover the charges by Paypal.</p> -->
			<br/><br/>
		</td>
	</tr>
</table>

<p style="font-family: verdana, arial; font-size: 12px">
	<a href="<?=$superbowlURL?>" title="Online Superbowl Squares">Home</a>
</p>

<?php
$bodyMessage = "\nREMINDER\r\n";
$bodyMessage .= "Square(s) $selectedSQUARES is(are) temporary reserved in your name \"$name\", pending confirmation.\r\n";
$bodyMessage .= "IF YOUR PAYMENT CAN NOT BE VERIFIED WITHIN 24 HOURS, YOU WILL LOOSE THE SQUARE(S).\r\n\n";
$bodyMessage .= "Good Luck and enjoy the game.\r\n";
$bodyMessage .= "The Commissioner\r\n";
$bodyMessage .= "$superbowlURL\r\n\n";
//$bodyMessage .= "You may make your payment thru Paypal if you like. \rThere will be an additional $1 for each payment up to $20 to cover the charges by Paypal.\r\n";
$bodyMessage .= "\r\n\nNOTES TO ADMIN:\r\n";
$bodyMessage .= $notes."\r\n\n";

notify_admin($email,$bodyMessage,$headers);

require "footer.inc"; ?>

<?php
} else {
	echo "<p align='center'><font color='#ff0000', size='3'><b>$square</b> is NOT available!  Someone must have just selected that same square.<br/></font><br/>Please go <a href='javascript:onClick=history.go(-2);'>back</a> and select another square.</p>";
	exit;
}
?>