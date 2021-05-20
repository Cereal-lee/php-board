<?php
	include_once("./_common.php");
	include "./session.php";
	include "./connectDB.php";

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

?>
