<?php 
	$title="学生信息管理";
	$cssname="info";
	include 'php/head.php';
	
	$my=isset($_GET['my'])?$_GET['my']:null;
	if($_SESSION['permissions']==1){
		if(!isset($_GET['pro']) || empty($_GET['pro'])){
			exit("<script language='javascript'>alert('请先选择系部！！');window.location.href='index.php';</script>");
		}
	}
	
	class info{
		function query_class(){
			include 'php/conn.php';
			if($_SESSION['permissions']==1 || $_SESSION['permissions']==2){
				$pro=$_GET['pro'];			//获取需要查询的系部
				$class=$_GET['class'];
			}elseif($_SESSION['permissions']==3){
				$pro=$_SESSION['pro'];			//获取需要查询的系部
				$class=$_GET['class'];
			}
			$mysqli_result = $mysqli->query("SELECT * FROM pro WHERE id = {$pro}");
			$row=$mysqli_result->fetch_assoc();
			$mysqli_result = $mysqli->query("SELECT * FROM {$row['pro_table']} WHERE stu_class='{$class}'");
			
			$allcount=$mysqli_result->num_rows;
			$_SESSION['page'] = $page=$_GET['page'];
			$_SESSION['page'] = $page = isset($_GET['page'])?$_GET['page']:1;
			$page_size=10;
			
			$_SESSION['page_count'] = $page_count=ceil($allcount/$page_size);	//计算总页数
			if($page<=1 || $page==''){
				$page=1;
			}
			
			if($page>$page_count){
				$page=$page_count;
			}
			
			$select_from = ($page - 1) * $page_size;
			$_SESSION['pre_page'] = ($page == 1)? 1 : $page - 1;
			$_SESSION['next_page'] = ($page == $page_count)? $page_count : $page + 1 ;
			
			$mysqli_result = $mysqli->query("SELECT * FROM {$row['pro_table']} WHERE stu_class='{$class}' LIMIT ".$select_from.",".$page_size);
			
			if($mysqli_result && $mysqli_result->num_rows>0) {
				while(($row=$mysqli_result->fetch_assoc())!= FALSE){
					$rows[]=$row;
				}
			}
			mysqli_close();
			return $rows;
		}
		
		function show($rows){
			if($_SESSION['permissions']==1 || $_SESSION['permissions']==2){
				$pro=$_GET['pro'];			//获取需要查询的系部
			}elseif($_SESSION['permissions']==3){
				$pro=$_SESSION['pro'];			//获取需要查询的系部
			}
			echo '<table><tr><th class="title">学号</th><th class="title">名字</th><th class="title">性别</th><th class="title">班级</th><th class="title">年龄</th><th class="title">电话</th><th class="title">操作</th></tr>';
			foreach($rows as $row):
				echo '<tr class="gray">';
					echo "<td>{$row['stu_id']}</td>";
					echo "<td>{$row['stu_name']}</td>";
					echo "<td>{$row['stu_sex']}</td>";
					echo "<td>{$row['stu_class']}</td>";
					echo "<td>{$row['stu_age']}</td>";
					echo "<td>{$row['stu_tel']}</td>";
					echo "<td>";
						echo "<a href=".$HTTP_SERVER_VARS['REQUEST_URI']."?my=edit&pro={$pro}&id={$row['id']} class="."set".">修改</a> ";
						echo "<a href=".$HTTP_SERVER_VARS['REQUEST_URI']."?my=del&pro={$pro}&id={$row['id']} class="."del".">删除</a>";
					echo "</td>";
				echo "</tr>";
			endforeach;
			echo "<tr class="."tp"."><td colspan="."7"."><a href=".$HTTP_SERVER_VARS['REQUEST_URI']."?pro={$_GET['pro']}&class={$_GET['class']}&page={$_SESSION['pre_page']}><button class="."pagelist_button".">上一页</button></a>";
				for($i=1;$i<=$_SESSION['page_count'];$i++){
					echo "<a href=".$HTTP_SERVER_VARS['REQUEST_URI']."?pro={$_GET['pro']}&class={$_GET['class']}&page={$i}><button class="."pagelist_button".">{$i}</button></a>";
				}
			echo "<button class="."pagelist_button".">{$_SESSION['page']}/{$_SESSION['page_count']}页</button>";
			echo "<a href=".$HTTP_SERVER_VARS['REQUEST_URI']."?pro={$_GET['pro']}&class={$_GET['class']}&page={$_SESSION['next_page']}><button class="."pagelist_button".">下一页</button></a></td></tr>";
			echo "</table>";

		}
	}
		
	if(!isset($my)){
		if($permissions==1 || $permissions==2){
			$info = new info();
			$rows=$info->query_class();
			if(isset($rows)){
				$info->show($rows);
			}
		}elseif($permissions==3){
			$info = new info();
				$rows=$info->query_class();
			if(isset($rows)){
				$info->show($rows);
			}
			
		}else{
			mysqli_close();
			exit("<script language='javascript'>alert('非法访问！');window.location.href='index.php';</script>");
		}
	}
			
	if($my=="edit" || $my=="del" || $my=="add"){
		if($_SESSION['permissions']==1 || $_SESSION['permissions']==2){
			$pro=$_GET['pro'];
		}elseif($_SESSION['permissions']==3){
			$pro=$_SESSION['pro'];
		}
		if(isset($_GET['id'])){
			$id=$_GET['id'];			
			$my_sql = "SELECT * FROM pro_computer WHERE id = '$id'";
			$my_result = $mysqli->query($my_sql);
			$my_num = $my_result->num_rows;
			$my_row=$my_result->fetch_assoc();
			if($my_num==0){
				mysqli_close();
				exit("<script language='javascript'>alert('没有该学生数据！');history.go(-1);</script>");
			}
		}
		
		if($my=="edit"){			//修改
			include 'php/edit.php';
		}elseif($my=="add"){		//添加记录
			include 'php/add.php';
		}elseif ($my=="del"){		//删除
			$mysqli_result = $mysqli->query("SELECT * FROM pro WHERE id = {$pro}");
			$row=$mysqli_result->fetch_assoc();
			$del_sql = "DELETE FROM {$row['pro_table']} WHERE id = '$id'";
			$del_result = $mysqli->query($del_sql);
			if($del_result){
				echo "<script language='javascript'>alert('删除成功！');history.go(-1);</script>";
			}else{
				echo "<script language='javascript'>alert('删除失败！');history.go(-1);</script>";
			}
		}
	}

mysqli_close();

include 'php/foot.php'; ?>
