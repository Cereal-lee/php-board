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

<?php
if(!isset($_SESSION['myMemberID'])){
	$boardID = $_POST['boardID'];
	$page = $_POST['page'];
	$sql = "SELECT * FROM seum_php200_board WHERE boardID = {$boardID}";
	$res = $dbConnect -> query($sql);

	if($res){
		$contentInfo = $res -> fetch_array(MYSQLI_ASSOC);
?>

<section>
	<form name = "write" method = "POST" action = "./board_editProcess.php" enctype="multipart/form-data">
		 제목
		 <br>
		 <input type = "text" name = "title" value = "<?php echo $contentInfo["title"] ?>" required/>
		 <br>
		 닉네임
		 <br>
		 <input type = "text" name = "nickname" value = "<?php echo $contentInfo["nickname"] ?>" required/>
		 <br>
		 비밀번호
		 <br>
		 <input type = "password" name = "password" value = "<?php echo $contentInfo["password"] ?>" required/>
		 <br><br>
		 내용
		 <br><br>
		 <textarea name = "content" cols = "80" rows = "10" required>
			 <?php
			 	echo $contentInfo["content"];
			 ?>
		 </textarea>
		 <br><br>
		 <input type="file" name="imgFile"></input>
		 <br><br>
		 <input type = "hidden" name = "boardID" value = "<?php echo $boardID;?>"/>
		 <input type = "hidden" name = "page" value = "<?php echo $page;?>"/>
		 <input type = "submit" value = "저장" />
	</form>
</section>

<?php 
	}
}else{
	$boardID = $_POST['boardID'];
	$page = $_POST['page'];
	$sql = "SELECT * FROM seum_php200_board WHERE boardID = {$boardID}";
	$res = $dbConnect -> query($sql);

	if($res){
		$contentInfo = $res -> fetch_array(MYSQLI_ASSOC);
?>
	
<section>
	<form name = "write" method = "POST" action = "./board_editProcess.php" enctype="multipart/form-data">
		 제목
		 <br>
		 <input type = "text" name = "title" value = "<?php echo $contentInfo["title"] ?>" required/>
		 <br>
		 닉네임
		 <br>
		 <input type = "text" name = "nickname" value = "<?php echo $contentInfo["nickname"] ?>" readonly />
		 
		 <input type = "hidden" name = "password"  value = "<?php echo $contentInfo["password"] ?>"/>
		 <br><br>
		 내용
		 <br><br>
		 <textarea name = "content" cols = "80" rows = "10" required>
		 	<?php
			 	echo $contentInfo["content"];
			 ?>
		 </textarea>
		 <br><br>
		 <input type="file" name="imgFile" />
		 <br><br>
		 <input type = "hidden" name = "boardID" value = "<?php echo $boardID;?>"/>
		 <input type = "hidden" name = "page" value = "<?php echo $page;?>"/>
		 <input type = "submit" value = "저장" />
	</form>
</section>

<?php
	}
}
?>

<?php
	include "./common/footer.html";
?>
</body>
</html>