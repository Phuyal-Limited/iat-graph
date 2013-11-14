<?php
	include("connect.php");
	$current_time = date('H:i:s');
	$current_day = date('d');
	$current_month = date('m');
	$current_year = date('Y');

	//Query 1
	$res = mysql_query("SELECT count(*) from `User` where active = true;", $db1); //this is the query that needs to be run.
	$ary=mysql_fetch_array($res);
	$cnt=$ary[0];

	mysql_query("INSERT INTO `total_users` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database

	//Query 2
	$res = mysql_query("SELECT count(*) FROM `User` WHERE `verified` = 1 and active =true", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];

      mysql_query("INSERT INTO `validated_users` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database

    //Query 3
      $res = mysql_query("SELECT sum(confirmed+pending+redeemed+spent) from `User` where `active` = TRUE AND `verified` =TRUE ", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];

      mysql_query("INSERT INTO `issued_epoints` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database

      //Query 4
      $res = mysql_query("SELECT count(*) from User where `registrationSiteId` = 2", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];

		  mysql_query("INSERT INTO `users_from_epoints` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database

	//Query 5
	$res = mysql_query("SELECT count(*) from User where `registrationSiteId` = 3", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];

      mysql_query("INSERT INTO `users_from_bestforfilm` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database

      //Query 6
      $res = mysql_query("SELECT count(*) from User where `registrationSiteId` = 4", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];

      mysql_query("INSERT INTO `users_from_ivillage` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database


      //Query 7
      $res = mysql_query("SELECT count(*) from User where `registrationSiteId` = 5", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];
      mysql_query("INSERT INTO `users_from_pickourteam` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database


      //Query 8
      $res = mysql_query("SELECT count(*) from User where `registrationSiteId` = 6", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];
      mysql_query("INSERT INTO `users_from_ihubbub` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database

      
      //Query 9
       $res = mysql_query("SELECT count(*) from User where `registrationSiteId` = 7", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];

      mysql_query("INSERT INTO `users_from_babyworld` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database

      //Query 10
      $res = mysql_query("SELECT sum(delta) FROM `Points` where `tagId` =41", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];

      mysql_query("INSERT INTO `bff_like` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database


      //Query 11
      $res = mysql_query("SELECT sum(delta) FROM `Points` where `tagId` =5", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];
		  
      mysql_query("INSERT INTO `epoints_like` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database


      //Query 12
      $res = mysql_query("SELECT sum(delta) FROM `Points` where `tagId` = 5 or `tagId` = 41", $db1); //this is the query that needs to be run.
			$ary=mysql_fetch_array($res);
			$cnt=$ary[0];
		  
      mysql_query("INSERT INTO `total_like` VALUES ('', '$current_time', '$current_day', '$current_month', '$current_year', '$cnt')", $db2) or die("cant insert"); //inserting the value to ixwebhosting database


?>