<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>
<?php 
$id = $_GET['id'];
$drop_id = $_SESSION['drop_id'];
$dept = $_SESSION['category'];

$query = mysqli_query($connect, "DELETE FROM resource_item WHERE id='$id'");
confirm_query($query);
$delete_query = mysqli_query($connect, "DELETE FROM resource_inventory WHERE resource_id = '$id'");
confirm_query($delete_query);
//$_SESSION['delete'] = "One item deleted.";//used in show_info.php
header("location: resource.php");
?>