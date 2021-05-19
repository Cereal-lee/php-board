<?php
	include_once("./_common.php");
	include "./session.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>로그인</title>

	<link rel="stylesheet" href="./css/my.css">
	<link rel="stylesheet" href="./css/main.css">
	<style>
		form{
			text-align: center;
		}
	</style>
</head>
<body>
<?php
	include "./common/header.php";
?>

<h2>로그인</h2>
	<form name = "login" method = "POST" action = "./login_processing.php">
		아이디<br><input type = "text" name = "userID" placeholder = "아이디 입력" required /><br><br>
		비밀번호<br><input type = "password" name = "password" placeholder = "비밀번호 입력" required /><br><br>
		
		<input type = "submit" value = "로그인"/>
	</form>

<?php
	include "./common/footer.html";
?>
</body>
</html>