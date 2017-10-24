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
      $file = $_SESSION["fileName"];
      $csvFile = "../assets/files/csv/".$file;

      echo "<html><body><table border=2 class='bordered'>\n\n";
      $f = fopen($csvFile, "r");
      while (($line = fgetcsv($f)) !== false) {
              echo "<tr>";
              foreach ($line as $cell) {
                      echo "<td>" . htmlspecialchars($cell) . "</td>";
              }
              echo "</tr>\n";
      }
      fclose($f);
      echo "\n</table></body></html>";

      if (isset($_POST["load"])) {
        $conn=null;
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "adbms-ETL";

        $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

        $array = explode(".", $file);
        $table = $array[0]."_csv_".time();
        $sql = "CREATE TABLE ".$table." (SAP_ID varchar (11), Name text, Phone_No varchar(10), Email_ID text, DateOfBirth Date);";
        //echo $sql;
        if (mysqli_query($conn, $sql)) {
            //echo "Table MyGuests created successfully";
        } else {
            echo "Error creating table: " . mysqli_error($conn);
            die();
        }

        $result1=mysqli_query($conn,"select count(*) count from $table");
        $r1=mysqli_fetch_array($result1);
        $count1=(int)$r1['count'];
        //If the fields in CSV are not seperated by comma(,)  replace comma(,) in the below query with that  delimiting character
        //If each tuple in CSV are not seperated by new line.  replace \n in the below query  the delimiting character which seperates two tuples in csv
        // for more information about the query http://dev.mysql.com/doc/refman/5.1/en/load-data.html
        mysqli_query($conn, '
            LOAD DATA LOCAL INFILE "'.$csvFile.'"
                INTO TABLE '.$table.'
                FIELDS TERMINATED by \',\'
                LINES TERMINATED BY \'\n\'
        ')or die(mysql_error());
        $result2=mysqli_query($conn,"select count(*) count from $table");
        $r2=mysqli_fetch_array($result2);
        $count2=(int)$r2['count'];
        $count=$count2-$count1;
        if($count>0)
        {
          echo "<script>Materialize.toast('Data Loaded Successfully!!', 4000, 'green')</script>";

        }
        else
        {
          echo "<script>Materialize.toast('Error Encountered', 4000, 'red')</script>";
        }

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
