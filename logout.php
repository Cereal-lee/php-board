<?php
	include_once("./_common.php");
	include "./session.php";

	session_destroy();
	Header("Location:./index.php");
?>