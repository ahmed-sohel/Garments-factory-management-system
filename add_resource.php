<?php session_start(); ?>
<?php require_once("layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>
<?php
$msg = '';
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$unit = $_POST['unit'];
	//check if the field is empty
	if ($name == "" || $unit == "") {
		$msg = "Field can't be empty.<hr/>";
	}else{
	//insert new resource name into table
		$query = mysqli_query($connect, "INSERT INTO resource_item (resource_name, unit) VALUES ('$name', '$unit') ");
		confirm_query($query);
		$_SESSION['resource_added'] = "New resource added to the list.";
		header("location:resource.php");
	}
}
 ?>
<div id="main">
	<?php //find_selected_page(); ?>
	<div class="row">
		<div class="col-md-2" id="resource_nav">
            <!--get all resource name from this function -->
        	<?php echo all_resource_name(); ?>
            <a href="add_resource.php">+ Add a new Item</a><br>
            <a href="delete_resource.php">- Delete an Item</a>
        </div>
        <div class="col-md-10" id="page">
        	<?php echo '<h3 style="color:red;">'.$msg.'</h3>'; ?>
        	<h2 style="margin-left: 10%;">Add new resource</h2><hr></br>
			<form action="add_resource.php" method="post" style="margin-left: 4%;">
				Name :<input type="text" name="name" style="margin-left: 1%;"></br></br>
				Unit :<input type="text" name="unit" style="margin-left: 2%;"></br></br>
				<input type="submit" name="submit" value="Add">
			</form>            
        </div>
	</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>