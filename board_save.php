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




	$title = $_POST['title'];
	$content = $_POST['content'];
	$image = $target_file;
	$nickname = $_POST['nickname'];
	$password = $_POST['password'];
	$myMemberID = $_POST['myMemberID'];
	$regTime = time();

	if($myMemberID != 0){
		
		$sql = "INSERT INTO seum_php200_board (nickname, password, title, content, regTime, image , myMemberID) ";
		$sql .= "VALUES ('{$nickname}', '{$password}', '{$title}', '{$content}', {$regTime} ,'{$image}' , '{$myMemberID}')";
		$res = $dbConnect -> query($sql);

		if($res){
			Header("Location:./board_list.php");
		}
		else{
			echo "ERROR";
			exit;
		}
	}
	else{
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
	}


?>