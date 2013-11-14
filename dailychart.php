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
	$url = 'http://nagios-prod-01.iatlimited.com/epoints-1'; //url of the page to be refreshed. 
	$refreshRate = 600; //in seconds
	header("Refresh:".$refreshRate.";url='".$url."'"); //refreshes the page within the given time to the given url
  ?>
  <body>
  <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.php">Daily Chart</a></li>
            <li><a href="weeklychart.php">Weekly Chart</a></li>
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
     
		<?php //Query 1
      
      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //Daily Graph
      $result = mysql_query("SELECT * FROM `total_users` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
		?> 
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Users'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total Number of Users'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_1d'));
            chart.draw(data, options);
          }
        </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_1d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>

    <?php //Query 2

      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //Daily Graph
      $result = mysql_query("SELECT * FROM `validated_users` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Members'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total Number of members who have validated their account'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_2d'));
            chart.draw(data, options);
          }
        </script>
        <div class="col-md-6">
    <div id="chart_div_2d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    </div>
    
    <?php //Query 3

      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');
     

      //Daily Graph
      $result = mysql_query("SELECT * FROM `issued_epoints` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'epoints'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total Number of epoints issued.'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_3d'));
            chart.draw(data, options);
          }
        </script>
    <div class="row">
    <div class="col-md-6">
    <div id="chart_div_3d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>

		<?php //Query 4

      $current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //Daily Graph
      $result = mysql_query("SELECT * FROM `users_from_epoints` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Users'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total number of users registered from Site www.epoints.com'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_4d'));
            chart.draw(data, options);
          }
        </script>

    <div class="col-md-6">
    <div id="chart_div_4d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    </div>
    
		<?php //Query 5

			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');      

      //Daily Graph
      $result = mysql_query("SELECT * FROM `users_from_bestforfilm` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Users'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total number of users registered from Site www.bestforfilm.com'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_5d'));
            chart.draw(data, options);
          }
        </script>
      <div class="row">
    <div class="col-md-6">
    <div id="chart_div_5d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    
		<?php //Query 6
    
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');     

      //Daily Graph
      $result = mysql_query("SELECT * FROM `users_from_ivillage` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Users'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total number of users registered from Site www.ivillage.co.uk'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_6d'));
            chart.draw(data, options);
          }
        </script>

    <div class="col-md-6">
    <div id="chart_div_6d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    </div>
    
		<?php //Query 7
    
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');     

      //Daily Graph
      $result = mysql_query("SELECT * FROM `users_from_pickourteam` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Users'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total number of users registered from Site www.pickourteam.com'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_7d'));
            chart.draw(data, options);
          }
        </script>
      <div class="row">
    <div class="col-md-6">
    <div id="chart_div_7d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    
		<?php //Query 8
    
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //Daily Graph
      $result = mysql_query("SELECT * FROM `users_from_ihubbub` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Users'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total number of users registered from Site www.ihubbub.com'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_8d'));
            chart.draw(data, options);
          }
        </script>

    <div class="col-md-6">
    <div id="chart_div_8d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    </div>
    
		<?php //Query 9
    
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //Daily Graph
      $result = mysql_query("SELECT * FROM `users_from_babyworld` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'Users'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total number of users registered from Site www.babyworld.co.uk'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_9d'));
            chart.draw(data, options);
          }
        </script>
      <div class="row">
    <div class="col-md-6">
    <div id="chart_div_9d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    
		<?php //Query 10
    
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //Daily Graph
      $result = mysql_query("SELECT * FROM `bff_like` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'epoints'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total epoints for BFF Like'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_10d'));
            chart.draw(data, options);
          }
        </script>

    <div class="col-md-6">
    <div id="chart_div_10d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    </div>
    
    <?php //Query 11
    
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');

      //Daily Graph
      $result = mysql_query("SELECT * FROM `epoints_like` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'epoints'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total epoints for epoints Like.'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_11d'));
            chart.draw(data, options);
          }
        </script>
        <div class="row">
    <div class="col-md-6">
    <div id="chart_div_11d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    
  <?php //Query 12
  
			$current_time = date('H:i:s');
      $current_day = date('d');
      $current_month = date('m');
      $current_year = date('Y');      

      //Daily Graph
      $result = mysql_query("SELECT * FROM `total_like` WHERE `day`='$current_day' ORDER BY id desc", $db2) or die("error1");
      $num_of_data = mysql_num_rows($result);

      for ($i=1; $i <= $num_of_data; $i++) { 
        $row = mysql_fetch_array($result) or die("error2");
        $time[$i] = $row['time'];
        $number[$i] = $row['number'];
      }
      
    ?>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Time', 'epoints'],
              <?php
                
          for ($count=$num_of_data; $count >1; $count--) { 
            ?>
              ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>],  
            <?php
          }
                ?> 

                ['<?php echo substr($time[$count],0,2); ?>',  <?php echo $number[$count]; ?>]
            ]);

            var options = {
              title: 'Daily Total epoints for Likes'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_12d'));
            chart.draw(data, options);
          }
        </script>

    <div class="col-md-6">
    <div id="chart_div_12d" style="width: 100%; height: 100%;"></div>
    <p style="font-size: 15px;">Time -----></p>
    </div>
    </div>
    
  </body>
</html>
