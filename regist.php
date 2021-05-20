<?php
include_once("./_common.php");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>회원가입</title>
	
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
	<h2>회원가입</h2>
	<form name = "regist" method = "POST" action = "./regist_insert.php">
		아이디<br><input type = "text" name = "userID" placeholder = "아이디 입력" required /><br><br>
		비밀번호<br><input type = "password" name = "password" placeholder = "비밀번호 입력" required /><br><br>
		닉네임<br><input type = "text" name = "nickname" placeholder = "닉네임 입력" required /><br><br>
		이름<br><input type = "text" name = "name" placeholder = "이름 입력" required /><br><br>
		이메일<br><input type = "text" name = "email" placeholder = "이메일 입력" required /><br><br>
		전화번호<br><input type = "text" name = "phone" placeholder = "전화번호 입력" required /><br><br>
		생일<br><select name = "birthYear" required>
		<?php
			$thisYear = date('Y', time());
			for($i = 1960; $i <= $thisYear; $i++){
				echo "<option value='{$i}'>{$i}</option>";
			}
		?>
		</select>년
		<select name = "birthMonth" required>
		<?php
			for($i = 1; $i <= 12; $i++){
				echo "<option value='{$i}'>{$i}</option>";
			}
		?>
		</select>월
		<select name = "birthDay" required>
		<?php
			for($i = 1; $i <= 31; $i++){
				echo "<option value='{$i}'>{$i}</option>";
			}
		?>
		</select>일
		<br><br>
		성별<br>
		남<input type = "radio" name = "gender" value = "m" required />
		여<input type = "radio" name = "gender" value = "w" required />
		<br><br>
		<input type = "submit" value = "회원등록"/>
		<input type = "reset" value = "초기화"/>
	</form>

	<?php
	include "./common/footer.html";
	?>
</body>
</html>