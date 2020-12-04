<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	require("conn.php");

	if(!$conn){
		//echo "There is no conncetion";
	}else{
		//echo "There is connection <br>" ;
	}
	session_start();
	//echo "<h1> Hello ". $_SESSION['name'] . "</h1>"; 

	// $sql = "SELECT
	// 			question.question,
	// 		    question.option_1,
	// 		    question.option_2,
	// 		    question.option_3,
	// 		    question.option_4,
	// 		    question.answer,
	// 		    quiz.quiz_name
	// 			FROM question
	// 			JOIN quiz_question ON question.question_id = quiz_question.question_id
	// 			JOIN quiz ON quiz.quiz_id = quiz_question.quiz_id";

	$sql = "SELECT
			quiz.quiz_id,
			quiz.quiz_name
			FROM quiz
			";

	if ($result = mysqli_query($conn, $sql)){
		echo "SQL is ok <br>";
	}else{
		echo "Something went wrong <br>";
	}
	echo "The quizes: ";
	while ($row = mysqli_fetch_array($result)){
		echo "<p><a href='quiz.php?id=".$row['quiz_id']."'>" . $row['quiz_name'] . "</a></p><br>";
	}

	// while ($row = mysqli_fetch_array($result)){
	// 	echo "<br> <br>  ".$row['question']."<br>";
	// 	echo "<a href=''>".$row['option_1']."</a> <br>";
	// 	echo "<a href=''>".$row['option_2']."</a> <br>";
	// 	echo "<a href=''>".$row['option_3']."</a> <br>";
	// 	echo "<a href=''>".$row['option_4']."</a> <br>";
	// }
?>

</body>
</html>
