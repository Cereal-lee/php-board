<?php
	include_once("./_common.php");
	include "./session.php";
	include "./connectDB.php";

	//mode를 통해서 받는 것에 따라 처리하는 것을 다르게 함
	if($_GET['mode']){
		$mode = $_GET['mode'];
	}else{
		$mode = $_POST['mode'];
	}

	switch($mode){
		case 'login': //로그인
			$userID = $_POST["userID"];
			$password = $_POST["password"];

			function goLogin($alert = null){
				echo $alert."<br>";
				echo "<a href='./login.php'>로그인 폼으로 이동</a>";
				return;
			}

			$sql = "SELECT nickname, myMemberID FROM seum_php200_myMember WHERE userID = '{$userID}' AND password = '{$password}'";
			$res = $dbConnect -> query($sql);
			
			if($res){
				$count = $res -> num_rows;
				if($count == 0){
					goLogin("로그인 정보가 일치하지 않습니다.");
					exit;
				}
				else{
					$memberInfo = $res -> fetch_array(MYSQLI_ASSOC);
					$_SESSION["myMemberID"] = $memberInfo["myMemberID"];
					$_SESSION["nickname"] = $memberInfo["nickname"];
					Header("Location:./index.php");
				}
			}
			break;
		
		case 'edit':  //수정

			if(!$_POST['image'] || $_FILES['imgFile']['name']){

				$target_dir = "./images/"; 
				$target_file = $_FILES['imgFile']['name'];
				$myTempFile = $_FILES['imgFile']['tmp_name'];

				$fileTypeExtension = explode("/", $_FILES['imgFile']['type']);

				$fileType = $fileTypeExtension[0];
				$extension = $fileTypeExtension[1];

				$isExtGood = false;
				
				//확장자를 통해서 그림파일만 가능하게
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
						//업로드 하는 방법
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
				
				$image = $target_file;

			}else{
				$image = $_POST['image'];
			}

			$page = $_POST['page'];
			$boardID = $_POST['boardID'];
			$title = $_POST['title'];
			$content = $_POST['content'];
			$nickname = $_POST['nickname'];
			$password = $_POST['password'];
			
			
				$sql = "UPDATE seum_php200_board SET title = '{$title}' , content = '{$content}' , image = '{$image}' , nickname = '{$nickname}' , password = '{$password}' , regTime = now()";
				$sql .= "WHERE boardID = '{$boardID}'";
				$res = $dbConnect -> query($sql);

				if($res){
					Header("Location:./board_view.php?boardID={$boardID}&&page={$page}");
				}
				else{
					echo "ERROR";
					exit;
				}
				
			break;

		case 'save':  //저장
			$target_dir = "./images/"; //폴더 있음
			$target_file = $_FILES['imgFile']['name'];
			$myTempFile = $_FILES['imgFile']['tmp_name'];

			$fileTypeExtension = explode("/", $_FILES['imgFile']['type']);

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
			

			if($myMemberID != 0){
				
				$sql = "INSERT INTO seum_php200_board (nickname, password, title, content, regTime, image , myMemberID) ";
				$sql .= "VALUES ('{$nickname}', '{$password}', '{$title}', '{$content}', now() ,'{$image}' , '{$myMemberID}')";
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
				$sql .= "VALUES ('{$nickname}', '{$password}', '{$title}', '{$content}', now() ,'{$image}')";
				$res = $dbConnect -> query($sql);

				if($res){
					Header("Location:./board_list.php");
				}
				else{
					echo "ERROR";
					exit;
				}
			}
			break;

		case 'regist':  //회원등록
			$userID = $_POST["userID"];
			$name = $_POST["name"];
			$password = $_POST["password"];
			$phone = $_POST["phone"];
			$email = $_POST["email"];
			$birthday = $_POST["birthYear"]."-".$_POST["birthMonth"]."-".$_POST["birthDay"];
			$gender = $_POST["gender"];
			$nickname = $_POST["nickname"];

			function goRegist($alert = null){
				echo $alert."<br>";
				echo "<a href='./regist.php'>회원가입 폼으로 이동</a>";
				return;
			}

			//id check
			$isIDCheck = false;
			$sql = "SELECT userID FROM seum_php200_myMember WHERE userID = '{$userID}'";
			$res = $dbConnect -> query($sql);

			if($res){
				$count = $res -> num_rows;
				if($count == 0){
					$isIDCheck = true;
				}
				else{
					echo "이미 존재하는 아이디입니다.";
					goRegist();
					exit;
				}
			}
			else{
				echo "ERROR";
				exit;
			}

			//email check
			if(!filter_Var($email, FILTER_VALIDATE_EMAIL)){
				goRegist("올바른 이메일이 아닙니다.");
				exit;
			}

			$isEmailCheck = false;
			$sql = "SELECT email FROM seum_php200_myMember WHERE email = '{$email}'";
			$res = $dbConnect -> query($sql);

			if($res){
				$count = $res -> num_rows;
				if($count == 0){
					$isEmailCheck = true;
				}
				else{
					echo "이미 존재하는 이메일입니다.";
					goRegist();
					exit;
				}
			}
			else{
				echo "ERROR";
				exit;
			}

			//email , id 중복 안되면 생성가능
			if($isEmailCheck == true && $isIDCheck == true){
				$sql = "INSERT INTO seum_php200_myMember (";
				$sql .= "userID, name, password, phone, email, birthday, gender, nickname) ";
				$sql .= "VALUES ('{$userID}','{$name}','{$password}','{$phone}','{$email}','{$birthday}','{$gender}','{$nickname}')";

				$res = $dbConnect -> query($sql);

				if($res){
					$_SESSION["myMemberID"] = $dbConnect -> insert_id;
					$_SESSION["nickname"] = $nickname;
					Header("Location:./index.php");
				}
				else{
					echo "ERROR";
					exit;
				}
			}
			else{
				goRegist("이메일 또는 닉네임이 중복값입니다.");
				exit;
			}
			break;
		
		case 'delete':  //삭제
			$boardID = $_POST['boardID'];
			echo "boardID = ".$boardID;
			$sql = "DELETE FROM seum_php200_board WHERE boardID = {$boardID}";
			$res = $dbConnect -> query($sql);

			if($res){
				Header("Location:./board_list.php");
			}
			else{
				echo "ERROR";
			}
			break;

	}


?>