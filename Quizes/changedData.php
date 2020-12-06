<?php
	require("conn.php");
	$myPost = array_values($_POST);

	//Deleting the quiz
	if ((strcmp( $_POST['function'] , "Delete" ) == 0) and ($_GET['id'] == 0)){
		$quiz_id = $_POST['quizId'];
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

	//Adding the question
	else if (strcmp( $_POST['function'] , "Add") == 0){
		$qs = $_POST['new_question'];
		$firo = $_POST['new_first_option'];
		$so = $_POST['new_second_option'];
		$to = $_POST['new_third_option'];
		$fo = $_POST['new_third_option'];
		$as = $_POST['new_answer'];
		$quiz_id = $_POST['quizId'];
		$question_id;
		$sql = "INSERT INTO question (question, option_1, option_2, 
				option_3, option_4, answer) 
				VALUES ('$qs',  '$firo', '$so', '$to', '$fo', '$as')";
		if(mysqli_query($conn, $sql)){
			$question_id = mysqli_insert_id($conn);
			echo "Question was added";
			echo "<br>" . $question_id . "<br>";		
			$sql = "INSERT INTO quiz_question (quiz_id, question_id) 
					VALUES ('$quiz_id', '$question_id')";
					if(mysqli_query($conn, $sql)){
						echo "VERY GOOOOOOOOD";
					}else{
						echo "Something went wrong";
					}
		}else{
			echo "Question was not added, something went wrong";
		}

	}

	else{
		//Updating the quiz
		if ($_GET['id'] == 0){
			$quiz_id = $_POST['quizId'];
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
		//Deleting a question
		else if(strcmp( $_POST['function'] , "Delete" ) == 0){
			$sql = "DELETE FROM question WHERE question_id ='".$_POST['questId']."'";
			if (mysqli_query($conn, $sql)){
				echo $_POST['questId']."<br>";
				echo "'$myPost[7]'<br>";
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