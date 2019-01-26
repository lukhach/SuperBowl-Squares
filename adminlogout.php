<?php 
	session_start();
?>

<HTML>
<head>
<title>ADMIN - Logout</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>

	 <H2>Logout</H2>
	 <?php
		// if the user is logged in, log them out
		if ($_SESSION['VNSB']) {
			unset($_SESSION['VNSB']);
			echo "You are now logged out.";
			echo "<br><br><em>Don't forget to close your brower when you are done!!!</em>";
	
		// if the user isnt logged in, let them know that
		} else {
			echo "You haven't even logged in yet.";
		}
	 ?>

	 <p><a href="index.php">Home</a></p>
	 <p><a href="admin.php">Admin</a></p>

</center>
</body>
</html>
