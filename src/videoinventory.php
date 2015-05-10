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
      $password = '9D5KAZisXHORComp';

      $mydata = new mysqli($hostname, $username, $password, $databaseName);
      if ($mydata->connect_errorno){
        echo "Couldn't connect to MySQL: (" . $mydata->connect_errorno . ")" . $mydata->connect_error;
        echo "program terminates.";
        die();
      }
      
      if (!$mydta->query("CREATE TABLE videos(id INT PRIMARY KEY, name VARCHAR (255) UNIQUE NOT NULL, category VARCHAR (255) NOT NULL, length INT UNSIGNED, rented TINYINT )")){
        echo "Couldn't make a table: (" . $madata->errorno . ")" . $mydata->error;
        echo "program terminates.";
        die();
      }



      ?>

    <!--  <form action= "http://web.engr.oregonstate.edu/~osterbit/2/repo/class-content/form_tests/Formtest.php" method= "get">
        GET FORM
        <br>
        Text here:<input type= "text" name= "text_input">
        <br>
        Number here:<input type= "number" name= "numerical_input">
        <br>
        Password here:<input type= "password" name= "password_input">
        <br>
        Select between:
        <br>
        Snickers<input type="radio" name="candy" value="Snickers" checked>
        <br>
        Skittles<input type="radio" name="candy" value="Skittles" checked>
        <br>
        Mentos<input type="radio" name="candy" value="Mentos" checked>
        <input type= "submit">
      </form>
      -->
  </body>
</html>
