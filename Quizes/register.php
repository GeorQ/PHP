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
		addUserDetails();
	}else{
		getUserDetails();
	}

	function getUserDetails(){
    
		echo '
			<form method="POST">
				<table>
					<tr><td>Name</td><td><input type="text" name="userName" required></td></tr>
					<tr><td>Password</td><td><input type="password" name="userPassword" required></td></tr>

					<tr><td>Status</td><td>

					<input type="radio" checked name="type" id="staff" value = "staff"/>
					<label for="staff">Staff</label> 

					<input type="radio" name="type" id="student" value = "student"/>
					<label for="student">Student</label>

					<br></td></tr>

				</table>
				<input type="submit" value="Register">
			</form> 
		';
	}

	function addUserDetails(){
		global $conn;
		$nm = $_POST['userName'];
		$pw = $_POST['userPassword'];
		$tp = $_POST['type'];

		$pw = password_hash($pw, PASSWORD_DEFAULT);

		//echo $nm . "   " . $ps . "   " . $tp ;

		if ($tp == "student") {
			$sql = "INSERT INTO student (student_name, password) 
					VALUES ('$nm', '$pw')";
			if(mysqli_query($conn, $sql)){
				echo "Student has registered";
			}else{
				echo "Student has not registered";
			}
		}
		elseif ($tp == "staff"){
			$sql = "INSERT INTO staff (staff_name, password) 
					VALUES ('$nm', '$pw')";
			if(mysqli_query($conn, $sql)){
				echo "Staff member has registered!";
			}else{
				echo "Staff member has not registered!";
			}
		}
	}

?>

</body>
</html>