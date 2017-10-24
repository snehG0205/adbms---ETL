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
    <style type="text/css">
      .container{
        padding-top: 10%;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="card">
        <div class="card-tabs">
          <ul class="tabs tabs-fixed-width">
            <li class="tab"><a class="active" href="#tab1">File Upload</a></li>
            <li class="tab"><a href="#tab2">Rules</a></li>
          </ul>
        </div>
        <div class="card-content grey lighten-4">
          <div id="tab1">
            <form action="#" method="post" enctype="multipart/form-data">
              <div class="file-field input-field">
                <div class="btn blue lighten-1">
                  <span>File</span>
                  <input type="file" name="db" required>
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
              </div>
              <button class="btn waves-effect waves-light blue lighten-1" type="submit" name="submit" onclick="Materialize.toast('Upload Successful!!', 4000, 'green')">Submit
                <i class="material-icons right">send</i>
              </button>
            </form>
          </div>
          <div id="tab2">

          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
  @session_start();
  if (isset($_POST["submit"])) {
    $file = $_FILES["db"]["name"];
    $array= explode(".",$file);
    $getExt = $array[1];
    $_SESSION["fileName"] = $file;
    $tmpFilePath = $_FILES['db']['tmp_name'];
    echo "Temp file path = ".$tmpFilePath."<br>";
    $newFilePath = "assets/files/".$getExt."/".$_FILES["db"]["name"];
    echo "   NEw FIle path = ".$newFilePath."<br>";
    $retVal = (move_uploaded_file($tmpFilePath, $newFilePath)) ? "upload":"fail";
    echo $retVal;
    if ($getExt == "csv") {
      sleep(5);
      header("Location:scripts/csvRead.php");
    }
    elseif ($getExt == "xml") {
      sleep(5);
      header("Location:scripts/xmlRead.php");
    }
    elseif ($getExt == "json") {
      sleep(5);
      header("Location:scripts/jsonRead.php");
    }
    elseif ($getExt == "sql") {
      sleep(5);
      header("Location:scripts/sqlRead.php");
    }
    else{
      echo "Unsupported Datatype";
      die();
    }
  }

?>
