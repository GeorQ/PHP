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
		echo "<form method='POST'  action='changedData.php?id=0'>
		<table>		
			<tr><td>Infoprmation about quiz:</td><td><input type='submit' value='Delete' name='function'></td></tr>
			<tr><td>Change quiz name: " .$row['quiz_name'].     "</td><td><input type='text' name='quizName'> (varchar)</td></tr>
			<tr><td>Change duration: "  .$row['quiz_duration']. "</td><td><input type='text' name='quizDuration'> (int)</td></tr>
			<tr><td>Quiz available: "   .$str.                  "</td><td><input type='text' name='quizAv'> (1 = yes, 0 = no)</td></tr>
			<input type='hidden' name='quizId' value=".$quizId.">
			<tr><td><input type='submit' value='Update' name='function'></td></tr>
		</table><br><br><br></form>
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
			//<input type='hidden' name='Answer".$counter."' value=".$row['answer'].">
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)){
		echo "<form method='POST' action='changedData.php?id=".$counter."'>
			<table>		
					<tr><td>Question number: </td><td>".$counter."</td><td>
					<input type='submit' value='Delete' name='function'></td></tr>

					<tr><td>Question: </td><td>".$row['question']."</td><td>
					<input type='text' name='userName'> (varchar)
					</td></tr>

					<tr><td>First option:  </td><td>".$row['option_1']."</td>
					<td><input type='text' name='O1".$counter."'> (varchar)
					</td></tr>

					<tr><td>Second option: </td><td>".$row['option_2']."</td><td>
					<input type='text' name='O2".$counter."'> (varchar)
					</td></tr>

					<tr><td>Third option:  </td><td>".$row['option_3']."</td><td>
					<input type='text' name='O3".$counter."'> (varchar)
					</td></tr>

					<tr><td>Forth option:  </td><td>".$row['option_4']."</td><td>
					<input type='text' name='O4".$counter."'> (varchar)
					</td></tr>

					<tr><td>Answer:  </td><td>".$row['answer']."</td><td>
					<input type='text' name='Answer".$counter."'> (varchar)
					</td></tr>
					<input type='hidden' name='questId' value=".$row['question_id'].">
					<tr><td><input type='submit' value='Update' name='function'></td></tr>
			</table><br><br>
			";
			echo "</form>";
		$counter++;
	}
	//echo '<input type="submit" value="Update"> </form>';

	echo    "Adding the new question to quiz.
			<form method='POST' action='changedData.php'>
			<table>
			<tr><td>Question: </td><td>
			<input type='text' name='new_question' required> (varchar)
			</td></tr>

			<tr><td>First option:  </td><td>
			<input type='text' name='new_first_option' required> (varchar)
			</td></tr>

			<tr><td>Second option: </td><td>
			<input type='text' name='new_second_option' required> (varchar)
			</td></tr>

			<tr><td>Third option:  </td><td>
			<input type='text' name='new_third_option' required> (varchar)
			</td></tr>

			<tr><td>Forth option:  </td><td>
			<input type='text' name='new_forth_option' required> (varchar)
			</td></tr>

			<tr><td>Answer:  </td><td>
			<input type='text' name='new_answer' required> (varchar)
			</td></tr>

			<input type='hidden' name='quizId' value='$quizId'>
			<tr><td><input type='submit' value='Add' name='function'></td></tr>
			</table><br><br>
			";
			echo "</form>";
?>
</body>
</html>