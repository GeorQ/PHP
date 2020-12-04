<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	require("conn.php");
	$date = date("Y/m/d");
	$id = $_GET['id'];
	$counter = 1;
	$sql = "SELECT 
			quiz.quiz_id,
			quiz.quiz_name, 
			quiz.quiz_author, 
			quiz.quiz_available,
			quiz.quiz_duration, 
			staff.staff_name 
			FROM quiz 
			JOIN staff ON quiz.quiz_author = staff.staff_id
			WHERE quiz.quiz_id = ".$id.";";
	$result = mysqli_query($conn, $sql);
	$str = "";
	$quizId;
	while ($row = mysqli_fetch_array($result)){
		$quizId = $row['quiz_id'];
		if ($row['quiz_available']) {
			$str = "yes";
		}else{
			$str = "no";
		}
		echo "
		<table>		
				<tr><td>Infoprmation about quiz:</td></tr>
				<tr><td>Quiz name is: ".$row['quiz_name'].".</td></tr>
				<tr><td>Quiz duration: ".$row['quiz_duration']." min.</td></tr>
				<tr><td>Quiz available: ".$str.".</td></tr>
				<tr><td>Quiz author: ".$row['staff_name'].".</td></tr>
		</table><br><br><br>
		";
	}

	$sql = "SELECT
			question.question_id,
			question.question,
			question.option_1,
			question.option_2,
			question.option_3,
			question.option_4,
			question.answer
			FROM question
			JOIN quiz_question ON question.question_id = quiz_question.question_id
			JOIN quiz ON quiz.quiz_id = quiz_question.quiz_id
			WHERE quiz.quiz_id =".$id.";";

	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)){
		echo "<form method='POST' action='getScore.php'>
			<input type='hidden' name='Answer".$counter."' value=".$row['answer'].">
			<table>		
					<tr><td></td><td>Question number: </td><td>".$counter."</td></tr>
					<tr><td></td><td>Question: </td><td>".$row['question']."</td></tr>
					<tr><td><input type='radio' name=".$counter." value = ".$row['option_1']."></td><td>First option:  </td><td>".$row['option_1']."</td></tr>
					<tr><td><input type='radio' name=".$counter." value = ".$row['option_2']."></td><td>Second option: </td><td>".$row['option_2']."</td></tr>
					<tr><td><input type='radio' name=".$counter." value = ".$row['option_3']."></td><td>Third option:  </td><td>".$row['option_3']."</td></tr>
					<tr><td><input type='radio' name=".$counter." value = ".$row['option_4']."></td><td>Forth option:  </td><td>".$row['option_4']."</td></tr>
			</table><br><br>
			";
		$counter++;
	}
	echo '<input type="hidden" name="numberOfQuestions" value='.$counter.'>
			<input type="hidden" name="quizId" value='.$quizId.'>
			<input type="hidden" name="date" value='.$date.'>
		  <input type="submit" name="done" value="submit"> </form>';

?>
</body>
</html>