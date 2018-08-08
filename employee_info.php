<?php session_start(); ?>
<!--path starts from root folder-->
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>SA</title>
	<meta charset="UTF-8">
	<link href="style.css" rel="stylesheet" type="text/css">
	<link href="../public/bootstrap/css/bootstrap.css" rel="stylesheet">

</head>
<body>
<section class="container-fluid">
	<div class="row img"><!--first 'row' starts-->
		<div class="col-md-8">
			<img src="../public/images/SA Logo.png" width="20%"" height="15%">
		</div>
		<div class="col-md-4 logout">
			<ul>
				<li><a href="../public/logout.php">Logout</a></li>
			</ul>			
		</div>
	</div><!--first 'row' ends-->

<?php 
	if (isset($_SESSION['log_in'])) {//showing single employee info
				$name = $_SESSION['log_in'];//session from manage.php
		$query = mysqli_query($connect,"SELECT * FROM emp_info WHERE username='$name' LIMIT 1");
		confirm_query($query);
		echo "<table id=\"table\">";
			echo "<tr>";
				echo "<th>Username</th>";
				echo "<th>First Name</th>";
				echo "<th>Last Name</th>";
				echo "<th>Designation</th>";
				echo "<th>Department</th>";		
				echo "<th>Type</th>";
				echo "<th>Salary</th>";
			echo "</tr>";
			$row=mysqli_fetch_assoc($query);
			echo "<tr>";
				echo "<td>".$row['username']."</td>";
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
					echo 'Phone :'.'<input type="tel" name="phone" readonly
					value="'.$row['phone'].'">'.'<br><br>';
					echo 'Address :'.'<input type="text" name="address" 
					readonly value="'.$row['address'].'">'.'<br><br>';
					echo 'Email :'.'<input type="email" name="email" 
					readonly value="'.$row['email'].'">'.'<br>';
				echo "</div>";
				echo "<div class=\"form_out_2\">";//inside 'form_in'
					echo 'Gender :'.'<input type="text" name="gender" 
					readonly value="'.$row['gender'].'">'.'<br><br>';
					echo 'Join date :'.'<input type="date" name="join_date" 
					readonly value="'.$row['join_date'].'">'.'<br>';
				echo "</div>";
			echo "</form>";
		echo "</div>"."</br>";
	}else{
		echo "";
	}
 ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>
