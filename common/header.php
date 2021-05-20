<header>
    <hgroup>
        <h1>게시판</h1>
    </hgroup>
</header>


<nav>
    <ul>
        <li> <a href="./index.php"> Home </a> </li>
        <li> <a href="./board_list.php"> Board </a> </li>
        <?php
		    if(!isset($_SESSION['myMemberID'])){
	    ?>
        <li> <a href="./login.php"> Login</a> </li>
        <li> <a href="./regist.php"> Regist</a> </li>

        <?php
            }else{
        ?>
        <li> <a href="./logout.php"> LogOut</a> </li>
        <p style="margin-right: 2%;"> <?php echo $_SESSION['nickname']; ?>님</p>
        <?php
		    }
    	?>
    </ul>
</nav>