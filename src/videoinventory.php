<!DOCTYPE html>
<html>
  <head>
    <meta charset= "UTF-8">
    <title>assignment4-2.php</title>
    <link rel="stylesheet" href="assignment4-2.css">
  </head>
  <body>
   
      <?php
      ini_set('display_errors', 'On');

      $hostname = 'oniddb.cws.oregonstate.edu';
      $databaseName = 'takahasb-db';
      $username = 'takahasb-db';
      $password = '9D5KAZisXHORComp'; // include confidential.php later

      $mydata = new mysqli($hostname, $username, $password, $databaseName);
      if ($mydata->connect_errno){
        echo "Couldn't connect to MySQL: (" . $mydata->connect_errno . ")" . $mydata->connect_error;
        echo "program terminates.";
        die();
      }
      /* if (!$mydata->query("CREATE TABLE videos(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR (255) UNIQUE NOT NULL, category VARCHAR (255) NOT NULL, length INT UNSIGNED NOT NULL DEFAULT 0, rented BOOL NOT NULL DEFAULT 0)")){
          echo "Couldn't make a table: (" . $madata->errno . ")" . $mydata->error;
          echo "program terminates.";
          die();
        }*/

      if ($_GET){

        if (!($stmt = $mydata->prepare("INSERT INTO videos(name, category, length) VALUES (?, ?, ?)"))){
          echo "Prepare failed: (" . $mydata->errno . ")" . $mydata->error;
          echo "program terminates.";
          die();
        }

        $name = $_GET["name"];
        $category = $_GET["category"];
        $length = $_GET["length"];
      
        if(!$stmt->bind_param('ssi', $name, $category, $length)){
          echo "Binding parameters failed: (" . $mydata->errno . ")" . $mydata->error;
        }

        if (!$stmt->execute()){
          echo "execute failed :(" . $mydata->errno . ")" . $mydata->error;
        }






      }

      ?>

      <form action= "http://web.engr.oregonstate.edu/~takahasb/videoinventory.php" method= "get">
      
        Name:<input type= "text" name= "name" required>
        <br>
        Category:<input type= "text" name= "category" required>
        <br>
        Length:<input type= "number" name= "length" min= "0" required>
        <br>
       
        <input type= "submit" value= "Add"> </input>
      </form>
      
  </body>
</html>
