	<link rel="stylesheet" type="text/css" href="./css/add.css" />
	<form name="LoginForm" method="post" action="./php/add.php?pro=<?=$_GET['pro']?>" onsubmit="return InputCheck(this)">
<?php 
    error_reporting(0);
	include 'conn.php';
	try {
		if(isset($_POST['stu-id']) && isset($_POST['stu-name']) && isset($_POST['stu-sex']) && isset($_POST['stu-Class']) && isset($_POST['stu-age'])){
			$mysqli_result = $mysqli->query("SELECT * FROM pro WHERE id = {$_GET['pro']}");
			$library = $mysqli_result->fetch_assoc();
			$mysqli_result = $mysqli->query("SELECT `stu_teacher` FROM {$library['pro_table']} WHERE `stu_class`='{$_POST['stu-Class']}'");
			$row = $mysqli_result->fetch_assoc();
			if(!empty($_POST['stu-tel'])){
				if($_SESSION['permissions']==3){
					$sql="INSERT INTO {$library['pro_table']} (`stu_id`, `stu_name`, `stu_sex`, `stu_class`, `stu_age`, `stu_tel`, `stu_teacher`) VALUES ('{$_POST['stu-id']}', '{$_POST['stu-name']}', '{$_POST['stu-sex']}', '{$_POST['stu-Class']}', '{$_POST['stu-age']}','{$_POST['stu-tel']}', '{$_SESSION['name']}')";
				}else{
					$sql="INSERT INTO {$library['pro_table']} (`stu_id`, `stu_name`, `stu_sex`, `stu_class`, `stu_age`, `stu_tel`, `stu_teacher`) VALUES ('{$_POST['stu-id']}', '{$_POST['stu-name']}', '{$_POST['stu-sex']}', '{$_POST['stu-Class']}', '{$_POST['stu-age']}','{$_POST['stu-tel']}', '{$row['stu_teacher']}')";
				}
			}else{
				if($_SESSION['permissions']==3){
					$sql="INSERT INTO {$library['pro_table']} (`stu_id`, `stu_name`, `stu_sex`, `stu_class`, `stu_age`, `stu_teacher`) VALUES ('{$_POST['stu-id']}', '{$_POST['stu-name']}', '{$_POST['stu-sex']}', '{$_POST['stu-Class']}', '{$_POST['stu-age']}', '{$_SESSION['name']}')";
				}else{
					$sql="INSERT INTO {$library['pro_table']} (`stu_id`, `stu_name`, `stu_sex`, `stu_class`, `stu_age`, `stu_teacher`) VALUES ('{$_POST['stu-id']}', '{$_POST['stu-name']}', '{$_POST['stu-sex']}', '{$_POST['stu-Class']}', '{$_POST['stu-age']}', '{$row['stu_teacher']}')";	
				}
			}
			$mysqli_result = $mysqli->query($sql);
			if($mysqli_result){
				exit("<script language='javascript'>alert('添加{$_POST['stu-name']}的数据成功！！');window.location.href='../index.php';</script>");
			}else{
				exit("<script language='javascript'>alert('添加数据失败！！');history.go(-1);</script>");
			}
		}
		if(!isset($_GET['pro']) || empty($_GET['pro'])){
			exit("<script language='javascript'>alert('请先选择系部！！');history.go(-1);</script>");
		}
		
		
		
	}catch(Exception $e) { 
		exit("<script language='javascript'>alert('添加数据失败！！');history.go(-1);</script>");
	}
	
	class add{
		
		function query_class(){
			include 'conn.php';
			$mysqli_result = $mysqli->query("SELECT * FROM pro WHERE id = {$_GET['pro']}");
			$row=$mysqli_result->fetch_assoc();
			if($_SESSION['permissions']==3){
				$sql = "SELECT stu_class,COUNT(*) number FROM {$row['pro_table']} WHERE stu_teacher='{$_SESSION['name']}' GROUP BY stu_class";
			}else{
				$sql = "SELECT stu_class,COUNT(*) number FROM {$row['pro_table']} GROUP BY stu_class";
			}
			$mysqli_result = $mysqli->query($sql);
			if($mysqli_result && $mysqli_result->num_rows>0) {
				while(($row=$mysqli_result->fetch_assoc())!= FALSE){
					$rows[]=$row;
				}
			}
			return $rows;
		}
	}
	$add = new add();
?>
		<div class="add">
			<div class="title"><span>添加学生信息</span></div>
			<div class="user-info">
				<div class="input">
					<span class="user-title">姓名</span>
					<input type="text" name="stu-name" class="input-base" />
				</div>
				<div class="input">
					<span class="user-title">年龄</span>
					<input type="text" name="stu-age" class="input-base" />
				</div>
				<div class="input">
					<span class="user-title">性别</span>
					<input type="radio" name="stu-sex" value="男"  class="user-radio"/> <label for="man">男</label>
					<input type="radio" name="stu-sex" value="女"  class="user-radio"/> <label for="wm">女</label>
				</div>
				<div class="input">
					<span class="user-title class-height">班级</span>
					<select name="stu-Class" class="input-base" >
						<?php $rows = $add->query_class();foreach($rows as $row):?>
							<option ><?=$row['stu_class']; ?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="input">
					<span class="user-title">学号</span>
					<input type="text" name="stu-id" class="input-base" />
				</div>
				<div class="input">
					<span class="user-title">电话</span>
					<input type="text" name="stu-tel" class="input-base" />
				</div>
				<div class="input-sub">
					<input type="submit" name="stu-sub" class="input-base zt"  value="添加学生到系统"/>
				</div>
			</div>
		</div>
	</form>