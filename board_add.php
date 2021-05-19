<?php
	include_once("./_common.php");
	include "./session.php";
	include "./connectDB.php";
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
	<form name = "write" method = "POST" action = "./board_save.php" enctype="multipart/form-data">
		 제목
		 <br><br>
		 <input type = "text" name = "title" required/>
		 <br><br>
		 내용
		 <br><br>
		 <textarea name = "content" cols = "80" rows = "10" required></textarea>
		 <br><br>
		 <input type = "file" name = "image"/>
		 <br><br>
		 <input type = "submit" value = "저장" />
	</form>
</section>

<?php
	include "./common/footer.html";
?>
</body>
</html>