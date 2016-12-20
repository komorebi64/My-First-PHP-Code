<?php 
	$title="后台账号管理";
	$cssname="add";
	include 'php/head.php';
	
	echo $_POST['username'].$_POST['name'].$_POST['newpassword'].$_POST['passwordAgain'];
	if(isset($_POST['username']) && isset($_POST['name']) && isset($_POST['newpassword']) && isset($_POST['passwordAgain'])){
		$mysqli_result = $mysqli->query("UPDATE `admin` SET `password` = md5('{$_POST['newpassword']}') WHERE `username` = '{$_SESSION['username']}'");
		if($mysqli_result){
			exit("<script language='javascript'>alert('修改登录密码成功');window.location.href='logout.php';</script>");
		}
	}
	
?>
<form name="LoginForm" method="post" action="account.php" onsubmit="return InputCheck(this)">
       <div class="add">
            <div class="title"><span>修改管理员账户信息</span></div>
            <div class="user-info">
               <div class="input">
                   <span class="user-title">用户名</span>
                   <input type="text" name="username" class="input-base" value="<?=$_SESSION['username'] ?>" onfocus=this.blur() />
               </div>
               <div class="input">
                   <span class="user-title">姓&nbsp;名</span>
                   <input type="text" name="name" class="input-base" value="<?=$_SESSION['name'] ?>"  onfocus=this.blur() />
               </div>
               <div class="input">
                   <span class="user-title">&nbsp;新密码</span>
                   <input type="password" name="newpassword" class="input-base" />
               </div>
               <div class="input">
                   <span class="user-title">确认密码</span>
                   <input type="password" name="passwordAgain" class="input-base" />
               </div>
               <div class="input-sub">
                   <input type="submit" name="user-tel" class="input-base zt"  value="修改管理员信息"/>
               </div>
            </div>
       </div>
<?php include 'php/foot.php'; ?>
