<?php
	include_once("./_common.php");

	$sql = "SELECT count(boardID) FROM seum_php200_board ";

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

	$res = $dbConnect -> query($sql);

	$boardTotalCount = $res -> fetch_array(MYSQLI_ASSOC);
	$boardTotalCount = $boardTotalCount['count(boardID)'];

	$totalPage = ceil($boardTotalCount / $numView);

	if($page != 1){
		$previousPage = $page - 1;
		echo "<a href = './searchResult.php?searchKeyword={$searchKeyword}&&option={$searchOption}&&page={$previousPage}'>이전</a>";
	}

	$pageTerm = 5;

	$startPage = $page - $pageTerm;
	
	if($startPage < 1){
		$startPage = 1;
	}

	$lastPage = $page + $pageTerm;

	if($lastPage >= $totalPage){
		$lastPage = $totalPage;
	}

	for($i = $startPage; $i <= $lastPage; $i++){
		$nowPageColor = "unset";
		if($i == $page){
			$nowPageColor = "hotpink";
		}
		echo "&nbsp<a href='./searchResult.php?searchKeyword={$searchKeyword}&&option={$searchOption}&&page={$i}'";
		echo "style='color:{$nowPageColor}'>{$i}</a>&nbsp";
	}

	if($page != $totalPage){
		$nextPage = $page + 1;
		echo "<a href = './searchResult.php?searchKeyword={$searchKeyword}&&option={$searchOption}&&page={$nextPage}'>다음</a>";
	}

?>