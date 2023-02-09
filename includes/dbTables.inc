<?php
# Creating all tables needed for this project.
# Any existing tables will be drop and recreate with default values
#=============================================================================

# Connect to database and return handle
function dbConnection() {

    if (file_exists("includes/config.inc")) {
        $notJSON = file_get_contents("includes/config.inc");
        $tempJSON = json_decode($notJSON);

        $conn = mysqli_connect($tempJSON->db_host, $tempJSON->db_user, $tempJSON->db_pass, $tempJSON->db_name);

        if (!$conn) {
            die("Connection failed!!!<br>".mysqli_connect_error());
        } else {
            return $conn;
       }

    } else {
        echo "ERROR:  Unable to connect to ".$tempJSON->db_host."<br>".mysqli_error($conn);
        return FALSE;
    }
}
 
# Table structure for table `VNSB_numbers`
function create_VNSB_numbers($conn) {
	$sql = "DROP TABLE IF EXISTS `VNSB_numbers`;";
	if (!mysqli_query($conn, $sql)) {
	    echo "ERROR:  Unable to DROP `VNSB_numbers`! <br>".mysqli_error($conn);
	}

	$sql = "CREATE TABLE IF NOT EXISTS `VNSB_numbers` (
	  `NFC` tinyint(2) DEFAULT NULL,
	  `AFC` tinyint(2) DEFAULT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Randomly picked numbers';
	";
	if (!mysqli_query($conn, $sql)) {
	    echo "ERROR:  Unable to CREATE `VNSB_numbers`! <br>".mysqli_error($conn);
	} else {
            echo "<p>`VNSB_numbers` created successfully.</p>";
        }
}
 
# Table structure for table `VNSB_scores`
function create_VNSB_scores($conn) {
        $sql = "DROP TABLE IF EXISTS `VNSB_scores`;";
	if (!mysqli_query($conn, $sql)) {
	    echo "ERROR:  Unable to DROP `VNSB_scores`! <br>".mysqli_error($conn);
	}

	$sql = "CREATE TABLE IF NOT EXISTS `VNSB_scores` (
          `ID` tinyint(2) NOT NULL,
	  `NFC_FIRST` varchar(2) DEFAULT NULL,
	  `AFC_FIRST` varchar(2) DEFAULT NULL,
	  `NFC_HALF` varchar(2) DEFAULT NULL,
	  `AFC_HALF` varchar(2) DEFAULT NULL,
	  `NFC_THIRD` varchar(2) DEFAULT NULL,
	  `AFC_THIRD` varchar(2) DEFAULT NULL,
	  `NFC_FINAL` varchar(2) DEFAULT NULL,
	  `AFC_FINAL` varchar(2) DEFAULT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;
	";
	if (!mysqli_query($conn, $sql)) {
	    echo "ERROR:  Unable to CREATE `VNSB_scores`! <br>".mysqli_error($conn);
	} else {
            echo "<p>`VNSB_scores` created successfully.</p>";
        }
}

