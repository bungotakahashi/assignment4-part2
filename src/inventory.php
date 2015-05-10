<?php

	 $hostname = 'oniddb.cws.oregonstate.edu';
     $databaseName = 'takahasb-db';
     $username = 'takahasb-db';
     $password = '9D5KAZisXHORComp'; 

     $filePath = explode('/', $_SERVER['PHP_SELF'], -1); // this filepath technique is from the lecture code.
     $filePath = implode('/',$filePath);
	 $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;

     $mydata = new mysqli($hostname, $username, $password, $databaseName);
     if ($mydata->connect_errno){
       	echo "Couldn't connect to MySQL: (" . $mydata->connect_errno . ")" . $mydata->connect_error;
  	   	echo "click <a href='main.php'>here</a> to return to your inventory.";      
     }

	if ($_POST["insert"]){


        if (!($stmt = $mydata->prepare("INSERT INTO videos(name, category, length) VALUES (?, ?, ?)"))){
          echo "Prepare failed: (" . $mydata->errno . ")" . $mydata->error;
          echo "click <a href='main.php'>here</a> to return to your inventory.";
        }

        $name = $_POST["name"];
        $category = $_POST["category"];
        $length = $_POST["length"];
      
        if (!is_numeric($length)){
        	echo "Entered length is not valid. It should be a number.";
        	echo "click <a href='main.php'>here</a> to return to your inventory.";
        }

        if ($name==null || strlen($name)>255){
        	echo "Entered name is null or the length is larger than 255.";
        	echo "click <a href='main.php'>here</a> to return to your inventory.";
        }

        if ($name==null || strlen($category)>255){
        	echo "Entered category is null or the length is larger than 255.";
        	echo "click <a href='main.php'>here</a> to return to your inventory.";
        }

        if(!$stmt->bind_param('ssi', $name, $category, $length)){
          echo "Binding parameters failed: (" . $mydata->errno . ")" . $mydata->error;
          echo "click <a href='main.php'>here</a> to return to your inventory.";

        }

        if (!$stmt->execute()){
          echo "execute failed :(" . $mydata->errno . ")" . $mydata->error;
          echo "click <a href='main.php'>here</a> to return to your inventory.";
        }

		$stmt->close();
        header("Location: {$redirect}/main.php", true);

      }
     

    







     if ($_GET["delete"]){
      	if (!($stmt = $mydata->prepare("DELETE FROM videos WHERE id=?"))){
          echo "Prepare failed: (" . $mydata->errno . ")" . $mydata->error;
    	  echo "click <a href='main.php'>here</a> to return to your inventory.";      
         }
		$id = $_GET["delete"];
      
        if(!$stmt->bind_param('i', $id)){
          echo "Binding parameters failed: (" . $mydata->errno . ")" . $mydata->error;
          echo "click <a href='main.php'>here</a> to return to your inventory.";

        }

        if (!$stmt->execute()){
          echo "execute failed :(" . $mydata->errno . ")" . $mydata->error;
          echo "click <a href='main.php'>here</a> to return to your inventory.";
        }

		//echo "yo";
		//echo "$redirect";
		$stmt->close();
		header("Location: {$redirect}/main.php", true);
      	

      }




     if ($_GET["deleteall"]){
     	
      	if (!($stmt = $mydata->prepare("TRUNCATE videos"))){
          echo "Prepare failed: (" . $mydata->errno . ")" . $mydata->error;
    	  echo "click <a href='main.php'>here</a> to return to your inventory.";      
         }
      

        if (!$stmt->execute()){
          echo "execute failed :(" . $mydata->errno . ")" . $mydata->error;
          echo "click <a href='main.php'>here</a> to return to your inventory.";
        }
		$stmt->close();
		header("Location: {$redirect}/main.php", true);
      
      }

	


      
     if ($_GET["check"]){
      	$id = $_GET["check"];
      	$sql = "SELECT rented FROM videos WHERE id = $id LIMIT 1";

      	$target = $mydata->query($sql);
      
      	$tar = $target->fetch_array();
        $x=$tar['rented'];
      	

      	if ($x==0){
     		if (!$stmt = $mydata->prepare("UPDATE videos SET rented = true WHERE id=? ")){
     			echo "prepare failed";
     			echo "click <a href='main.php'>here</a> to return to your inventory.";
      		}

      		if(!$stmt->bind_param('i', $id)){
          		echo "Binding parameters failed: (" . $mydata->errno . ")" . $mydata->error;
          		echo "click <a href='main.php'>here</a> to return to your inventory.";

       		 }

        	if (!$stmt->execute()){
          		echo "execute failed :(" . $mydata->errno . ")" . $mydata->error;
          		echo "click <a href='main.php'>here</a> to return to your inventory.";
       		 }

			$stmt->close();
			//echo "good";
			header("Location: {$redirect}/main.php", true);
		}



		else {
			//echo "check in";
			if (!$stmt = $mydata->prepare("UPDATE videos SET rented = false WHERE id=? ")){
				echo "prepare failed";
     			echo "click <a href='main.php'>here</a> to return to your inventory.";

      		}
			if(!$stmt->bind_param('i', $id)){
          		echo "Binding parameters failed: (" . $mydata->errno . ")" . $mydata->error;
          		echo "click <a href='main.php'>here</a> to return to your inventory.";

        	}

        	if (!$stmt->execute()){
          		echo "execute failed :(" . $mydata->errno . ")" . $mydata->error;
          		echo "click <a href='main.php'>here</a> to return to your inventory.";
       		 }

			$stmt->close();
			
			header("Location: {$redirect}/main.php", true);
		}
	}

?>