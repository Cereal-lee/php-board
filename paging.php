<?php
	include_once("./_common.php");

	$sql = "SELECT count(boardID) FROM seum_php200_board";
	$res = $dbConnect -> query($sql);

	$boardTotalCount = $res -> fetch_array(MYSQLI_ASSOC);
	$boardTotalCount = $boardTotalCount['count(boardID)'];

	$totalPage = ceil($boardTotalCount / $numView);

	echo "<a href = './board_list.php?page=1'>처음</a>&nbsp;";

	if($page != 1){
		$previousPage = $page - 1;
		echo "<a href = './board_list.php?page={$previousPage}'>이전</a>";
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
		echo "&nbsp<a href='./board_list.php?page={$i}'";
		echo "style='color:{$nowPageColor}'>{$i}</a>&nbsp";
	}

	if($page != $totalPage){
		$nextPage = $page + 1;
		echo "<a href = './board_list.php?page={$nextPage}'>다음</a>";
	}

	echo "&nbsp;<a href = './board_list.php?page={$totalPage}'>끝</a>";
?>