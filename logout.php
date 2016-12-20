<?php
	session_start();
	if(isset($_SESSION['isLogin'])){
		$_SESSION = array();
		session_destroy();
		echo("<script language='javascript'>alert('注销登录成功！');window.location.href='./';</script>");
	}else{
		header("Location:login.html");
		exit();
	}
?>