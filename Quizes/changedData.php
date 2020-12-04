<?php
	require("conn.php");
	$quiz_id = $_POST['quizId'];
	$myPost = array_values($_POST);
	if ((strcmp( $_POST['function'] , "Delete" ) == 0) and ($_GET['id'] == 0)){
		$sql = "DELETE
				question
				FROM question
				JOIN quiz_question ON question.question_id = quiz_question.question_id
				JOIN quiz ON quiz_question.quiz_id = quiz.quiz_id
				WHERE quiz.quiz_id = '$quiz_id'";
		if (mysqli_query($conn, $sql)) {
			echo "All questions relative to the quiz were deleted";
		}else{
			echo "Error deleting questions: " . mysqli_error($conn);
		}
		$sql = "DELETE FROM quiz WHERE quiz_id = '$quiz_id'";
		if (mysqli_query($conn, $sql)) {
			echo "The quiz was deleted";
		}else{
			echo "$quiz_id <br>";
			echo "Error deleting quiz: " . mysqli_error($conn);
		}
	}
	else{
		if ($_GET['id'] == 0){
			echo $myPost[3];
			$sql = "UPDATE quiz SET quiz_name='$myPost[0]', 
									quiz_duration='$myPost[1]', 
									quiz_available='$myPost[2]'
			WHERE quiz_id=".$myPost[3].";";
			if (mysqli_query($conn, $sql)){
		  		echo "Quiz updated successfully";
			}else{
		  		echo "Error updating Quiz: " . mysqli_error($conn);
			}
		}

		elseif (strcmp( $_POST['function'] , "Delete" ) == 0){
			$sql = "DELETE FROM question WHERE question_id = '$myPost[6]'"
			if (mysqli_query($conn, $sql)){
		  		echo "Question successfully deleted";
		}else{
	  		echo "Error deleting question: " . mysqli_error($conn);
		}
		}else{
			$sql = "UPDATE question SET question='$myPost[0]', option_1='$myPost[1]', 
					option_2='$myPost[2]', option_3='$myPost[3]', 
					option_4='$myPost[4]', answer='$myPost[5]'
			 WHERE question_id=".$myPost[6].";";

			if (mysqli_query($conn, $sql)){
		  		echo "Question updated successfully";
			}else{
		  		echo "Error updating question: " . mysqli_error($conn);
			}
		}
	}
?>