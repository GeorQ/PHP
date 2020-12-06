<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	require("conn.php");
	if(!$conn){
		echo "There is no conncetion with db";
	}
	session_start();
	echo "<h1> Hello student ". $_SESSION['name'] . "</h1>"; 
	$student_id = $_SESSION['id'];
	$sql = "SELECT
			quiz_id,
			quiz_available,
			quiz_name
			FROM quiz
			WHERE quiz_available = 1
			";

	if ($result = mysqli_query($conn, $sql)){
	}else{
		echo "Something went wrong <br>";
	}

	if(mysqli_num_rows($result) == 0){
		echo "Sorry, but there is no any available quizes for you!";
	}
	else{
		echo "All available quizes: <table>";
		while ($row = mysqli_fetch_array($result)){
			$sql_2 = "SELECT 
					  score,
					  date_of_attempt
					  FROM student_quiz
					  WHERE student_id = '$student_id' AND 
					  		quiz_id = '" . $row['quiz_id'] . "'";

		  	if (!$result_2 = mysqli_query($conn, $sql_2)){
		  		echo "Something went wrong <br>";
		  	}

		  	if (mysqli_num_rows($result_2) == 0) {
		  	echo " <tr><td>
		  		   <a href='quiz.php?id=".$row['quiz_id']."'>" . $row['quiz_name'] . "</a>
		  		   </td><td> 
		  		   you did not take this quiz yet!
		  		   </td></tr> ";
		  	}else{
		  		$row_2 = mysqli_fetch_array($result_2);
		  		echo "<tr><td>
			  		  <a href='quiz.php?id=".$row['quiz_id']."'>" . $row['quiz_name'] . "</a>
			  		  </td><td>
			  		  you took this test on: ".$row_2['date_of_attempt'].",
			  		  </td><td>
			  		  your mark is: ".$row_2['score']. "%
			  		  </td></tr> ";
		  	}

		}
	}
?>

</body>
</html>
