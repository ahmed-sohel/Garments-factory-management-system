<?php session_start(); ?>
<?php require_once("layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

<?php 
if(isset($_POST['submit'])){
	$select = $_POST['select'];
	$_SESSION['single_emp'] = $select;
	header('location: single.php');
}
?>

	<div class="row"><!--3rd 'row' starts-->
		<div class="col-md-6">
			<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>"
			method="post">
				<select name="select" style="width:200px;">
					<option>None</option>
					<?php  
					$query=mysqli_query($connect,"SELECT * FROM emp_info ORDER BY employee_id ASC");
						while($row=mysqli_fetch_assoc($query)){
						  echo "<option>".$row['employee_id']."</option>";
						}
					?>
				</select>
				<input type="submit" name="submit" value="View Profile">
			</form>
		</div>
		<div class="col-md-6">
			<p style="float:left; margin-top:0px; position:relative;">Total enlisted worker: <span><?php echo total_employe(); ?></span></p>
		</div>
	</div><!--3rd 'row' ends-->

<?php require_once("layout/system_footer.php");?>
