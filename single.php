<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

		<div class="row"><!--single employee info form in single.php-->
			<div class="col-md-6">
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<select name="select" style="width:200px;">
						<option>None</option>
						<?php
						$query=mysqli_query($connect,"SELECT * FROM emp_info 
							ORDER BY employee_id ASC");
							while($row=mysqli_fetch_assoc($query)){
							  echo "<option>".$row['employee_id']."</option>";
							}
						?>
					</select>
					<input type="submit" name="submit" value="View Profile">
				</form>
			</div>
		</div>

<?php 
	if (isset($_SESSION['single_emp']) || isset($_POST['submit'])) {//showing single employee info
			if(isset($_SESSION['single_emp'])){
				$emp_id = $_SESSION['single_emp'];//session from manage.php
				unset($_SESSION['single_emp']);
				$_SESSION['emp_id'] = $emp_id;	
			}else{
				$emp_id = $_POST['select'];
				$_SESSION['emp_id'] = $emp_id;	
			}
		$query = mysqli_query($connect,"SELECT * FROM emp_info WHERE employee_id='$emp_id' LIMIT 1");
		confirm_query($query);
		echo "<table id=\"table\">";
			echo "<tr>";
				echo "<th>Full Name</th>";
				echo "<th>First Name</th>";
				echo "<th>Last Name</th>";
				echo "<th>Designation</th>";
				echo "<th>Department</th>";		
				echo "<th>Type</th>";
				echo "<th>Salary</th>";
			echo "</tr>";
			$row=mysqli_fetch_assoc($query);
			echo "<tr>";
				echo "<td>".$row['full_name']."</td>";
				echo "<td>".$row['first_name']."</td>";
				echo "<td>".$row['last_name']."</td>";
				echo "<td>".$row['designation']."</td>";
				echo "<td>".$row['department']."</td>";
				echo "<td>".$row['type']."</td>";
				echo "<td>".$row['salary']."</td>";
			echo "</tr>";
		echo "</table>";
		echo "<div class=\"form_in\">";
			echo '<form action="single.php" method="post">';
				echo "<div class=\"form_out_1\">";//inside 'form_in'
					echo 'Phone :'.'<input type="tel" name="phone" 
					readonly value="'.$row['phone'].'">'.'<br><br>';
					echo 'Address :'.'<input type="text" name="address" 
					readonly value="'.$row['address'].'">'.'<br><br>';
				echo "</div>";
				echo "<div class=\"form_out_2\">";//inside 'form_in'
					echo 'Gender :'.'<input type="text" name="gender" 
					readonly value="'.$row['gender'].'">'.'<br><br>';
					echo 'Join date :'.'<input type="date" name="join_date" 
					readonly value="'.$row['join_date'].'">'.'<br>';
				echo "</div>";
			echo "</form>";
		echo "</div>"."</br>";
		echo "<div class=\"edit\">";
		echo '<a href="edit_employee.php">'.'Edit'.'</a>';
		echo '<a href="delete_employee.php" onclick="return confirm(\'Are you sure?\')">'.'Delete'.'</a>';		
		echo "</div>";
	}else{
		echo "";
	}
 ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>
