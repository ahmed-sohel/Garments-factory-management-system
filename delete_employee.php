<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>
<?php 
if(isset($_SESSION['emp_id'])){
	$emp_id = $_SESSION['emp_id'];
	$query = mysqli_query($connect, "DELETE FROM emp_info WHERE employee_id='$emp_id' LIMIT 1");
	confirm_query($query);
	echo 'Employee information of '.'<b>'.$emp_id.'</b>'.' has been succesfully deleted.';
}



?>