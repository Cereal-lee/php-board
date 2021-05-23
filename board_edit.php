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
	$boardID = $_POST['boardID'];
	$page = $_POST['page'];
	$sql = "SELECT * FROM seum_php200_board ";
	$sql .= "WHERE boardID = {$boardID}";
	$res = $dbConnect -> query($sql);

	//등록 수정 구분
	if($res){
		$contentInfo = $res -> fetch_array(MYSQLI_ASSOC);
	}
?>

<section>
	<form name = "write" method = "POST" action = "./board_ps.php" enctype="multipart/form-data">
		<input type = "hidden" name = "mode" value = "<?=$res ? 'edit' : 'save'?>" />
		 제목
		 <br>
		 <input type = "text" name = "title" value = "<?php echo $contentInfo["title"] ?>" required/>
		 <br>
		 닉네임
		 <br>
		 <?php 
		//로그인 여부에 따라서 수정 로그인하면 회원정보가 있으니 수정할 때 닉네임 바꿀수 없게
		 if(!isset($_SESSION['myMemberID'])){ 
		 ?>
		 <input type = "text" name = "nickname" value = "<?php echo $contentInfo["nickname"] ?>" required/>
		 <br>
		 비밀번호

		 <br>
		 <input type = "password" name = "password" value = "<?php echo $contentInfo["password"] ?>" required/>
		 
		 <?php }else{ ?>

		 <input type = "text" name = "nickname" value = "<?php echo $contentInfo["nickname"] ?>" readonly />
		 
		 <input type = "hidden" name = "password"  value = "<?php echo $contentInfo["password"] ?>"/>
		 
		 <?php } ?>

		 <br><br>
		 내용
		 <br><br>
		 <textarea name = "content" cols = "80" rows = "10" required>
			 <?php
			 	echo $contentInfo["content"];
			 ?>
		 </textarea>
		 <br><br>
		 <input type="hidden" name="image" value="<?=$contentInfo[image]?>">
		 <input type="file" name="imgFile"></input>
		 <br><br>
		 <input type = "hidden" name = "boardID" value = "<?php echo $boardID;?>"/>
		 <input type = "hidden" name = "page" value = "<?php echo $page;?>"/>
		 <input type = "submit" value = "저장" />
	</form>
</section>

<?php
	include "./common/footer.html";
?>
</body>
</html>