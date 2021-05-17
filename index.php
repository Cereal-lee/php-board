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
	<title>Document</title>

	<link rel="stylesheet" href="./css/my.css">
	<link rel="stylesheet" href="./css/main.css">
</head>
<body>
<?php
	include "./common/header.html";
?>
<section>
<h3> link list </h3>
	<?php
		if(!isset($_SESSION['memberID'])){
	?>
	<ul>
		<li><a href = "#">회원가입</a></li><br>
		<li><a href = "#">로그인</a></li><br>
		<li><a href = "#">게시판</a></li><br>
	<?php
		}else{
	?>
		<li><a href = "#">로그아웃</a></li><br>
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