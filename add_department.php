<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

<?php if(isset($_POST['submit'])){
		$dept_name = $_POST['dept_name'];
		$dept_id = $_POST['dept_id'];
		$sql = mysqli_query($connect, "INSERT INTO departments(id,dept_name) VALUES ('$dept_id','$dept_name')");
		confirm_query($sql);
		$message = "Department succesfully added."; 
		
		$qry1 = mysqli_query($connect, "UPDATE manage_nav_2 SET id = 'id' + 1 WHERE main_nav_id > 2 ORDER BY id ASC ");//create a gap between id 2 & 4
		confirm_query($qry1);

		$qry2 = mysqli_query($connect, "SELECT * FROM manage_nav_2 WHERE main_nav_id = 2 ");
		confirm_query($qry2);
		$rows = mysqli_num_rows($qry2);//total row number of id 2 
		echo "total 2 :".$rows;

		// $qry3 = mysqli_query($connect, "INSERT INTO manage_nav_2(id,main_nav_id,menu_name) VALUES ('$rows'+'1','2', '$dept_name')");//insert new row in the gap
		// confirm_query($qry3);
		$qry3 = mysqli_query($connect, "INSERT INTO manage_nav_2(main_nav_id,menu_name) VALUES ('2', '$dept_name')");
		confirm_query($qry3);
	}else{
		$message = "Add a department.";
	}
?>

	<div class="row">
		<div class="col-md-12">
			<h3><?php echo $message; ?></h3>
		</div>
	</div>
	<div class="row ">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="">
		<div class="col-md-12" id="">
				<pre>Department Name :<input type="text" name="dept_name"></pre><br>
				<pre>Department id  :<select name="dept_id">
				<?php 
					$query = mysqli_query($connect,"SELECT * FROM departments");
					$count = mysqli_num_rows($query);
					for($i=1; $i <= ($count+1); $i++){
					echo "<option>".$i."</option>";
					}
				?>
				</select></pre><br>
				<input type="submit" name="submit" value="submit">
		</form>
		</div>
	</div>