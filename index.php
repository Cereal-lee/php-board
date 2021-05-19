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
	<title>메인</title>

	<link rel="stylesheet" href="./css/my.css">
	<link rel="stylesheet" href="./css/main.css">
</head>
<body>
<?php
	include "./common/header.php";
?>
<section>
<h3> link list </h3>
	<?php
		if(!isset($_SESSION['myMemberID'])){
	?>
	<ul>
		<li><a href = "./regist.php">회원가입</a></li><br>
		<li><a href = "./login.php">로그인</a></li><br>
		<li><a href = "./board_list.php">게시판</a></li><br>
	<?php
		}else{
	?>
		<li><a href = "./logout.php">로그아웃</a></li><br>
	<?php
		}
	?>
	</ul>
</section>
<?php
	include "./common/footer.html";
?>
</body>
</html>