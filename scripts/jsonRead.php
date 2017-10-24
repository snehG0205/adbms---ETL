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
	<div class = "container">
		<?php
			@session_start();
			// Read JSON file
			//$file = $_SESSION["fileName"];
			$file = "../assets/files/json/".$_SESSION["fileName"];
			//echo $file;
			$json = file_get_contents($file);

			//Decode JSON
			$json_data = json_decode($json,true);

			//Print data
			//print_r($json_data);

			echo "<table border=2 class='bordered'><tr><td>Sap_ID</td><td>Name</td><td>Gender</td><td>Phone_No</td><td>Email_ID</td>";
			echo "<td>Date Of Birth</td</tr>";

			//echo "<br>".$json_data[0]['COL1'];

			foreach ($json_data as $data) {
			  echo "<tr>";
			  echo "<td>".$data['Sap_ID']."</td>";
			  echo "<td>".$data['Name']."</td>";
        echo "<td>".$data['Gender']."</td>";
			  echo "<td>".$data['Phone_No']."</td>";
			  echo "<td>".$data['Email_ID']."</td>";
			  echo "<td>".$data['DateOfBirth']."</td>";
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

				$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

				$array = explode(".", $_SESSION["fileName"]);
				$table = $array[0]."_json_".time();
				$sql = "CREATE TABLE ".$table." (SAP_ID varchar(11), Name text, Gender text, Phone_No varchar(10), Email_ID text, DateOfBirth Date);";
				if (mysqli_query($conn, $sql)) {
				    //echo "Table MyGuests created successfully";
				} else {
				    echo "Error creating table: " . mysqli_error($conn);
				    die();
				}

				foreach ($json_data as $data) {
					# code...
					$date = $data["DateOfBirth"];
					$temp = explode("-", $date);
					$date = $temp[2]."-".$temp[1]."-".$temp[0];
					$len = strlen($data['Phone_No']);
          $gender = $data["Gender"];
          if ($gender === "M") {
            $gender = "Male";
          }
          elseif ($gender === "F") {
            $gender = "Female";
          }
          else{
            goto blocked;
          }


					if (!filter_var($data["Email_ID"], FILTER_VALIDATE_EMAIL) OR $temp[1]>12 OR $temp[0]>31 OR $len!=10) {
					   blocked: echo "Error at SAP ".$data["Sap_ID"].". This record is blocked";

					}
					else{
						$sql = "INSERT INTO ".$table." VALUES ('".$data['Sap_ID']."','".$data['Name']."','".$gender."','".$data['Phone_No']."','".$data['Email_ID']."','".$date."');";
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
