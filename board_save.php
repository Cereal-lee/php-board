<?php
	include_once("./_common.php");
	include "./session.php";
	include "./connectDB.php";


	$myTempFile = $_FILES['image']['tmp_name'];

	$fileTypeExtension = explode("/", $_FILES['image']['type']);

	$fileType = $fileTypeExtension[0];
	$extension = $fileTypeExtension[1];

	$isExtGood = false;
	
	switch($extension){
		case 'jpeg':
		case 'bmp':
		case 'gif':
		case 'png':
			$isExtGood = true;
			break;
		default :
			echo "확장자는 jpg, bmp, gif, png만 지원합니다.";
			exit;
			break;
	}

	if($fileType == "image"){
		if($isExtGood){
			$myFile = "./happyCat.{$extension}";
			$imageUpload = move_uploaded_file($myTempFile, $myFile);

			if($imageUpload == true){
				echo "파일이 정상적으로 업로드 되었습니다.<br>";
				echo "<img src='{$myFile}' width = '100'/>";
			}
			else{
				echo "업로드 실패";
			}
		}
		else{
			echo "확장자는 jpg, bmp, gif, png만 지원합니다.";
			exit;
		}
	}
	else{
		echo "이미지 파일이 아닙니다.";
		exit;
	}



	$title = $_POST['title'];
	$content = $_POST['content'];
	$image = $_POST['image'];
	$nickname = "ㅇㅇ";
	$password = "1234";

	if(isset($_SESSION['nickname'])){
		$nickname = $_SESSION['nickname'];
	}

	$regTime = time();

	$sql = "INSERT INTO seum_php200_board (nickname, password, title, content, regTime, image) ";
	$sql .= "VALUES ('{$nickname}', '{$password}', '{$title}', '{$content}', {$regTime} ,'{$image}')";
	$res = $dbConnect -> query($sql);

	if($res){
		Header("Location:./board_list.php");
	}
	else{
		echo "ERROR";
		exit;
	}

?>