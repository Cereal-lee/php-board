<?php
	include_once("./_common.php");
	include "./session.php";
	include "./connectDB.php";

	$userID = $_POST["userID"];
	$password = $_POST["password"];

	function goLogin($alert){
		echo $alert."<br>";
		echo "<a href='./login.php'>로그인 폼으로 이동</a>";
		return;
	}

	$sql = "SELECT nickname, myMemberID FROM seum_php200_myMember WHERE userID = '{$userID}' AND password = '{$password}'";
	$res = $dbConnect -> query($sql);
	
	if($res){
		$count = $res -> num_rows;
		if($count == 0){
			goLogin("로그인 정보가 일치하지 않습니다.");
			exit;
		}
		else{
			$memberInfo = $res -> fetch_array(MYSQLI_ASSOC);
			$_SESSION["myMemberID"] = $memberInfo["myMemberID"];
			$_SESSION["nickname"] = $memberInfo["nickname"];
			Header("Location:./index.php");
		}
	}
?>
