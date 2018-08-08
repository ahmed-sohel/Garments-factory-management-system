<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>
<?php 
//session comes from delete_item.php
if(isset($_SESSION['delete'])){
	echo '<script type="text/javascript">alert("'.$_SESSION['delete'].'")</script>';
	unset($_SESSION['delete']);
}
?>
<?php 
	if (isset($_GET['nav'])) {//if main nav clicked
		$nav_id = $_GET['nav'];
		switch ($nav_id) {
			case 1:
				header('location:resource.php');
				break;
			case 3:
				header('location:manage.php');
				break;
			case 4:
				header('location:add_employee');
				break;
			default:
				echo " ";
		}
	}elseif (isset($_GET['drop_menu'])) {//if drop nav clicked
		$drop_id = $_GET['drop_menu'];
		//used in cancel button in edit_item.php & delete_item.php
		$_SESSION['drop_id'] = $_GET['drop_menu'];
		?>
		<!-- button for adding new item -->
		<p style="margin-top: 10px;float: right;font-size: 1.5em;font-weight: bold; margin-right: 1%;">
		<a href="add_new_item.php" class="btn btn-info btn-lg" role="button">Add new item</a>
		</p>
		<?php
		//department wise item details
		$gender = mysqli_query($connect,"SELECT * FROM departments WHERE id='$drop_id'");
		confirm_query($gender);
		while ($row = mysqli_fetch_array($gender)) {
			$dept = $row['dept_name'];
		}
			$_SESSION['category'] = $dept;//for 'add_new_item & delete_item.php' page
			$query = mysqli_query($connect,"SELECT * FROM `$dept`");
			$total_rows = mysqli_num_rows($query);
			echo "<p style=\"padding-left:10%;font-size:1.1em;\">Total Items :
			<span>".$total_rows."</span></p>";
			echo "<table id=\"table\">";
			echo "<tr>";
			echo "<th>Image</th>";
			echo "<th>Item Name</th>";
			echo "<th>Color</th>";
			echo "<th>Price</th>";
			echo "<th>Stock</th>";
			echo "<th>Product Code</th>";
			echo "<th>Edit</th>";
			echo "<th>Delete</th>";
			echo "</tr>";
				while ($row=mysqli_fetch_assoc($query)) {
					echo "<tr>";
					echo "<td>";?><img src="../public/<?php echo $row['image_path']; ?>" height="200px" width="200px"><?php
					echo "</td>";
					echo "<td>".$row['dress_name']."</td>";
					echo "<td>".$row['color']."</td>";
					echo "<td>".$row['price']."</td>";
					echo "<td>".$row['stock']."</td>";
					echo "<td>".$row['product_code']."</td>";
					echo "<td><a href='edit_item.php?id=".$row['id']."' class='btn btn-primary'>Manage</a></td>";
					echo "<td><a href='delete_item.php?id=".$row['id']."' class='btn btn-danger' onclick=\"return confirm('Are you sure to delete?');\">Delete</a></td>";
					echo "</tr>";
				}
			echo "</table>";
	}else{
		//echo "<h3>Select username first.</h3>";
	}
?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>