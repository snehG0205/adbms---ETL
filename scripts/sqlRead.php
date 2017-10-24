<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
</head>
<body>
	<div class="container">
		<?php
			@session_start();
			$file = "../assets/files/sql/".$_SESSION["fileName"];
			$mysql_host = 'localhost';
			// MySQL username
			$mysql_username = 'root';
			// MySQL password
			$mysql_password = '';
			// Database name
			$mysql_database = 'adbms-ETL';
			// Connect to MySQL server
			$connection = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database);
			if (mysqli_connect_errno())
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			$lines = file($file);
			// Loop through each line
			foreach ($lines as $line) {
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
					// Perform the query
					if(!mysqli_query($connection, $templine)){
						print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($connection) . '<br /><br />');
					}
					// Reset temp variable to empty
					$templine = '';
				}
			}
      echo "<script>Materialize.toast('Data Loaded Successfully!!', 4000, 'green')</script>";
			echo "<table border=2 class='bordered'><tr><td>COL1</td><td>COL2</td></tr>";
		    $sql = "SELECT * FROM test_sql; ";
			$result = mysqli_query($connection, $sql);

			if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
			        echo "<tr><td>" . $row["COL_1"]. "</td><td>" . $row["COL_2"]. "</td></tr>";
			    }
			} else {
			    echo "0 results";
			}
			echo "</table>";
		?>
		<br><br><br>
		<form action="#" method="post">
		  <button class="btn waves-effect waves-light blue lighten-1" type="submit" name="load">LOAD
		    <i class="material-icons right">send</i>
		  </button>
		</form>
	</div>
</body>
</html>
