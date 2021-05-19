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
	if(isset($_GET['boardID']) && (int) $_GET['boardID'] > 0){
		$boardID = $_GET['boardID'];
		$page = $_GET['page'];
		$searchKeyword = $_GET["searchKeyword"];
		$searchOption = $_GET["option"];
		$sql = "SELECT * FROM seum_php200_board WHERE boardID = {$boardID}";
		$res = $dbConnect -> query($sql);

		if($res){
			$contentInfo = $res -> fetch_array(MYSQLI_ASSOC);
			echo "제목 : ".$contentInfo["title"]."<br>";
			echo "작성자 : ".$contentInfo["nickname"]."<br>";
			echo "게시일 : ".date("Y-m-d h:i", $contentInfo["regTime"])."<br>";
			echo "이미지 : <img src = './images/".$contentInfo["image"]."' width='100'/><br>";
			echo "본문 : ".nl2br($contentInfo["content"])."<br>";
			if($searchKeyword == null || $searchKeyword == ""){
				echo "<a href = './board_list.php?page={$page}'>목록으로 이동</a>";
			}
			else{
				echo "<a href = './searchResult.php?searchKeyword={$searchKeyword}&&option={$searchOption}&&page={$page}'>목록으로 이동</a>";
			}
			echo "<br><a href = '#'>수정</a>";
			echo "<a href = '#'>삭제</a>";
		}
		else{
			echo "잘못된 접근";
			exit;
		}
	}
	else{
		echo "잘못된 접근";
		exit;
	}
?>

<?php
	include "./common/footer.html";
?>
</body>
</html>