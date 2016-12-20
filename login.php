<?php
	session_start();
	error_reporting(0);
	include 'php/conn.php';
	if(isset($_SESSION['isLogin'])){
		mysqli_close();
		header("Location:index.php");
		exit();
	}
	if(isset($_POST['username']) && isset($_POST['password'])){
			$username = htmlspecialchars($_POST['username']);
			$password = MD5($_POST['password']);
			$mysqli_result = $mysqli->query("SELECT * FROM admin WHERE username='$username' and password='$password' limit 1");
			$row=$mysqli_result->fetch_assoc();
			$num=$mysqli_result->num_rows;
			if($num){
				$_SESSION['name'] = $row['name'];				//保存名字
				$_SESSION['username'] = $username;				//登录用户
				$_SESSION['permissions'] = $row['permissions'];	//权限
				if(isset($row['pro'])){							//管理系部
					$_SESSION['pro']=$row['pro'];
				}
				$_SESSION['isLogin'] = 1;
				switch ($_SESSION['permissions']){
					case 1:
						$_SESSION['$level']="校长";
						break;
					case 2:
						$_SESSION['$level']="系主任";
						break;
					case 3:
						$_SESSION['$level']="辅导员";
						break;
				}
				mysqli_close();
				exit("<script language='javascript'>alert('{$_SESSION['$level']}:{$_SESSION['name']}您好，欢迎登录本系统！');window.location.href='index.php';</script>");
			} else {
				mysqli_close();
				exit("<script language='javascript'>alert('登录后台失败！密码错误请注意大小写');history.back(-1);</script>");
			}
	}
?>
	
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
            <title>后台登陆</title>
            <link href="./images/favicon.ico" rel="icon" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/login.css" />
    </head>
    <body class="login-body">
        <div class="login">
            <h1>成都五月花计算机专业学校</h1>
            <form name="LoginForm" method="post" action="login.php" onsubmit="return InputCheck(this)">
                用户名:<input type="text" name="username" /> <br />
                密 &nbsp;码:<input type="password" name="password" /> <br />
                <input type="submit" class="sub"  value="登录"/>
            </form>
            <div class="copyright">
                <span>Copyright&nbsp;&copy;&nbsp;Hrx&Zmh</span> <br />
            </div>
        </div>
    </body>
</html>
