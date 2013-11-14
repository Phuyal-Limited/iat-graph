<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<style type="text/css">
		h2{
			text-align:center !important;
			font-size: 3em !important;
			font-weight:bold !important;
		}
		p{
			text-align:center;
			font-size: 2em;
		}
    body {
      padding-top: 50px;
    }
	</style>
	
	<!-- Scripts for Google Charts -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- End of Scripts for Google Charts -->

    <title>Our Progress in Graphs</title>
  </head>
  <?php
	include("connect.php"); //includes the file which connects to the database
	$url = 'http://nagios-prod-01.iatlimited.com/epoints-1/monthlychart.php'; //url of the page to be refreshed. 
	$refreshRate = 600; //in seconds
	header("Refresh:".$refreshRate.";url='".$url."'"); //refreshes the page within the given time to the given url
  ?>
  <body>
  <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Daily Chart</a></li>
            <li><a href="weeklychart.php">Weekly Chart</a></li>
            <li class="active"><a href="monthlychart.php">Monthly Chart</a></li>
          </ul>
        </div>
      </div>
    </div><!--/.nav-collapse -->
	<div class="jumbotron">
      <div class="container">
        <h1>Our Progress In Graphs</h1>
      </div>
    </div>
    <div class="container">
    	<div class="row">
    		<div class="col-lg-4">
    		</div>
    		<div class="col-lg-4">
    		<?php 
          $result = mysql_query("SELECT * FROM `total_users` ORDER BY `id` DESC");
          $row = mysql_fetch_array($result);
          $last_update = $row['time'];
          echo "Last Update was Made at ".$last_update;
        ?>
    		</div>
    		<div class="col-lg-4">
			</div>
    	</div>
    </div>
     
		<?php //Query 1
      
      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `total_users` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `total_users` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Users'],
          <?php
          $num_of_data = $count_monthdays;
            
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total Number of Users'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_1m'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_1m" style="width: 100%; height: 100%;"></div>
    </div>
    
    <?php //Query 2

      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `validated_users` WHERE `month`='$current_month'", $db2) or die("error 0");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `validated_users` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Members'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total Number of members who have validated their account'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_2m'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_2m" style="width: 100%; height: 100%;"></div>
    </div>
    </div>

    <?php //Query 3
  
      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
     
      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `issued_epoints` WHERE `month`='$current_month'", $db2) or die("error0");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `issued_epoints` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'ePoints'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total Number of epoints issued.'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_3m'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_3m" style="width: 100%; height: 100%;"></div>
    </div>

		<?php //Query 4

      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `users_from_epoints` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `users_from_epoints` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Members'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total number of users registered from Site www.epoints.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_4m'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_4m" style="width: 100%; height: 100%;"></div>
    </div>
    </div>

		<?php //Query 5
    
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');      

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `users_from_bestforfilm` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `users_from_bestforfilm` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Users'],
          <?php
           $num_of_data = $count_monthdays; 
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total number of users registered from Site www.bestforfilm.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_5m'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_5m" style="width: 100%; height: 100%;"></div>
    </div>

		<?php //Query 6

			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');     

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `users_from_ivillage` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `users_from_ivillage` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Users'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total number of users registered from Site www.ivillage.co.uk'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_6m'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_6m" style="width: 100%; height: 100%;"></div>
    </div>
    </div>
    
		<?php //Query 7
   
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');     

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `users_from_pickourteam` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `users_from_pickourteam` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Users'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total number of users registered from Site www.pickourteam.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_7m'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_7m" style="width: 100%; height: 100%;"></div>
    </div>

		<?php //Query 8

			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `users_from_ihubbub` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `users_from_ihubbub` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Users'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total number of users registered from Site www.ihubbub.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_8m'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_8m" style="width: 100%; height: 100%;"></div>
    </div>
    </div>

		<?php //Query 9

			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `users_from_babyworld` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `users_from_babyworld` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Users'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total number of users registered from Site www.babyworld.co.uk'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_9m'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_9m" style="width: 100%; height: 100%;"></div>
    </div>
	
		<?php //Query 10

			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `bff_like` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `bff_like` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'ePoints'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total epoints for BFF Like'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_10m'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_10m" style="width: 100%; height: 100%;"></div>
    </div>
    </div>
		
    <?php //Query 11

			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `epoints_like` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `epoints_like` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'ePoints'],
          <?php
            $num_of_data = $count_monthdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total epoints for epoints Like.'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_11m'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_11m" style="width: 100%; height: 100%;"></div>
    </div>

  <?php //Query 12

			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');      

      //monthly chart
      $result = mysql_query("SELECT DISTINCT `day` FROM `total_like` WHERE `month`='$current_month'", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);
      $count_monthdays = 0;
      
      for ($i=1; $i <= $num_of_data; $i++) {
        $result = mysql_query("SELECT * FROM `total_like` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['day'];
        $number[$i] = $row['number'];
        $count_monthdays++;
        if ($current_day == 0) {
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'ePoints'],
          <?php
            
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $time[$count]; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Monthly Total epoints for Likes'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_12m'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_12m" style="width: 100%; height: 100%;"></div>
    </div>
    </div>
  </body>
</html>