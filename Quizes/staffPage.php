<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	require("conn.php");
	session_start();
	if ($_SESSION['type'] != "staff") {
		die("<h1>Sorry, but only staff users can acces this page.</h1>");
	}
	
	$staff_id = $_SESSION['id'];
	echo "<h1> Hello staff ". $_SESSION['name'] . ".</h1>";
	$sql = "SELECT
		quiz.quiz_id,
		quiz.quiz_name, 
		quiz.quiz_author, 
		quiz.quiz_available,
		quiz.quiz_duration
		FROM quiz 
		WHERE quiz.quiz_author = ".$staff_id.";";
		if($result = mysqli_query($conn, $sql)){
		}else{
			echo "Error with sql request<br>";
		}
		if(mysqli_num_rows($result) == 0){
			echo "You did not create any quizes to change.";
		}
		else{
			echo "Quizes which you created and can update (delete, add new questions or change): <table>";
			while ($row = mysqli_fetch_array($result)){
				echo "<tr><td><a href='staffQuiz.php?id=".$row['quiz_id']."'>" . $row['quiz_name'] . "</a></td></tr>";
			}
			echo "</table><br><br>";	
		}
		
		echo "<p>You can create a new quiz by clicking on this link: <a href='createNewQuiz.php'>Create new quiz!</a></p>";



?>
</body>
</html>