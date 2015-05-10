<!DOCTYPE html>
<html>
  <head>
    <meta charset= "UTF-8">
    <title>assignment4-2.php</title>
    <link rel="stylesheet" href="videos.css">
  </head>
  <body>
      
      <?php
      include "inventory.php";
      ini_set('display_errors', 'On');

      if (isset($_POST['CATEGORIES'])){ //check filtering is needed or not
        $catename = $_POST['CATEGORIES'];
        
        if ($catename=='All Movies'){
          
          $fil = 'id>0';
        }
        else{
          $fil = "category = '$catename'";
        }
      }
      else {
        $fil = 'id>0';
      }

      if(!$res = $mydata->query("SELECT * FROM videos WHERE $fil order by id")){ //create inventory
        echo "Couldn't select data properly because of filtering.";
      }
      
      echo "<table>";
      echo "<caption>Video Inventory</caption>";
      echo"<thead>";
      echo"<tr>";
        echo "<th> ID  </th>";
        echo "<th> NAME </th>";
        echo "<th> CATEGORY </th>";
        echo "<th> LENGTH </th>";
        echo "<th> RENTED </th>";
        echo "<th> DELETE </th>"; 
        echo "<th> CHECKING </th>";

      echo"</tr>";
      echo "</thead>";
      echo "<tbody>";
      while($row = $res->fetch_object()) {
        echo "<tr>";
        
        echo "<td> $row->id </td>";
        echo "<td> $row->name </td>";
        echo "<td> $row->category </td>";
        echo "<td> $row->length </td>";
        if ($row->rented == 0){
          echo "<td> available </td>";
        }
        else{
          echo "<td> checked out </td>";
        }
        echo "<form action= http://web.engr.oregonstate.edu/~takahasb/inventory.php method= get name=delete>";
        echo "<td><button type=submit value=$row->id name=delete>Delete</button> </td>";
        echo "</form>";
        
        if ($row->rented == 0){
          echo "<form action= http://web.engr.oregonstate.edu/~takahasb/inventory.php method= get name=checking>";
          echo "<td><button type=submit value=$row->id name=check>check-out</button> </td>";
          echo "</form>";
        }
        else {
          echo "<form action= http://web.engr.oregonstate.edu/~takahasb/inventory.php method= get name=checking>";
          echo "<td><button type=submit value=$row->id name=check>check-in</button> </td>";
          echo "</form>";
        }
        echo "</tr>";
      }  
      echo "</tbody>";

      echo "<tfoot>";
      echo "<form action= http://web.engr.oregonstate.edu/~takahasb/inventory.php method= get name=deleteall>";
      echo "<td colspan=2><button id=da type=submit name=deleteall value=1>DELETE ALL</button> </td>";
      echo "</form>";
      echo "</tfoot>";

      echo "</table>";
     


      /* if (!$mydata->query("CREATE TABLE videos(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR (255) UNIQUE NOT NULL, category VARCHAR (255) NOT NULL, length INT UNSIGNED NOT NULL DEFAULT 0, rented BOOL NOT NULL DEFAULT 0)")){
          echo "Couldn't make a table: (" . $madata->errno . ")" . $mydata->error;
          echo "program terminates.";
          die();
        }*/


     

      // FILTERING by category
      $cat = $mydata->query("SELECT distinct category FROM videos");
      echo "<form  id = fil action= http://web.engr.oregonstate.edu/~takahasb/main.php method= post>";
      echo "<input id=filter type=submit name=filter value=FILTER></input>";
      echo "<select id=filtering name='CATEGORIES'>";
      echo "<option value='All Movies'>All Movies</option>";
      while ($cat2 = $cat->fetch_array()) {
        if ($cat2['category']!=""){
          echo "<option value=$cat2[category]>$cat2[category]</option>";
        }

      }
      echo "</select>";

      
      echo "</form>";

      

      ?>

      <form id="addition" action= "http://web.engr.oregonstate.edu/~takahasb/inventory.php" method= "post" name= "insert">
        <h2>Add Videos Here</h2>
        Name:<input type= "text" name= "name" required>
        <br>
        Category:<input type= "text" name= "category" >
        <br>
        Length:<input type= "number" name= "length" min= "0" required>
        <br>
       
        <input id= "add" type= "submit" value= "Add" name="insert"> </input>
      </form>
      
  </body>
</html>
