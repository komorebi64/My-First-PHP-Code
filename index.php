<?php 
	$title="首页";
	include 'php/head.php';
	
	if(isset($_GET['pro'])){
		$pro=$_GET['pro'];
	}
	
	class index{
		function query_pro(){	//查询系别
			include 'php/conn.php';
			$sql = "SELECT * FROM pro";
			$mysqli_result = $mysqli->query($sql);
			if($mysqli_result && $mysqli_result->num_rows>0) {
				while(($row=$mysqli_result->fetch_assoc())!= FALSE){
					$rows[]=$row;
				}
			}
			return $rows;			//返回系别查询结果
		}
		
		function query_class($pro){//查询班级信息
			include 'php/conn.php';
			$mysqli_result = $mysqli->query("SELECT * FROM pro WHERE id = {$pro}");
			$row=$mysqli_result->fetch_assoc();
			if($_SESSION['permissions']==3){
				$mysqli_result = $mysqli->query("SELECT stu_class,count(*) number FROM {$row['pro_table']} WHERE stu_teacher='{$_SESSION['name']}' GROUP BY stu_class");
			}else{
				$mysqli_result = $mysqli->query("SELECT stu_class,count(*) number FROM {$row['pro_table']} GROUP BY stu_class");
			}
			if($mysqli_result && $mysqli_result->num_rows>0) {
				while(($row=$mysqli_result->fetch_assoc())!= FALSE){
					$rows[]=$row;
				}
			}
			return $rows;			//返回班级数查询结果
		}
	}
?>
<div class="pro">
	<?php
	$index = new index();
	if($permissions==1){
		if(!isset($_GET['pro'])){		//查询系部
			$rows=$index->query_pro();
			foreach($rows as $row):?>
				<a href="index.php?pro=<?=$row['id']?>" class="pro1"><?=$row['pro_name'] ?></a>
			<?php endforeach;}else {	//查询班级
			$rows=$index->query_class($_GET['pro']);
			foreach($rows as $row): ?>
    		<a href="Information.php?pro=<?=$_GET['pro']?>&class=<?=$row['stu_class']?>" class="pro1"><?=$row['stu_class'] ?>-人数：<?=$row['number'] ?></a>
    <?php endforeach;}}elseif($permissions==2){
		$rows=$index->query_class($_SESSION['pro']);
			foreach($rows as $row): ?>
       		<a href="Information.php?pro=<?=$_SESSION['pro']?>&class=<?=$row['stu_class']?>" class="pro1"><?=$row['stu_class'] ?>-人数：<?=$row['number'] ?></a>
    <?php endforeach;}elseif($permissions==3) {
    	$rows=$index->query_class($_SESSION['pro']);
    	foreach ($rows as $row):?>
    	<a href="Information.php?class=<?=$row['stu_class']?>" class="pro1"><?=$row['stu_class'] ?>-人数：<?=$row['number'] ?></a>
    <?php endforeach;}?>
</div>
<?php include 'php/foot.php'; ?>
