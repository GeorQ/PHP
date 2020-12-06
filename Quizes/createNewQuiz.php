<?php
	require("conn.php");
	session_start();
	if ($_SESSION['type'] != "staff") {
		die("<h1>Sorry, but only staff users can acces this page.</h1>");
	}
	$staff_id = $_SESSION['id'];
	$num_of_questions;
	$quiz_name;
	$quiz_duration;
	if (!empty($_POST['questions_done'])){
		createQuiz();
	}
	else if (!empty($_POST['quiz_name']) and !empty($_POST['quiz_duration']) and 
		!empty($_POST['num_of_questions'])){
		echo "<h2>Creation of questions for '".$_POST['quiz_name']."' </h2>";
		$num_of_questions = $_POST['num_of_questions'];
		$quiz_name = $_POST['quiz_name'];
		$quiz_duration = $_POST['quiz_duration'];
		$available = $_POST['available'];
		getQuestions();
	}else{
		echo "<h2>Quiz creation</h2><br>";
		echo "<h3>Please fill all fields</h3>";
		getQuizDetails();
	}





	function getQuizDetails(){
	echo '
			<form method="POST">
				<table>
					<tr><td>Name of the Quiz</td><td><input type="text" name="quiz_name"></td></tr>
					<tr><td>Duration in min</td><td><input type="text" name="quiz_duration"></td></tr>
					<tr><td>Available (1 for yes, 0 for no)</td><td><input type="text" name="available"></td></tr>
					<tr><td>Number of questions you want to add</td><td><input type="text" name="num_of_questions"></td></tr>
					<br></td></tr>

				</table>
				<input type="submit" value="Finish Quiz">
			</form> 
		';
	}

	function getQuestions(){
		global $num_of_questions, $quiz_duration, $quiz_name, $available;
		echo "<h3>Please fill all fields</h3>";
		echo '
			<form method="POST">';
		for ($i=0; $i < $num_of_questions; $i++) { 
			echo '  <table>
					<tr><td>Question: </td><td><input type="text" name="question' .$i.'"></td></tr>
					<tr><td>Option 1: </td><td><input type="text" name="option_1' .$i.'"></td></tr>
					<tr><td>Option 2: </td><td><input type="text" name="option_2' .$i.'"></td></tr>
					<tr><td>Option 3: </td><td><input type="text" name="option_3' .$i.'"></td></tr>
					<tr><td>Option 4: </td><td><input type="text" name="option_4' .$i.'"></td></tr>
					<tr><td>Answer  : </td><td><input type="text" name="answer'   .$i.'"></td></tr>
					<br></td></tr>
					</table>';
		}
		echo '<input type="hidden" name="num_of_questions" value="'.$num_of_questions.'">
			  <input type="hidden" name="quiz_duration" value="'.$quiz_duration.'">
			  <input type="hidden" name="quiz_name" value="'.$quiz_name.'">
			  <input type="hidden" name="quiz_available" value="'.$available.'">
			  <input type="submit" value="Finish questions" name="questions_done"> </form>';
	}
	function createQuiz(){
		global $conn;
		$qn = $_POST['quiz_name'];
		$qau = $_SESSION['id'];
		$qa = $_POST['quiz_available'];
		$qd = $_POST['quiz_duration'];
		$quiz_id;
		$sql = "INSERT INTO quiz (quiz_name, quiz_author, quiz_available, quiz_duration) 
					VALUES ('$qn', '$qau', '$qa', '$qd')";
		if(mysqli_query($conn, $sql)){
			echo "Quiz was added!<br>";
		}else{
			echo "Quiz was not added, something went wrong!<br>";
		}
		$sql = "SELECT quiz_id FROM quiz WHERE quiz_name = '$qn'";
        if($result = mysqli_query($conn, $sql)){
        }else{
            echo("Something went wrong");
        }
        while ($row = mysqli_fetch_array($result)) {
            $quiz_id = $row['quiz_id'];
        }
		for ($i=0; $i < $_POST['num_of_questions']; $i++){
			$question_id; 
			$qus  = $_POST['question'.$i];
			$opt1 = $_POST['option_1'.$i];
			$opt2 = $_POST['option_2'.$i];
			$opt3 = $_POST['option_3'.$i];
			$opt4 = $_POST['option_4'.$i];
			$answ = $_POST['answer'.$i  ];
			echo $qus . "<br>";
			$sql = "INSERT INTO question (question, option_1, option_2, option_3, option_4, answer) 
					VALUES ('$qus', '$opt1', '$opt2', '$opt3', '$opt4', '$answ')";
			if(mysqli_query($conn, $sql)){
				$sql = "SELECT question_id FROM question WHERE question = '$qus'";
	            if($result = mysqli_query($conn, $sql)){
	            }else{
	                echo("Something went wrong");
	            }
	            while ($row = mysqli_fetch_array($result)) {
	                $question_id = $row['question_id'];
            	}
				$sql = "INSERT INTO quiz_question(quiz_id, question_id)
						VALUES('$quiz_id', '$question_id')";
				if(mysqli_query($conn, $sql)){
					echo "Very good!<br>";
				}else{
					echo "NOT GOOD<br>";
				}
			}else{
				echo "Question was not added, something went wrong!<br>";
			}
		}
	}
?>