# Table structure for table `VNSB_squares`
function create_VNSB_squares($conn) {
	$sql = "DROP TABLE IF EXISTS `VNSB_squares`;";
	if (!mysqli_query($conn, $sql)) {
	    echo "ERROR:  Unable to DROP `VNSB_squares`! <br>".mysqli_error($conn);
	}

	$sql = "CREATE TABLE IF NOT EXISTS `VNSB_squares` (
	  `SQUARE` varchar(15) NOT NULL DEFAULT '',
	  `NAME` varchar(30) NOT NULL DEFAULT 'AVAILABLE',
	  `EMAIL` varchar(45) DEFAULT NULL,
	  `NOTES` text,
	  `DATE` datetime DEFAULT CURRENT_TIMESTAMP,
	  `CONFIRM` tinyint(1) NOT NULL DEFAULT '0',
	  `FIRST` tinyint(1) NOT NULL DEFAULT '0',
	  `HALF` tinyint(1) NOT NULL DEFAULT '0',
	  `THIRD` tinyint(1) NOT NULL DEFAULT '0',
	  `FINAL` tinyint(1) NOT NULL DEFAULT '0',
	  UNIQUE KEY `SQUARE` (`SQUARE`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Super Bowl Squares';
	";
	if (!mysqli_query($conn, $sql)) {
	    echo "ERROR:  Unable to CREAT `VNSB_squares`! <br>".mysqli_error($conn);
	} else {

	    for ($l=0; $l < 100; $l++) {
	        $sql = "INSERT INTO `VNSB_squares` VALUES ('".sprintf("%02d", $l)."', 'AVAILABLE', NULL, NULL, NULL, 0, 0, 0, 0, 0);";
                if (!mysqli_query($conn, $sql)) {
	            echo "ERROR:  Unable to populate squares! <br>".mysqli_error($conn);
	        }
	    }
            echo "<p>`VNSB_squares` created successfully.</p>";
        }
}

# Table structure for table `VNSB_settings`
function create_VNSB_settings() {
   
    $VERSION = "5.0";
    if (file_exists("includes/config.inc")) {
        $notJSON = file_get_contents("includes/config.inc");
        $tempJSON = json_decode($notJSON);

        $conn = mysqli_connect($tempJSON->db_host, $tempJSON->db_user, $tempJSON->db_pass, $tempJSON->db_name);

        if (!$conn) {
            die("Connection failed!!!<br>".mysqli_connect_error());
        } else {

	    $sql = "DROP TABLE IF EXISTS `VNSB_settings`;";
	    if (!mysqli_query($conn, $sql)) {
	        echo "ERROR:  Unable to DROP `VNSB_settings`! <br>".mysqli_error($conn);
	    }

	    $sql = "CREATE TABLE IF NOT EXISTS `VNSB_settings` (
		  `sb_date` varchar(30) NOT NULL DEFAULT 'Sunday, February 7, 2021',
                  `sb_time` varchar(30) NOT NULL DEFAULT '3:30 PM',
		  `sb_logo` varchar(30) DEFAULT NULL,
		  `NFC_team` varchar(30) DEFAULT NULL,
		  `NFC_logo` varchar(80) DEFAULT NULL,
		  `AFC_team` varchar(30) DEFAULT NULL,
		  `AFC_logo` varchar(80) DEFAULT NULL,
		  `Bet` varchar(5) NOT NULL DEFAULT '5.00',
		  `Win_first` tinyint(2) NOT NULL DEFAULT '20',
		  `Win_second` tinyint(2) NOT NULL DEFAULT '25',
		  `Win_third` tinyint(2) NOT NULL DEFAULT '20',
		  `Win_final` tinyint(2) NOT NULL DEFAULT '35',
		  `Version` char(3) NOT NULL DEFAULT '5.0',
		  `Admin_email` varchar(80) NOT NULL DEFAULT 'admin@email.com',
		  `Admin_pwd` varchar(80) NOT NULL DEFAULT 'password',
		  PRIMARY KEY (`sb_date`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Setting for VN SuperBowl Squares';
	    ";
	    if (!mysqli_query($conn, $sql)) {
	        echo "ERROR:  Unable to CREATE `VNSB_settings`! <br>".mysqli_error($conn);
	    } else {
	        echo "<p>`VNSB_settings` created successfully.</p>";
	    }

	    # populate table
	    $sql = "INSERT INTO `VNSB_settings` VALUES ('".$tempJSON->sb_date."', '".$tempJSON->sb_time."', '".$tempJSON->sb_logo."', '".$tempJSON->nfc_champ."', '".$tempJSON->nfc_champ_logo."', '".$tempJSON->afc_champ."', '".$tempJSON->afc_champ_logo."', '".$tempJSON->cost."', '".$tempJSON->first."', '".$tempJSON->second."', '".$tempJSON->third."', '".$tempJSON->final."', '".$VERSION."', '".$tempJSON->admin_email."', '".md5($tempJSON->admin_pass)."');";
#            echo $sql; 
	    if (!mysqli_query($conn, $sql)) {
	        echo "ERROR:  Unable to populate 'VNSB_settings's! <br>".mysqli_error($conn);
            }
        }
#        $mysqli_close($conn);

    } else {
	echo "ERROR: Configuration file does not existi or required fields are missing!";
    }
}

# databse
function dbInquery() {

    if (file_exists("includes/config.inc")) {
        # Read back json file
        $myJSON = file_get_contents("includes/config.inc");
        $notJSON = json_decode($myJSON);
        $db_host = $notJSON->db_host;
        $db_user = $notJSON->db_user;
        $db_pass = $notJSON->db_pass;
        $db_name = $notJSON->db_name;
    } else {
       $db_host = "localhost";
       $db_user = "vnsb";
       $db_pass = "vnlisting";
       $db_name = "superbowl";
    } 

    echo "<p>Minimum PHP version 5.5.9 recommeneded.<br>";
    if (version_compare(PHP_VERSION, '5.5.9') >= 0) {
        echo "Your PHP version: <b>".PHP_VERSION."</b></p>"; 
    } else {
        echo "Your PHP version: <b>".PHP_VERSION."</b><br>DOES NOT MEET MINIMUM RECOMENDATION</p>";
    }

    echo('      
	<form method="post" action="">
	<fieldset style="width:450px; border: #6699ff 1px solid"><legend style="color:#6699ff">&nbsp; mySQL &nbsp;</legend>
	<table cellpadding="0" cellspacing="10" style="width:450px">
	    <tr><td>Hostname:</td>
		<td><input type="text" name="db_host" size="40" maxlength="40" value="'. $db_host. '"></input>
	    </td></tr>
	    <tr><td>Username:</td>
		<td><input type="text" name="db_user" size="40" maxlength="40" value="'. $db_user. '"></input>
	    </td></tr>
	    <tr><td>Password:</td>
		<td><input type="password" name="db_pass" size="40" maxlength="40" value"'. $db_pass. '"></input>
	    </td></tr>
	    <tr><td>Database:</td>
		<td><input type="text" name="db_name" size="40" maxlength="40" value="'. $db_name. '"></input>
	    </td></tr>
            <tr><td colspan="2"><p align="center"><input type="submit" name="DBsubmit" value="Submit"></input></p> </td></tr>
	</table>
	<p><u>Warning:</u>  Any existing databse with the same name will be deleted!</p>
	</fieldset>
        </form>
    ');
}

# Admin
function adminInquery() {
   
    if (file_exists("includes/config.inc")) {
        # Read back json file
        $myJSON = file_get_contents("includes/config.inc");
        $notJSON = json_decode($myJSON);
        $admin_email = $notJSON->admin_email;
        $admin_pass = $notJSON->admin_pass;
        $site_url = $notJSON->site_url;
    } else {
       $admin_email = "admin@email.com";
       $admin_pass = "password";
       $site_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].trim($_SERVER['PHP_SELF'], "setup.php");
    }

    echo('
        <form method="post" action="">
	<fieldset style="width:450px; border: #6699ff 1px solid"><legend style="color:#6699ff">&nbsp; Admin &nbsp;</legend>
	<table cellpadding="0" cellspacing="10" style="width: 450px">
	    <tr><td width="30%">Site URL:</td>
		<td width="70%"><input type="url" name="site_url" size="30" maxlength="80" value="'. $site_url .'"></input>
	    </td></tr>
	    <tr><td>Admin Email:</td>
		<td><input type="email" name="admin_email" size="30" maxlength="80" value="'. $admin_email .'"></input>
	    </td></tr>
	    <tr><td>Admin Password:</td>
		<td><input type="password" name="admin_pass" size="30" maxlength="40" value"'. $admin_pass .'"></input>
	    </td></tr>
            <tr><td colspan="2"><p align="center"><input type="submit" name="ADsubmit" value="Submit"></input></p> </td></tr>
	</table>
	</fieldset>
        </form>
    ');
}

# configuration
function configInquery() {

    if (file_exists("includes/config.inc")) {
        # Read back json file
        $myJSON = file_get_contents("includes/config.inc");
        $notJSON = json_decode($myJSON);
        $sb_logo = $notJSON->sb_logo;
        $afc_champ = $notJSON->afc_champ;
        $afc_champ_logo = $notJSON->afc_champ_logo;
        $nfc_champ = $notJSON->nfc_champ;
        $nfc_champ_logo = $notJSON->nfc_champ_logo;
        $sb_date = $notJSON->sb_date;
        $sb_time = $notJSON->sb_time;
        $cost = $notJSON->cost;
        $first = $notJSON->first;
        $second = $notJSON->second;
        $third = $notJSON->third;
        $final = $notJSON->final;
        $cost_total = (float)$cost * 100;
        $first_value = ((int)$first * $cost_total) / 100;
        $second_value = ((int)$second * $cost_total) / 100;
        $third_value = ((int)$third * $cost_total) / 100;
        $final_value = ((int)$final * $cost_total) / 100;
    } else {
        $sb_logo = "images/sb_logo.jpg";
        $afc_champ = "AFC";
        $afc_champ_logo = "images/AFC_logo.gif";
        $nfc_champ = "NFC";
        $nfc_champ_logo = "images/NFC_logo.gif";
        $sb_date = "Sunday, February 7, 2021";
        $sb_time = "3:30PM";
        $cost = "5";
        $first = "20";
        $second = "25";
        $third = "20";
        $final = "35";
        $cost_total = (int)$cost * 100;
        $first_value = ((int)$first * $cost_total) / 100;
        $second_value = ((int)$second * $cost_total) / 100;
        $third_value = ((int)$third * $cost_total) / 100;
        $final_value = ((int)$final * $cost_total) / 100;
    }

    echo('
        <form method="post" action="">
	<fieldset style="width:450px; border: #6699ff 1px solid"><legend style="color:#6699ff">&nbsp; NFL &nbsp;</legend>
	<table cellpadding="0" cellspacing="10" style="width: 450px">
            <tr><td>Super Bowl Logo:</td>
                <td><input type="text" name="sb_logo" size="30" maxlength="80" value="'. $sb_logo .'"></input>
            </td></tr>
	    <tr><td>AFC Champion:</td>
		<td><input type="text" name="afc_champ" size="30" maxlength="30" value="'. $afc_champ .'"></input>
	    </td></tr>
            <tr><td>AFC Logo:</td>
                <td><input type="text" name="afc_champ_logo" size="30" maxlength="80" value="'. $afc_champ_logo .'"></input>
            </td></tr>
            <tr><td>NFC Champion:</td>
                <td><input type="text" name="nfc_champ" size="30" maxlength="30" value="'. $nfc_champ .'"></input>
            </td></tr>
	    <tr><td>NFC Logo:</td>
		<td><input type="text" name="nfc_champ_logo" size="30" maxlength="80" value="'. $nfc_champ_logo .'"></input>
	    </td></tr>
	    <tr><td>Super Bowl Date:</td>
		<td><input type="date" name="sb_date" size="30" maxlength="30" value="'. $sb_date .'"></input>
	    </td></tr>
	    <tr><td>Super Bowl Time:</td>
		<td><input type="time" name="sb_time" size="30" maxlength="30" value="'. $sb_time .'"></input>
	    </td></tr>
	</table>
	</fieldset>

	<fieldset style="width:450px; border: #6699ff 1px solid"><legend style="color:#6699ff">&nbsp; Payout &nbsp;</legend>
	<table cellpadding="0" cellspacing="10" style="width: 450px">
	    <tr><td>Cost per square:</td>
		<td>$ <input type="text" name="cost" size="5" maxlength="5" value="'. $cost .'"></input> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ <input type="text" name="cost_total" size="5" maxlength="5" value="'. $cost_total .'" disabled></input>
	    </td></tr>
	    <tr><td>1st quarter:</td>
		<td>% <input type="text" name="first" size="5" maxlength"5" value="'. $first .'"></input> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ <input type="text" name="first_value" size="5" maxlength="5" value="'. $first_value .'" disabled></input>
	    </td></tr>
	    <tr><td>2nd quarter:</td>
		<td>% <input type="text" name="second" size="5" maxlength="5" value="'. $second .'"></input> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ <input type="text" name="second_value" size="5" maxlength="5" value="'. $second_value .'" disabled></input>
	    </td></tr>
	    <tr><td>3rd quarter:</td>
		<td>% <input type="text" name="third" size="5" maxlength="5" value="'. $third .'"></input> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ <input type="text" name="third_value" size="5" maxlength="5" value="'. $third_value .'" disabled></input>
	    </td></tr>
	    <tr><td>Final:</td>
		<td>% <input type="text" name="final" size="5" maxlength="5" value="'. $final .'"></input> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ <input type="text" name="final_value" size="5" maxlength="5" value="'. $final_value .'" disabled></input>
	    </td></tr>
	</table>
	</fieldset>

	<p align="center"><input type="submit" name="VNsubmit" value="Submit"></input></p>
	</form>
    ');
}

?>
