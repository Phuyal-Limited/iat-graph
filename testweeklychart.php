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
	$url = 'http://nagios-prod-01.iatlimited.com/epoints-1/weeklychart.php'; //url of the page to be refreshed. 
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
            <li class="active"><a href="weeklychart.php">Weekly Chart</a></li>
            <li><a href="monthlychart.php">Monthly Chart</a></li>
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
     
		<?php 
      //Query 1
      //weekly chart

      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
       $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `total_users` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        $current_day--;
        if ($current_day == 0){
          break;
        }
      }

      switch ($current_month) {
        case '1':
          $this_month = "Jan";
          break;

        case '2':
          $this_month = "Feb";
          break;

        case '3':
          $this_month = "Mar";
          break;

        case '4':
          $this_month = "Apr";
          break;

        case '5':
          $this_month = "May";
          break;

        case '6':
          $this_month = "Jun";
          break;
        
        case '7':
          $this_month = "Jul";
          break;

        case '8':
          $this_month = "Aug";
          break;

        case '9':
          $this_month = "Sep";
          break;

        case '10':
          $this_month = "Oct";
          break;

        case '11':
          $this_month = "Nov";
          break;

        case '12':
          $this_month = "Dec";
          break;
        
        default:
          $this_month = " ";
          break;
      }

    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Users'],
      <?php
          $num_of_data = $count_weekdays;
            
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Weekly Total Number of Users'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_1w'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_1w" style="width: 100%; height: 100%;"></div>
    </div>
    <?php
      //Query 2
      //weekly chart
    
    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `validated_users` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
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
          $num_of_data = $count_weekdays;
            
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Weekly Total Number of members who have validated their account'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_2w'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_2w" style="width: 100%; height: 100%;"></div>
    </div>
    </div>
    
    <?php
      //Query 3
      //weekly chart
    
    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `issued_epoints` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'epoints'],
          <?php
          $num_of_data = $count_weekdays;
            
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Weekly Total Number of epoints issued.'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_3w'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_3w" style="width: 100%; height: 100%;"></div>
    </div>
    
    <?php
      //Query 4
      //weekly chart
    
    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `users_from_epoints` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
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
          $num_of_data = $count_weekdays;
            
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Weekly Total number of users registered from Site www.epoints.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_4w'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_4w" style="width: 100%; height: 100%;"></div>
    </div>
    </div>
    <?php
      //Query 5
      //weekly chart

    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `users_from_bestforfilm` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
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
          $num_of_data = $count_weekdays;
            
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'Weekly Total number of users registered from Site www.bestforfilm.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_5w'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_5w" style="width: 100%; height: 100%;"></div>
    </div>

    <?php
      //Query 6
      //weekly chart
    
    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `users_from_ivillage` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
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
            $num_of_data = $count_weekdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'weekly Total number of users registered from Site www.ivillage.co.uk'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_6w'));
        chart.draw(data, options);
      }
    </script>

    <div class="col-md-6">
    <div id="chart_div_6w" style="width: 100%; height: 100%;"></div>
    </div>
    </div>

    <?php
      //Query 7
      //weekly chart

    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `users_from_pickourteam` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
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
            $num_of_data = $count_weekdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'weekly Total number of users registered from Site www.pickourteam.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_7w'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_7w" style="width: 100%; height: 100%;"></div>
    </div>
    <?php
      //Query 8
      //weekly chart
    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `users_from_ihubbub` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
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
            $num_of_data = $count_weekdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'weekly Total number of users registered from Site www.ihubbub.com'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_8w'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_8w" style="width: 100%; height: 100%;"></div>
    </div>
    </div>

    <?php
      //Query 9
      //weekly chart
    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `users_from_babyworld` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
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
            $num_of_data = $count_weekdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'weekly Total number of users registered from Site www.babyworld.co.uk'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_9w'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_9w" style="width: 100%; height: 100%;"></div>
    </div>

    <?php
      //Query 10
      //weekly chart

    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `bff_like` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'epoints'],
          <?php
            $num_of_data = $count_weekdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'weekly Total epoints for BFF Like'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_10w'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_10w" style="width: 100%; height: 100%;"></div>
    </div>
    </div>
    <?php
      //Query 11
      //weekly chart

    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `epoints_like` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'epoints'],
          <?php
            $num_of_data = $count_weekdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'weekly Total epoints for epoints Like.'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_11w'));
        chart.draw(data, options);
      }
    </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_11w" style="width: 100%; height: 100%;"></div>
    </div>

    <?php
      //Query 12
      //weekly chart
    
    $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
      $num_of_data = 7; //set number of data to be extracted and displayed in the chart
      $count_weekdays = 0;
      for ($i=1; $i <= $num_of_data; $i++) { 
        $result = mysql_query("SELECT * FROM `total_like` WHERE `day`='$current_day' AND `month`='$current_month' ORDER BY id desc", $db2) or die("error1");
        $current_day--;
        $row = mysql_fetch_array($result) or die("error2");
        $day[$i] = $row['day'];
        $month[$i] = $row['month'];
        $year[$i] = $row['year'];
        $number[$i] = $row['number'];
        $count_weekdays++;
        if ($current_day == 0){
          break;
        }
      }
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'epoints'],
          <?php
            $num_of_data = $count_weekdays;
      for ($count=$num_of_data; $count >1; $count--) { 
        ?>
          ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>],  
        <?php
      }
            ?> 

            ['<?php echo $day[$count]." ".$this_month; ?>',  <?php echo $number[$count]; ?>]
        ]);

        var options = {
          title: 'weekly Total epoints for Likes'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_12w'));
        chart.draw(data, options);
      }
    </script>
    <div class="col-md-6">
    <div id="chart_div_12w" style="width: 100%; height: 100%;"></div>
    </div>
    </div>

  </body>
</html>
