	<link rel="stylesheet" type="text/css" href="./css/add.css" />
	<form name="LoginForm" method="post" action="php/edit.php?pro=<?=$_GET['pro']?>&id=<?=$_GET['id']?>" onsubmit="return InputCheck(this)">
<?php 
    error_reporting(0);
	include 'conn.php';
	
	$mysqli_result = $mysqli->query("SELECT * FROM pro WHERE id = {$_GET['pro']}");
	$library = $mysqli_result->fetch_assoc();
	$mysqli_result = $mysqli->query("SELECT * FROM {$library['pro_table']} WHERE `id` = '{$_GET['id']}' ");
	$query_result = $mysqli_result->fetch_assoc();
	if(isset($_POST['stu-id']) && isset($_POST['stu-name']) && isset($_POST['stu-sex']) && isset($_POST['stu-Class']) && isset($_POST['stu-age'])){
		$mysqli_result = $mysqli->query("SELECT `stu_teacher` FROM {$library['pro_table']} WHERE `stu_class`='{$_POST['stu-Class']}'");
		$row = $mysqli_result->fetch_assoc();

		if(!empty($_POST['stu-tel'])){
			if($_SESSION['permissions']==3){
				$sql="UPDATE {$library['pro_table']} SET `stu_id`='{$_POST['stu-id']}', `stu_name`='{$_POST['stu-name']}', `stu_sex`='{$_POST['stu-sex']}', `stu_class`='{$_POST['stu-Class']}', `stu_age`='{$_POST['stu-age']}', `stu_tel`='{$_POST['stu-tel']}', `stu_teacher`='{$_SESSION['name']}' WHERE id = {$_GET['id']}";
			}else{
				$sql = "UPDATE {$library['pro_table']} SET `stu_id`='{$_POST['stu-id']}', `stu_name`='{$_POST['stu-name']}', `stu_sex`='{$_POST['stu-sex']}', `stu_class`='{$_POST['stu-Class']}', `stu_age`='{$_POST['stu-age']}', `stu_tel`='{$_POST['stu-tel']}', `stu_teacher`='{$row['stu_teacher']}' WHERE id = {$_GET['id']}";
			}
		}else{
			if($_SESSION['permissions']==3){
				$sql = "UPDATE {$library['pro_table']} SET `stu_id`='{$_POST['stu-id']}', `stu_name`='{$_POST['stu-name']}', `stu_sex`='{$_POST['stu-sex']}', `stu_class`='{$_POST['stu-Class']}', `stu_age`='{$_POST['stu-age']}', `stu_teacher`='{$_SESSION['name']}' WHERE id = {$_GET['id']}";
			}else{
				$sql = "UPDATE {$library['pro_table']} SET `stu_id`='{$_POST['stu-id']}', `stu_name`='{$_POST['stu-name']}', `stu_sex`='{$_POST['stu-sex']}', `stu_class`='{$_POST['stu-Class']}', `stu_age`='{$_POST['stu-age']}', `stu_teacher`='{$row['stu_teacher']}' WHERE id = {$_GET['id']}";
			}
		}
		$mysqli_result = $mysqli->query($sql);
		if($mysqli_result){
			exit("<script language='javascript'>alert('编辑{$_POST['stu-name']}的数据成功！！');history.go(-2);</script>");
		}else{
			exit("<script language='javascript'>alert('编辑数据失败！！');history.go(-2);</script>");
		}
	}elseif(!isset($_GET['pro']) || empty($_GET['pro'])){
		exit("<script language='javascript'>alert('请先选择系部！！');history.go(-2);</script>");
	}
	
	class edit{
		function query($sql){
			include 'conn.php';
			$mysqli_result = $mysqli->query($sql);
			$num = $mysqli_result->num_rows;
			
			if($mysqli_result && $mysqli_result->num_rows>0) {
				while(($row=$mysqli_result->fetch_assoc())!= FALSE){
					$rows[]=$row;
				}
			}
			return $rows;
		}
		
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
	$edit = new edit();
?>
		<div class="add">
			<div class="title"><span>添加学生信息</span></div>
			<div class="user-info">
				<div class="input">
					<span class="user-title">姓名</span>
					<input type="text" name="stu-name" class="input-base" value="<?=$query_result['stu_name'] ?>" />
				</div>
				<div class="input">
					<span class="user-title">年龄</span>
					<input type="text" name="stu-age" class="input-base" value="<?=$query_result['stu_age'] ?>" />
				</div>
				<div class="input">
					<span class="user-title">性别</span>
					<input type="radio" name="stu-sex" value="男" <?php if($query_result['stu_sex']=="男"){echo 'checked="checked"';}?> class="user-radio"/> <label for="man">男</label>
					<input type="radio" name="stu-sex" value="女" <?php if($query_result['stu_sex']=="女"){echo 'checked="checked"';}?> class="user-radio"/> <label for="wm">女</label>
				</div>
				<div class="input">
					<span class="user-title class-height">班级</span>
					<select name="stu-Class" class="input-base" >
						<?php $rows = $edit->query_class();foreach($rows as $row):?>
							<option ><?=$row['stu_class']; ?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="input">
					<span class="user-title">学号</span>
					<input type="text" name="stu-id" class="input-base" value="<?=$query_result['stu_id'] ?>" />
				</div>
				<div class="input">
					<span class="user-title">电话</span>
					<input type="text" name="stu-tel" class="input-base" value="<?=$query_result['stu_tel'] ?>" />
				</div>
				<div class="input-sub">
					<input type="submit" name="stu-sub" class="input-base zt"  value="添加学生到系统"/>
				</div>
			</div>
		</div>
	</form>