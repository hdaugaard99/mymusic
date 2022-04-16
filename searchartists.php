<?php
session_start();
if(!isset($_SESSION['user_id'])) {
	header("Location: signup.php");
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
	<?php include "database.php" ?>
	
	<?php
    $query = $_GET['query']; 
    // gets value sent over search form
     
    $min_length = 3;
    // you can set minimum length of the query if you want
     
    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
         
        $query = htmlspecialchars($query); 
        // changes characters used in html to their equivalents, for example: < to &gt;
         
        $query = mysqli_real_escape_string($conn2, $query);
        // makes sure nobody uses SQL injection
         
        $raw_results = mysqli_query($conn2, "SELECT * FROM artists
            WHERE (`artist_name` LIKE '%".$query."%')") or die(mysqli_error($conn2));
         
        if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
             
            while($results = mysqli_fetch_array($raw_results)){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
             
                echo "<p><h3>".$results['artist_name']."</h3></p>";
                // posts results gotten from database(title and text) you can also show id ($results['id'])
				
            }
             
        }
        else{ // if there is no matching rows do following
            echo "No results";
        }
         
    }
    else{ // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }
	
	
	
	
?>
</body>
</html>