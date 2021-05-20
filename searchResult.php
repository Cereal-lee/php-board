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
	<?php
		$searchKeyword = $_GET["searchKeyword"];
		$searchOption = $_GET["option"];

		if($searchKeyword == '' || $searchKeyword == null){
			echo "검색어가 없습니다.";
			exit;
		}

		switch ($searchOption){
			case 'title':
			case 'content':
			case 'tandc':
			case 'torc':
				break;
			default:
				echo "검색 옵션이 없습니다.";
				exit;
				break;
		}

		if(isset($_GET["page"])){
			$page = (int) $_GET["page"];
		}
		else{
			$page = 1;
		}
		
		$numView = 10;
		$firstLimitValue = ($numView * $page) - $numView;

		$sql = "SELECT * FROM seum_php200_board ";

		switch ($searchOption){
			case 'title':
				$sql .= "WHERE title LIKE '%{$searchKeyword}%'";
				break;
			case 'content':
				$sql .= "WHERE content LIKE '%{$searchKeyword}%'";
				break;
			case 'tandc':
				$sql .= "WHERE title LIKE '%{$searchKeyword}%' AND content LIKE '%{$searchKeyword}%'";
				break;
			case 'torc':
				$sql .= "WHERE title LIKE '%{$searchKeyword}%' OR content LIKE '%{$searchKeyword}%'";
				break;
		}

		$sql .= " ORDER BY boardID DESC LIMIT {$firstLimitValue},{$numView}";

		$res = $dbConnect -> query($sql);
		if($res){
			$dataCount = $res -> num_rows;
		}
		else{
			echo "ERROR";
			exit;
		}
	?>
	<table>
		<thead>
			<th>번호</th>
			<th>제목</th>
			<th>작성자</th>
			<th>게시일</th>
		</thead>
		<tbody>
			<?php
				if($dataCount > 0){
					for($i = 0; $i < $dataCount; $i++){
						$memberInfo = $res -> fetch_array(MYSQLI_ASSOC);

						echo "<tr>";
						echo "<td>".$memberInfo["boardID"]."</td>";
						echo "<td><a href=./board_view.php?boardID={$memberInfo["boardID"]}&&page={$page}&&searchKeyword={$searchKeyword}&&option={$searchOption}>".$memberInfo["title"]."</a></td>";
						echo "<td>".$memberInfo["nickname"]."</td>";
						echo "<td>".date("Y-m-d H:i", $memberInfo["regTime"])."</td>";
						echo "</tr>";

					}
				}
				else{
					echo "<tr><td colspan = '4'>{$searchKeyword}를 포함하는 게시글이 없습니다. </td></tr>";
				}
			?>
		</tbody>
	</table>
	<div style = "text-align: center; margin-top: 2%; margin-bottom: 1%;">
		<?php
			if($dataCount > 0){
				include "./searchPaging.php";
			}
		?>
	</div>
	<form name = "search" style ="text-align: center;" method = "GET" action = "./searchResult.php">
		<input type = "text" name = "searchKeyword" placeholder = "검색어 입력" required/>
		<select name = "option" required>
			<option value = "title">제목</option>
			<option value = "content">내용</option>
			<option value = "tandc">제목과 내용</option>
			<option value = "torc">제목 또는 내용</option>
		</select>
		<input type = "submit" value = "검색" />
	</form>
	<a href="#" style="float: right; margin-right: 18%;">글 작성하기</a>
</section>
<?php
	include "./common/footer.html";
?>
</body>
</html>