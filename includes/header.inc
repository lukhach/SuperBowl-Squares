<!-- 
www.vnlisting.com
Online Super Bowl Squares Script
Please read the "Readme.txt for license agreement, installation and usage instructions 
Version: 5.0 	2/7/2019
-->

<?php
$VERSION = "5.0";
$sql="SELECT * FROM VNSB_settings";
$result = mysqli_query($conn, $sql);
if ($record = mysqli_fetch_assoc($result)) {
	$SB_DATE = $record['sb_date'];
        $SB_TIME = $record['sb_time'];
	$SB_LOGO = $record['sb_logo'];
	$NFC_TEAM = $record['NFC_team'];
	$NFC_LOGO = $record['NFC_logo'];
	$AFC_TEAM = $record['AFC_team'];
	$AFC_LOGO = $record['AFC_logo'];
#	$VERSION = $record['Version'];
	$ADMIN_EMAIL = $record['Admin_email'];
	$ADMIN_PASSWORD = $record['Admin_pwd'];
	$ADMIN_VERIFY = $record['Admin_verify'];
	$BET = $record['Bet'];
	$WIN_FIRST = $record['Win_first'];
	$WIN_SECOND = $record['Win_second'];
	$WIN_THIRD = $record['Win_third'];
	$WIN_FINAL = $record['Win_final'];
	$FIRST = (100 * (int)$BET ) * ((int)$WIN_FIRST/100);
	$SECOND = (100 * (int)$BET ) * ((int)$WIN_SECOND/100);
	$THIRD = (100 * (int)$BET ) * ((int)$WIN_THIRD/100);
	$FINAL = (100 * (int)$BET ) * ((int)$WIN_FINAL/100);
} else {
	//echo mysql_error();
	echo "<br/>Sorry, Technical problem occurred... Can't read from database.<br><br> Please notify this site admin</a>";
	exit;
}
?>
<html>
<head>
<title>VNLISTING :: Online Super Bowl Squares v5.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="VNLISTING, superbowl squares, super bowl, nfl squares online, free softwares, free scripts, superbowl scripts"/>
<meta name="description" content="The one and only fun and free NFL Super Bowl Squares Online."/>
<meta name="robots" content="index,nofollow"/>
</head>
<body bgcolor="" link="#0033CC" vlink="#0033CC" alink="#CC0000" leftmargin="0" topmargin="10" marginwidth="0" marginheight="0">
<!--body bgcolor="#99CCFF" link="#0033CC" vlink="#0033CC" alink="#CC0000" leftmargin="0" topmargin="10" marginwidth="0" marginheight="0"-->
<center>
<p>
<table width="95%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="<?php echo $SB_LOGO?>" border="0" title="Super Bowl Squares"></td>
<td align="center"><h2><font color="#009900"><?php echo $SB_DATE?><br><?php echo $SB_TIME?></font></h2></td>
<td align="right"><img src="<?php echo $AFC_LOGO; ?>" border="0" title="<?php echo $AFC_TEAM; ?>">&nbsp;&nbsp; <b><font size="+2">vs</font></b> &nbsp;&nbsp;<img src="<?php echo $NFC_LOGO; ?>" border="0" title="<?php echo $NFC_TEAM; ?>"></td>
</tr>
</table>
<br/>
