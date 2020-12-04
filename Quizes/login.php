<!DOCTYPE html>
<html>
<head>
	<title>Lol</title>
</head>
<body>

<?php

	require("conn.php");

	if(!$conn){
		echo "There is no conncetion";
	}else{
		echo "There is connection <br>" ;
	}
	if (!empty($_POST['userName']) and !empty($_POST['userPassword']) and !empty($_POST['type'])){
		authenticateUser();
	}else{
		getUserDetails();
	}

	function getUserDetails(){
    
		echo '
			<form method="POST">
				<table>
					<tr><td>Name</td><td><input type="text" name="userName"></td></tr>
					<tr><td>Password</td><td><input type="password" name="userPassword"></td></tr>

					<tr><td>Status</td><td>

					<input type="radio" checked name="type" id="staff" value = "staff"/>
					<label for="staff">Staff</label> 

					<input type="radio" name="type" id="student" value = "student"/>
					<label for="student">Student</label>

					<br></td></tr>

				</table>
				<input type="submit" value="Login">
			</form> 
		';
	}

	function authenticateUser(){
		global $conn;

		$nm = $_POST['userName'];
		$pw = $_POST['userPassword'];
		$tp = $_POST['type'];

		if ($tp == "student"){
			$sql = "SELECT password, student_id FROM student WHERE student_name = '$nm'"; 
		}

		else if ($tp == "staff"){
			$sql = "SELECT password, staff_id FROM staff WHERE staff_name = '$nm'"; 
		}

		if ($result = mysqli_query($conn, $sql)){
			echo "SQL is ok <br>";
		}else{
			echo "Something went wrong <br>";
		}

		while ($row = mysqli_fetch_array($result)){
			if (empty($row['password'])){
				getUserDetails();
			}
			else if (password_verify($pw, $row['password'])){
				echo "Password is good <br>";
				session_start();
				$_SESSION['name'] = $nm;
				$_SESSION['type'] = $tp;
				if($tp == "student"){
					$_SESSION['id'] = $row['student_id'];					
					header("Location: studentPage.php");
				}
				else if($tp == "staff"){
					$_SESSION['id'] = $row['staff_id'];
					header("Location: staffPage.php");
				}
			}else{
				echo "Incorrect password <br>";	
			}
		}
		echo "something went wrong";
	}

?>
</body>
</html>