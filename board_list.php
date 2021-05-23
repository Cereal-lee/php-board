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
	<table>
		<thead>
			<th>번호</th>
			<th>제목</th>
			<th>작성자</th>
			<th>게시일</th>
		</thead>
		<tbody>
			<?php
			//검색 옵션
				$searchKeyword = $_GET["searchKeyword"];
				$searchOption = $_GET["option"];
		
				switch ($searchOption){
					case 'title':
					case 'content':
					case 'torc':
						break;
					default:
						$searchOption = NULL;
						break;
				}
			//페이징
				if(isset($_GET["page"])){
					$page = (int) $_GET["page"];
				}
				else{
					$page = 1;
				}
				
				$numView = 10;
				$firstLimitValue = ($numView * $page) - $numView;

				$sql = "SELECT * FROM seum_php200_board ";
			//sql 검색 옵션에 따라 다르게 표시
				switch ($searchOption){
					case 'title':
						$sql .= "WHERE title LIKE '%{$searchKeyword}%'";
						break;
					case 'content':
						$sql .= "WHERE content LIKE '%{$searchKeyword}%'";
						break;
					case 'torc':
						$sql .= "WHERE title LIKE '%{$searchKeyword}%' OR content LIKE '%{$searchKeyword}%'";
						break;
				}

				$sql .= " ORDER BY boardID DESC LIMIT {$firstLimitValue},{$numView}";
			//db연동해서 값이 있으면 작동
				$res = $dbConnect -> query($sql);
			
				if($res){
					$dataCount = $res -> num_rows;

					if($dataCount > 0){
						for($i = 0; $i < $dataCount; $i++){
							$memberInfo = $res -> fetch_array(MYSQLI_ASSOC);

							echo "<tr>";
							echo "<td>".$memberInfo["boardID"]."</td>";
							//검색 옵션에 따라서 페이징되게
							if($searchOption == NULL){
								echo "<td><a href=./board_view.php?boardID={$memberInfo["boardID"]}&page={$page}>".$memberInfo["title"]."</a></td>";
							}
							else{
								echo "<td><a href=./board_view.php?boardID={$memberInfo["boardID"]}&page={$page}&searchKeyword={$searchKeyword}&option={$searchOption}>".$memberInfo["title"]."</a></td>";
							}
							echo "<td>".$memberInfo["nickname"]."</td>";
							echo "<td>".$memberInfo["regTime"]."</td>";
							echo "</tr>";

						}
					}
					else{
						echo "<tr><td colspan = '4'>게시글이 없습니다. </td></tr>";
					}
				}
			?>
		</tbody>
	</table>
	<div style = "text-align: center; margin-top: 2%; margin-bottom: 1%;">
		<?php
		//페이징 상세 - boardID의 갯수를 체크
			$sql = "SELECT count(boardID) FROM seum_php200_board ";

			$searchKeyword = $_GET["searchKeyword"];
			$searchOption = $_GET["option"];

		//검색옵션에 따라 boardID의 갯수를 체크
			switch ($searchOption){
				case 'title':
					$sql .= "WHERE title LIKE '%{$searchKeyword}%'";
					break;
				case 'content':
					$sql .= "WHERE content LIKE '%{$searchKeyword}%'";
					break;
				case 'torc':
					$sql .= "WHERE title LIKE '%{$searchKeyword}%' OR content LIKE '%{$searchKeyword}%'";
					break;
				default:
					$searchOption = NULL;
					break;
			}
		//db연동
			$res = $dbConnect -> query($sql);
		
			$boardTotalCount = $res -> fetch_array(MYSQLI_ASSOC);
			$boardTotalCount = $boardTotalCount['count(boardID)'];
		
			$totalPage = ceil($boardTotalCount / $numView);
		
			if($searchOption == NULL){
				echo "<a href = './board_list.php?page=1'>처음</a>&nbsp;";
			}else{
				echo "<a href = './board_list.php?searchKeyword={$searchKeyword}&option={$searchOption}&page=1'>처음</a>&nbsp;";
			}
		
			if($page != 1){
				$previousPage = $page - 1;
				if($searchOption == NULL){ //검색 옵션에 따라서 페이징되게
					echo "<a href = './board_list.php?page={$previousPage}'>이전</a>";
				}else{
					echo "<a href = './board_list.php?searchKeyword={$searchKeyword}&option={$searchOption}&page={$previousPage}'>이전</a>";
				}
			}
		//페이지 앞뒤 표시되는 양 ex) 3페이지 - 1 2 3(현재 페이지) 4 5 6 7 8
			$pageTerm = 5;
		//페이지가 처음부분 3페이지 상태면 -2 -1 0 1 2 3 앞에 다섯개 이상태
			$startPage = $page - $pageTerm;
		//1페이지가 첫 페이지이므로 1페이지보다 작아지면 1페이지까지만 표시되게 바꿈
			if($startPage < 1){
				$startPage = 1;
			}
		//라스트 페이지도 비슷한 느낌이지만 끝페이지는 전체 페이지수로 컨트롤
			$lastPage = $page + $pageTerm;
		
			if($lastPage >= $totalPage){
				$lastPage = $totalPage;
			}
		
			for($i = $startPage; $i <= $lastPage; $i++){
				$nowPageColor = "unset";
				if($i == $page){
					$nowPageColor = "hotpink";
				}
				if($searchOption == NULL){ //검색 옵션에 따라서 페이징되게
					echo "&nbsp<a href='./board_list.php?page={$i}'";
				}else{
					echo "&nbsp<a href='./board_list.php?searchKeyword={$searchKeyword}&option={$searchOption}&page={$i}'";
				}
				echo "style='color:{$nowPageColor}'>{$i}</a>&nbsp";
			}
		
			if($page != $totalPage){
				$nextPage = $page + 1;
				if($searchOption == NULL){ //검색 옵션에 따라서 페이징되게
					echo "<a href = './board_list.php?page={$nextPage}'>다음</a>";
				}else{
					echo "<a href = './board_list.php?searchKeyword={$searchKeyword}&option={$searchOption}&page={$nextPage}'>다음</a>";
				}
			}
		
			if($searchOption == NULL){
				echo "&nbsp;<a href = './board_list.php?page={$totalPage}'>끝</a>";
			}else{
				echo "&nbsp;<a href = './board_list.php?searchKeyword={$searchKeyword}&option={$searchOption}&page={$totalPage}'>끝</a>";
			}
		?>
	</div>
	<form name = "search" style ="text-align: center;" method = "GET" action = "./board_list.php">
		<input type = "text" name = "searchKeyword" placeholder = "검색어 입력" required/>
		<select name = "option" required>
			<option value = "title">제목</option>
			<option value = "content">내용</option>
			<option value = "torc">제목 또는 내용</option>
		</select>
		<input type = "submit" value = "검색" />
	</form>
	<a href="./board_edit.php" style="float: right; margin-right: 18%;">글 작성하기</a>
</section>
<?php
	include "./common/footer.html";
?>
</body>
</html>