<!DOCTYPE html>
<html>
<head>
	<title>getting the score</title>
</head>
<body>
<?php 
	require("conn.php");
	session_start();
	$num = $_POST['numberOfQuestions'];
	$correct = 0;
	$tot = 0;
	$quiz_id = $_POST['quizId'];
	$student_id = $_SESSION['id'];
	$date = $_POST['date'];
	for ($i=1; $i < $num; $i++){ 
		$str =  "Answer" . $i;
		if(strcmp($_POST[$str], $_POST[$i]) == 0){
			$correct++;
		}
		$tot++;
	}
	$mark = $correct/$tot * 100;
	$mark = $mark . "%";
	$sql =	"INSERT INTO student_quiz
			(student_id, quiz_id, date_of_attempt, score) VALUES
			('$student_id', '$quiz_id', '$date', '$mark');";
	echo "Information about current attempt is: <br><br><br>";
	echo "Correct answers: " . $tot . "<br>";
	echo "Number of questions: " . $correct . "<br>";
	echo "Your mark is: " . $mark . "<br>";
	echo "Date of Attempt is: " . $date . "<br>"; 
	if(mysqli_query($conn, $sql)){
		echo "All data were added to the database!";
	}else{
		echo "You already got your mark. So this attempt will not be recorded!";
	}
?>
</body>
</html>

