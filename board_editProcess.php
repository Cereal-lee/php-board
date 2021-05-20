<?php
	include_once("./_common.php");
	include "./session.php";
	include "./connectDB.php";

	print_r($_FILES);

	$target_dir = "./images/"; //폴더 있음
	$target_file = $_FILES['imgFile']['name'];
	$myTempFile = $_FILES['imgFile']['tmp_name'];

	$fileTypeExtension = explode("/", $_FILES['imgFile']['type']);

	$fileType = $fileTypeExtension[0];
	$extension = $fileTypeExtension[1];

	echo "target_dir은 ".$target_dir;
	echo "<br>";
	echo "target_file은 ".$target_file;
	echo "<br>";
	echo "myTempFile은 ".$myTempFile;
	echo "<br>";
	echo "fileType은 ".$fileType;
	echo "<br>";
	echo "extension은 ".$extension;
	echo "<br>";

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
			$myFile = $target_dir.$target_file;
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

	$page = $_POST['page'];
	$boardID = $_POST['boardID'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$image = $target_file;
	$nickname = $_POST['nickname'];
	$password = $_POST['password'];
	$regTime = time();

	if(isset($_SESSION['nickname'])){
		$nickname = $_SESSION['nickname'];
	}

	$sql = "UPDATE seum_php200_board SET title = '{$title}' , content = '{$content}' , image = '{$image}' , nickname = '{$nickname}' , password = '{$password}' , regTime = '{$regTime}'";
	$sql .= "WHERE boardID = '{$boardID}'";
	$res = $dbConnect -> query($sql);

	if($res){
		Header("Location:./board_view.php?boardID={$boardID}&&page={$page}");
	}
	else{
		echo "ERROR";
		exit;
	}

?>
