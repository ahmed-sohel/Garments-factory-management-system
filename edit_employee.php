<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

<?php 
$message = "";
if(isset($_POST['submit'])){//update information
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$salary = $_POST['salary'];
	$designation = $_POST['designation'];

	if(empty($phone) || empty($address) || empty($salary) || empty($designation)){
		//$message = '<h3 style="Color:red;">All information needed</h3>';
		echo '<h3 style="color:red;">All information needed</h3>';
	}else if(!is_numeric($phone) || !is_numeric($salary)){
		//$message = '<p style="Color:red;">Phone or Salary must be numeric</p>';
		echo '<h3 style="color:red;">Phone or Salary must be numeric</h3>';
	}else{
		$emp_id = $_SESSION['emp_id'];//session from single.php
		$query = mysqli_query($connect, "UPDATE emp_info SET phone='$phone', address='$address', salary='$salary', designation='$designation' WHERE employee_id='$emp_id'");
		confirm_query($query);
		echo "<h3>"."Information Updated."."</h3>";
	}
	
}else if (isset($_SESSION['emp_id'])) {//edit single employee info
		$emp_id = $_SESSION['emp_id'];//session from single.php
		$query = mysqli_query($connect,"SELECT * FROM emp_info WHERE employee_id='$emp_id' LIMIT 1");
		confirm_query($query);
		echo "<table id=\"table\">";
			echo "<tr>";
				echo "<th>Full Name</th>";
				echo "<th>First Name</th>";
				echo "<th>Last Name</th>";
				echo "<th>Department</th>";		
				echo "<th>Type</th>";
				echo "<th>Join date</th>";
			echo "</tr>";
			$row=mysqli_fetch_assoc($query);
			echo "<tr>";
				echo "<td>".$row['full_name']."</td>";
				echo "<td>".$row['first_name']."</td>";
				echo "<td>".$row['last_name']."</td>";
				echo "<td>".$row['department']."</td>";
				echo "<td>".$row['type']."</td>";
				echo "<td>".$row['join_date']."</td>";
			echo "</tr>";
		echo "</table>";
		echo "<div class=\"form_in\">";
			echo $message;
			echo '<form action="edit_employee.php" method="post">';
				echo "<div class=\"form_out_1\">";//inside 'form_in'
					echo 'Phone :'.'<input type="tel" name="phone" 
					value="'.$row['phone'].'">'.'<br><br>';
					echo 'Address :'.'<input type="text" name="address" 
					value="'.$row['address'].'">'.'<br><br>';
				echo "</div>";
				echo "<div class=\"form_out_2\">";//inside 'form_in'
					echo 'Salary :'.'<input type="text" name="salary" 
					value="'.$row['salary'].'">'.'<br><br>';
					echo 'Designation :'.'<input type="text" name="designation" value="'.$row['designation'].'">'.'<br>';
				echo "</div>";
				echo '<input id="update" type="submit" name="submit" value="Update">';
			echo "</form>";
		echo "</div>"."</br>";
		echo "<div class=\"edit\">";
		echo '<a href="single.php">'.'Cancel'.'</a>';
		echo "</div>";
	}else{
		echo "Page not found.";
	}
 ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>
