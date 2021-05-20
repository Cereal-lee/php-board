<?php
	include_once("./_common.php");
	include "./session.php";
	include "./connectDB.php";

	$userID = $_POST["userID"];
	$name = $_POST["name"];
	$password = $_POST["password"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$birthday = $_POST["birthYear"]."-".$_POST["birthMonth"]."-".$_POST["birthDay"];
	$gender = $_POST["gender"];
	$nickname = $_POST["nickname"];

	function goRegist($alert){
		echo $alert."<br>";
		echo "<a href='./regist.php'>회원가입 폼으로 이동</a>";
		return;
	}

	//id check
	$isIDCheck = false;
	$sql = "SELECT userID FROM seum_php200_myMember WHERE userID = '{$userID}'";
	$res = $dbConnect -> query($sql);

	if($res){
		$count = $res -> num_rows;
		if($count == 0){
			$isIDCheck = true;
		}
		else{
			echo "이미 존재하는 아이디입니다.";
			goRegist();
			exit;
		}
	}
	else{
		echo "ERROR";
		exit;
	}

	//email check
	if(!filter_Var($email, FILTER_VALIDATE_EMAIL)){
		goRegist("올바른 이메일이 아닙니다.");
		exit;
	}

	$isEmailCheck = false;
	$sql = "SELECT email FROM seum_php200_myMember WHERE email = '{$email}'";
	$res = $dbConnect -> query($sql);

	if($res){
		$count = $res -> num_rows;
		if($count == 0){
			$isEmailCheck = true;
		}
		else{
			echo "이미 존재하는 이메일입니다.";
			goRegist();
			exit;
		}
	}
	else{
		echo "ERROR";
		exit;
	}

	// //pw check
	// if($password == null || $password == ""){
	// 	goRegist("비밀번호를 입력해 주세요.");
	// 	exit;
	// }

	// //nickname check
	// if($nickname == null || $nickname == ""){
	// 	goRegist("닉네임을 입력해 주세요.");
	// 	exit;
	// }

	// //name check
	// if($name == null || $name == ""){
	// 	goRegist("이름을 입력해 주세요.");
	// 	exit;
	// }

	// //phone check
	// if($phone == null || $phone == ""){
	// 	goRegist("전화번호를 입력해 주세요.");
	// 	exit;
	// }

	if($isEmailCheck == true && $isIDCheck == true){
		$sql = "INSERT INTO seum_php200_myMember (";
		$sql .= "userID, name, password, phone, email, birthday, gender, nickname) ";
		$sql .= "VALUES ('{$userID}','{$name}','{$password}','{$phone}','{$email}','{$birthday}','{$gender}','{$nickname}')";

		$res = $dbConnect -> query($sql);

		if($res){
			$_SESSION["myMemberID"] = $dbConnect -> insert_id;
			$_SESSION["nickname"] = $nickname;
			Header("Location:./index.php");
		}
		else{
			echo "ERROR";
			exit;
		}
	}
	else{
		goRegist("이메일 또는 닉네임이 중복값입니다.");
		exit;
	}
	
?>