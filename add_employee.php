<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>
<?php 
$department_id = '';
$message = " ";
	if(isset($_POST['submit'])){
		$f_name = strtolower($_POST['first_name']);
		$l_name = strtolower($_POST['last_name']);
		$full_name = $f_name." ".$l_name;
		$emp_id = strtoupper($_POST['emp_id']);
		$address = strtolower($_POST['address']);
		$phone = $_POST['phone'];
		$gender = strtolower($_POST['gender']);
		$desig = strtolower($_POST['designation']);
		$dept = strtolower($_POST['department']);
		$type = strtolower($_POST['type']);
		$salary = $_POST['salary'];
		$join = $_POST['join_date'];
		//check same employee id
		if (!empty($emp_id)) {
			$id_query = mysqli_query($connect, "SELECT employee_id FROM emp_info ORDER BY employee_id ASC");
			confirm_query($id_query);
			while ($row=mysqli_fetch_assoc($id_query)) {
				if ($row['employee_id'] == $emp_id) {
					$message = "Employee ID already exists";
					goto A;
				}
			}
		}
		
		if(empty($f_name) || empty($l_name) || empty($emp_id) || empty($address) || empty($phone) || empty($gender) || empty($desig) || empty($dept) || empty($type) || empty($salary) || empty($join)){
			$message = '<p style="color:red;">All fields are required.</p>';
		}elseif(!is_numeric($phone) || !is_numeric($salary)){
			$message = '<p style="color:red;">Phone or salary must be number</p>';
		}else if($gender == 'select' || $dept == 'select' || $type == 'select'){
			$message = '<p style="color:red;">Please select all values</p>';
		}else{
			//query for inserting dept_id in the 'emp_info' table
			$dept_query = mysqli_query($connect,"SELECT * FROM departments WHERE emp_category='$dept'");
			confirm_query($dept_query);
			while ($row=mysqli_fetch_assoc($dept_query)) {
				$department_id = $row['id'];
			}
			//query for inserting all data in the 'emp_info' table
			$query = mysqli_query($connect,"INSERT INTO emp_info(dept_id,
				department,first_name,last_name,full_name,employee_id,gender,designation,type,phone,address,salary,join_date) VALUES ('$department_id','$dept','$f_name','$l_name','$full_name','$emp_id','$gender','$desig','$type','$phone','$address','$salary','$join')");
			confirm_query($query);

			echo "<h3>"."Employee succesfully added."."</h3>";
		}
	}else{
		$message = "Add an employee with all details to a specific department.";
	}
?>
	<div class="row">
		<div class="col-md-12">
			<h3><?php A: echo $message; ?></h3>
		</div>
	</div>
	<div class="row info">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="info">
			<div class="col-md-6" id="info01">
				<p>Personal information</p>
					<pre>First Name :<input type="text" name="first_name"></pre><br>
					<pre>Last Name  :<input type="text" name="last_name"></pre><br><pre>Employee ID:<input type="text" name="emp_id"></pre>
					<br>
					<pre>Address    :<input type="text" name="address"></pre><br>
					<pre>Phone      :<input type="phone" name="phone"></pre><br>
					<pre>Gender     :<select name="gender">
										<option>Select</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									 </select></pre>
			</div>
			<div class="col-md-6" id="info02">
				<p>Job related information</p>
				   <pre>Designation :<input type="text" name="designation"></pre><br>
				   <pre>Department :<select name="department">
										<option>Select</option>
										<option value="Cutting">Cutting</option>
										<option value="Sewing">Sewing</option>
										<option value="Finishing">Finishing</option>
									 </select></pre><br>
				   <pre>Type 	   :<select name="type">
										<option>Select</option>
										<option value="Full time">Full time</option>
										<option value="Part time">Part time</option>
									 </select></pre><br>
				   <pre>Salary 	   :<input type="text" name="salary"></pre><br>
				   <pre>Join date  :<input type="date" name="join_date"></pre>
					<button type="submit" name="submit" value="Add" id="add">ADD</button> 
			</div>
		</form>
	</div>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>
