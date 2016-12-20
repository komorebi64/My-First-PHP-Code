<?php 
	session_start();
	error_reporting(0);

	if(!isset($_SESSION['isLogin']) && !$_SESSION['isLogin']==1) {
		header("Location:login.php");
		exit();
	}
	include 'conn.php';
	if($_SESSION['permissions']==1 || $_SESSION['permissions']==2){
		$pro=$_GET['pro'];
	}elseif($_SESSION['permissions']==3){
		$pro=$_SESSION['pro'];
	}
	$username=$_SESSION['username'];
	$permissions=$_SESSION['permissions'];
	
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?=$title?></title>
    <link href="./images/favicon.ico" rel="icon" type="image/x-icon">
    <?php if(isset($cssname)){?>
    	<link rel="stylesheet" type="text/css" href="./css/<?=$cssname ?>.css" />
    <?php }?>	
    <link rel="stylesheet" type="text/css" href="./css/base.css" />
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
</head>
<body>
    <div class="nav">
        <a href="index.php">
            <img src="./images/logo.png" height="77" width="590" alt="" />
        </a>
        <ul>
            <li>
                <marquee direction="left" scrolldelay="1">欢迎您:<span><?=$_SESSION['name'] ?></span> 职位:<span><?=$_SESSION['$level']; ?></span></marquee>
            </li>
            <li class="gd"></li>
            <li class="icon1">
                <a href="./index.php" class="stu-info">学生信息管理</a>
                <div class="add-info">
                     <a href="Information.php?my=add&pro=<?php if(isset($pro)){echo $pro;}else{echo $_SESSION['pro'];}?>">添加信息</a>
                </div>
            </li>
            <li class="icon2">
                <a href="account.php">后台账户管理</a>
            </li>
            <li class="icon3">
                <a href="logout.php">退出管理系统</a>
            </li>
        </ul>
    </div>
