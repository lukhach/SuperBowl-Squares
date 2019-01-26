
###########################################################################
 VNSB Squares            
 Version:       4.2     
 Released:      1/23/13       
 Written:       www.VNLISTING.com         
 Demo:          http://vnlisting.homelinux.com/superbowl     
 Forum:         http://forum.vnlisting.com/
 Email:         admin@vnlisting.com

 This is a free script released under the (gpl.txt) GENERAL PUBLIC LICENSE 
 In addition, you agree to:					
	1. Not to make any financial gain from this script.
	2. Not to distribution this scrip as your own.
	3. If you make any improvement to this script, you must send 
		a copy to admin@vnlisting.com.			
	4. ALL acknowledgements must remain as it.	
	5. A link back to www.vnlisting.com is required.
	6. For $25 donation, you can remove links back to us, and get supports.
###########################################################################

For a small donation I can help ::::::::::::::::::::::::::::::::::::::::

1.  Setup/install this script on your server.
2.  Setup/install this script on our server.  You will get a seperate
    URL for your group to use without having to by a domain name or 
	pay for posting else where.
3.  Most support can be found on the forum, But if you still need help
    let me know.
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::


This scripts will require some knowledge of PHP and MySQL.  

Requirements:
- Good knowledge of PHP and MySQL
- PHP and MySQL
- Mail configuration for PHP "mail" function, for email notification to work
- This was tested with PHP 5.1.2, mySQL 5.0.18, Firefox2, and IE7

How to install:
1. Unzip VNSBsquares_v40.zip script to your local computer. 
2. Change data in config.inc.php to reflect your mySQL data and rename it to config.php
3. Create a database in your MySQL as in config.php
4. Import superbowl.sql to your newly created MySQL database
5. Make changes to VNSB_settings as needed.
6. Upload all files to your web server.


Usage:
1. On your browser, type "www.yourdomain.com/superbowl" or wherever you uploaded the files
2. Click on any "AVAILABLE" squares to make the selection.  Click "Submit" when all squares are selected.
3. Emails will be send to the Admin and the user when selection is made.


Administrator:
1. Use "www.yourdomain.com/superbowl/admin.php" to approve/confirm each selected square.
2. Email will be send to user and admin for each confirmation.
3. When all squares are selected, run randomnumber.php to randomly generate numbers.
4. Email to everyone when random numbers have been generated.
 
===================== CHANGES FROM 2.0 to 3.0 =================================

Bugs fixed:
1. In generals, it's much more user/admin friendly.  Clean up a lot of coding styles.
2. The square will be locked when the first person select it.  This will eliminate the problem 
   with two persons register for the same square at the approximate same time.
3. Selected squares cannot be override by some sneaky person by direct access to the square
   via the URL.  (Don't worry if you don't know what this mean).   
4. Admin only required to login once instead of verifying admin email and password each confirmation.
5. Random number selection is now require login.

===================== CHANGES FROM 3.0 to 4.0 =================================
1.  Move superbowl logo to the database for easy change each year
2.  User will be able to make multiple picks before enter information
3.  Removed Admin link from user pages

===================== CHANGES FROM 4.0 to 4.1 =================================
1.  Admin above to confirm all squares from the same users at once.
2.  Improve email sending header
3.  Improve session header

===================== CHANGES FROM 4.1 to 4.2 =================================
1.  Add scores, winner indications, email winners

TODO:
- Auto install of database and scripts
- Paypal implementation