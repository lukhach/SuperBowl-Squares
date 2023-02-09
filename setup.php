
<?php
# VNSB Super Bowl Squares Installation.

# Create a new database for this project.
# Copy all files to your server/host location.
# Run this file to start the installation and setup.
#========================================================
?>

<HTML>
<head>
<title>VNSB - Super Bowl Quares - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>

<p><a href="http://www.vnlisting.com/freescripts.php"><img src="images/VNLogo.gif"></a></p>
<p style="font-size:24px; font-weight:bold">Super Bowl Squares<br>Installation</p>


<?php
require("includes/dbTables.inc");

if ($_REQUEST['DBsubmit']) {

    if ($_POST['db_host'] && $_POST['db_user'] && $_POST['db_pass'] && $_POST['db_name']) {

        # Create connection
        $dbconn = mysqli_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']);
         if (!$dbconn) {
            die("ERROR:  Unable to connect to host!!!<br>".mysqli_connect_error());
        } else {
            # Create database
            $sql = "CREATE DATABASE IF NOT EXISTS ".$_POST['db_name'];
            if (!mysqli_query($dbconn, $sql)) {
                die("ERROR:  Unable to create new database!!!<br>".mysqli_connect_error());
            }
            mysqli_close($dbconn);
            sleep(2);

            # Create connection for tables         
            $conn = mysqli_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);

            if (!$conn) {
	        die("ERROR: Connection failed!!!<br>".mysqli_connect_error());
            } else {
         
	        echo "<p>Database connected sucessful!</p>";

                create_VNSB_squares($conn);
                create_VNSB_numbers($conn);
                create_VNSB_scores($conn);

                # Create json file with all configurations
                $dbObj->db_host = $_POST['db_host'];
                $dbObj->db_user = $_POST['db_user'];
                $dbObj->db_pass = $_POST['db_pass'];
                $dbObj->db_name = $_POST['db_name'];

                $myJSON = json_encode($dbObj, JSON_PRETTY_PRINT);

                if (file_exists("includes/config.inc")) {
                    $notJSON = file_get_contents("includes/config.inc");
                    $tempJSON = json_decode($notJSON);
                    $tempJSON->db_host = $_POST['db_host'];
                    $tempJSON->db_user = $_POST['db_user'];
                    $tempJSON->db_pass = $_POST['db_pass'];
                    $tempJSON->db_name = $_POST['db_name'];

                    $myJSON = json_encode($tempJSON, JSON_PRETTY_PRINT);
                }

                $fh = fopen("includes/config.inc", "w") or die ("Error opening file!");
                fwrite($fh, $myJSON);
                fclose($fh);

                # Admin
                adminInquery();
            }
        }

    } else {
	echo "ERROR:  Database information CANNOT be blank!!!";
    }

} elseif ($_REQUEST['ADsubmit']) {

    if ($_POST['site_url'] && $_POST['admin_email'] && $_POST['admin_pass']) {

	# Read back json file
        if (file_exists("includes/config.inc")) {
	    $notJSON = file_get_contents("includes/config.inc");
            $tempJSON = json_decode($notJSON);
            $tempJSON->site_url = $_POST['site_url'];
            $tempJSON->admin_email = $_POST['admin_email'];
            $tempJSON->admin_pass = $_POST['admin_pass'];
            $myJSON = json_encode($tempJSON, JSON_PRETTY_PRINT);

            $fh = fopen("includes/config.inc", "w") or die ("Error opening file!");
            fwrite($fh, $myJSON);
            fclose($fh);

            # Configuration
            configInquery();

        } else {
            echo "ERROR: Databse configuration file does not exist!";
        }
    } else {
        echo "ERROR: One or more field(s) is invalid or empty!!!";
    }

} elseif ($_REQUEST['VNsubmit']) {

    if ($_POST['afc_champ'] && $_POST['nfc_champ'] && $_POST['sb_date']) {

        # Read back json file
        if (file_exists("includes/config.inc")) {
            $notJSON = file_get_contents("includes/config.inc");
            $tempJSON = json_decode($notJSON);
            $tempJSON->sb_logo = $_POST['sb_logo'];
            $tempJSON->afc_champ = $_POST['afc_champ'];
            $tempJSON->afc_champ_logo = $_POST['afc_champ_logo'];
            $tempJSON->nfc_champ = $_POST['nfc_champ'];
            $tempJSON->nfc_champ_logo = $_POST['nfc_champ_logo'];
            # date format
            $sbDate = new DateTime($_POST['sb_date']);
            $date_of_week = date('l', strtotime($_POST['sb_date']));
            $tempJSON->sb_date = $date_of_week.", ".$sbDate->format('F d, Y');
            $tempJSON->sb_time = $_POST['sb_time'];
            $tempJSON->cost = $_POST['cost'];
            $tempJSON->first = $_POST['first'];
            $tempJSON->second = $_POST['second'];
            $tempJSON->third = $_POST['third'];
            $tempJSON->final = $_POST['final'];

            $myJSON = json_encode($tempJSON, JSON_PRETTY_PRINT);

            $fh = fopen("includes/config.inc", "w") or die ("Error opening file!");
            fwrite($fh, $myJSON);
            fclose($fh);

            # Populate settings
            create_VNSB_settings();

            # Done
            $notJSON = file_get_contents("includes/config.inc");
            $tempJSON = json_decode($notJSON);
            echo "Congratulation... You are ready to go!<br>";
            echo "<p><a href='".$tempJSON->site_url."'title='Super Bowl Squares'>".$tempJSON->site_url."</a></p>";
#            foreach ($tempJSON as $key=>$value) {
 #               echo $key. ": " .$value. "<br>";
  #          }
 
            echo "<p>>>>>> MAKE SURE YOU DELETE 'setup.php' BEFORE YOU GO LIVE <<<<<</p>";
            
        } else {
            echo "ERROR: Databse configuration file does not exist!";
        }
    } else {
        echo "ERROR: One or more field(s) is invalid or empty!!!";
    }

} else {
    # database
    dbInquery();
}

?>

</center>
</body>
</html>
<?php $mysqli_close($conn); ?>
