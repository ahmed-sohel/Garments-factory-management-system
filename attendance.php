<?php session_start(); ?>
<?php require_once("layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

<div class="row">
	<div class="col-md-6">
		<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>"method="post">
			<select name="select" style="width:200px;">
				<option>None</option>
				<?php  
				$query=mysqli_query($connect,"SELECT * FROM departments ORDER BY dept_name ASC");
					while($row=mysqli_fetch_assoc($query)){
					  echo "<option>".$row['dept_name']."</option>";
					}
				?>
			</select>
			<input type="submit" name="submit" value="Select Department">
		</form>
	</div>	
	<div class="col-md-6">
		<?php 
			if(isset($_POST['select'])){
				echo '<span style="font-size:1.3em;color:blue;">'.$_POST['select'].'</span>'.'<span style="font-size:1.3em;color:black;">'.' department'.'</span>';
			}
		 ?>
	</div>
</div>

<?php
if(isset($_POST['submit'])){
	$dept = $_POST['select'];
	$query = mysqli_query($connect,"SELECT * FROM emp_info WHERE department = '$dept' ORDER BY id ASC");
		confirm_query($query);
		//$dept_num = mysqli_num_rows($dept_query);//number of rows

		echo "<table id=\"table\">";
			echo "<tr>";
			echo "<th>Username</th>";
			echo "<th>First Name</th>";
			echo "<th>Last Name</th>";
			echo "<th>Designation</th>";
			echo "<th>Date</th>";
			echo "<th>Attendance</th>";
			echo "</tr>";
				while ($row=mysqli_fetch_assoc($query)) {
					$user = $row['username'];
					echo "<tr>";
					echo "<td>".$row['username']."</td>";
					echo "<td>".$row['first_name']."</td>";
					echo "<td>".$row['last_name']."</td>";
					echo "<td>".$row['designation']."</td>";
					echo "<td>"."<input type=\"text\" name=\"date\" value='".date('d-M-Y')."'>"."</td>";
					echo "<td>";
						echo "<form action=\"action_page.php\">";
						echo "<input type=\"radio\" name=\"attend\" id=\"atnd\" value=\"1\" onclick=\"attendance('$user')\">"." Present"."<br>";
						echo "<input type=\"radio\" name=\"attend\" id=\"atnd\" value=\"0\" onclick=\"attendance('$user')\">". "Absent<br>";
						echo "</form>";
					echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
			echo "<p id=\"demo\">"."</p>";

}
?>
<?php require_once("layout/system_footer.php"); ?>
