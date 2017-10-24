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
			$file = "../assets/files/xml/".$_SESSION["fileName"];
			$xml=simplexml_load_file($file) or die("Error: Cannot create object");
			//print_r($xml);
			echo "<table border=2 class='bordered'><tr><td>Sap_ID</td><td>Name</td><td>Gender</td><td>Phone_No</td><td>Email_ID</td><td>Date Of Birth</td</tr>";

			//echo "<br>".$json_data[0]['COL1'];

			foreach ($xml->student as $data) {
			  echo "<tr>";
			  echo "<td>".$data->SAP_ID."</td>";
			  echo "<td>".$data->Name."</td>";
        echo "<td>".$data->Gender."</td>";
			  echo "<td>".$data->Phone."</td>";
			  echo "<td>".$data->Email."</td>";
			  echo "<td>".$data->DateOfBirth."</td>";
			  echo "</tr>";
			}
			echo "</table>";

			if (isset($_POST["load"])) {
				# code...
				$conn=null;
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "adbms-ETL";

				$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " .mysqli_connect_error());

				$array = explode(".", $_SESSION["fileName"]);
				$table = $array[0]."_xml_".time();

				$sql = "CREATE TABLE ".$table." (SAP_ID varchar(11), Name text, Gender text, Phone_No varchar(10), Email_ID text, DateOfBirth Date);";
				if (mysqli_query($conn, $sql)) {
				  //  echo "Table MyGuests created successfully";
				} else {
				    echo "Error creating table: " . mysqli_error($conn);
				    die();
				}

				foreach ($xml->student as $data) {
					# code...
					$date = $data->DateOfBirth;
					$temp = explode("-", $date);
					$date = $temp[2]."-".$temp[0]."-".$temp[1];
					$len = strlen($data->Phone);
          $gender = $data->Gender;
          if ($gender == 1) {
            $gender = "Male";
          }
          elseif ($gender == 0) {
            $gender = "Female";
          }
          else{
            goto blocked;
          }
					if (!filter_var($data->Email, FILTER_VALIDATE_EMAIL) OR $temp[0]>12 OR $temp[1]>31 OR $len!=10) {
					    blocked: echo "Error at SAP ".$data->SAP_ID.". This record is blocked";

					}
					else{
						$sql = "INSERT INTO ".$table." VALUES ('".$data->SAP_ID."','".$data->Name."','".$gender."','".$data->Phone."','".$data->Email."','".$date."');";
					mysqli_query($conn, $sql);
					}
				}
        echo "<script>Materialize.toast('Data Loaded Successfully!!', 4000, 'green')</script>";

			}

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
