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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="./css/my.css">
	<link rel="stylesheet" href="./css/main.css">
</head>
<body>
<?php
	include "./common/header.php";
?>

<?php
//게시판에 게시글 보유 여부
if(isset($_GET['boardID']) && (int) $_GET['boardID'] > 0){
	$boardID = $_GET['boardID'];
	$page = $_GET['page'];
	$searchKeyword = $_GET["searchKeyword"];
	$searchOption = $_GET["option"];
	$sql = "SELECT * FROM seum_php200_board WHERE boardID = {$boardID}";
	$res = $dbConnect -> query($sql);
//db연동
	if($res){
		$contentInfo = $res -> fetch_array(MYSQLI_ASSOC);
		echo "제목 : ".$contentInfo["title"]."<br>";
		echo "작성자 : ".$contentInfo["nickname"]."<br>";
		echo "게시일 : ".$contentInfo["regTime"]."<br>";
		echo "이미지 : <br><img src = './images/".$contentInfo["image"]."' width='100'/><br>";
		echo "본문 : <br>".nl2br($contentInfo["content"])."<br>";
	//검색 여부
		if($searchKeyword == null || $searchKeyword == ""){
			echo "<a href = './board_list.php?page={$page}'>목록으로 이동</a>";
		}
		else{
			echo "<a href = './board_list.php?searchKeyword={$searchKeyword}&&option={$searchOption}&&page={$page}'>목록으로 이동</a>";
		}
	//회원 비회원이 쓴 게시글 구분
		if($contentInfo["myMemberID"] == NULL ){
		?>
			<br><br>
			<input type = "password" id = "password" placeholder = "비밀번호 입력" />
		<?php 
		} else{ 
	//회원이 쓴 글은 자신만 수정 및 삭제 가능하게
			if($contentInfo["myMemberID"] == $_SESSION['myMemberID']){
		?>
			<br><br>
			<input type = "hidden" id = "password" value ="<?php echo $contentInfo["password"];?>" />
		<?php 
		}else{
		?>
			<input type = "hidden" id = "password" value ="NULL" />
		<?php
			}
		}
		?>
			<br>
			<br>

			<form name = "edit" method = "POST" action = "./board_edit.php">
				<input type = "submit" value = "수정" id = "edit"></input>
				<input type = "hidden" id = "passwordCheck" value ="<?php echo $contentInfo["password"];?>"/>
				<input type = "hidden" name = "boardID" value = "<?php echo $boardID;?>"/>
				<input type = "hidden" name = "page" value = "<?php echo $page;?>"/>
			</form>
			<form name = "delete" method = "POST" action = "./board_ps.php">
				<input type = "hidden" name = "mode" value = "delete" />
				<input type = "submit" value = "삭제" id = "delete"></input>
				<input type = "hidden" id = "passwordCheck" value ="<?php echo $contentInfo["password"];?>"/>
				<input type = "hidden" name = "boardID" value = "<?php echo $boardID;?>"/>
			</form>
		<?php
	}else{
		echo "잘못된 접근";
		exit;
	}
}else{
	echo "잘못된 접근";
	exit;
}
?>



<?php
	include "./common/footer.html";
?>
</body>

<script>

	$("#delete").click(function(){
		var pw = document.getElementById("password").value;
		var pwCheck = document.getElementById("passwordCheck").value;

		if (pw != pwCheck){
			alert("권한이 없습니다")
			return false;
		}
		else{
			var del = confirm("정말로 삭제하시겠습니까?")

			if(del){
				alert("삭제 완료되었습니다")
			}
			else{
				alert("취소 되었습니다")
				return false;
			}
		}
	})

	$("#edit").click(function(){
		var pw = document.getElementById("password").value;
		var pwCheck = document.getElementById("passwordCheck").value;
		if (pw != pwCheck){
			alert("권한이 없습니다")
			return false;
		}
	})
</script>
</html>
