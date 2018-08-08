<?php require_once("db_connect.php"); ?>
<?php
function confirm_query($query_variable)
{
	if(!$query_variable){
		die('Query failed.'.mysqli_error($query_variable)."(".mysqli_errno(
			$query_variable).")");
		}
}

function total_employe()
{
	global $connect;
	$query = mysqli_query($connect,"SELECT * FROM emp_info");
	confirm_query($query);
	$number=mysqli_num_rows($query);

	return $number;
}

function navigation()
{
	global $connect;
	$query = mysqli_query($connect, "SELECT * FROM manage_nav_1");
	confirm_query($query);
	$output = "<ul class=\"main_nav\">";
	while ($main_nav = mysqli_fetch_array($query)) {
		$output .= "<li><a href=\"show_info.php?nav=";
		$output .= urlencode($main_nav['id']);
		$output .= "\">";
		$output .= htmlentities($main_nav['nav_name']);
		$output .= "</a><ul class=\"drop_nav\">";
		
		$drop_query = mysqli_query($connect, "SELECT * FROM manage_nav_2 
			WHERE main_nav_id='$main_nav[id]' ORDER BY id ASC ");
		confirm_query($drop_query);
		while ($drop_nav = mysqli_fetch_array($drop_query)) {
			$output .= "<li><a href=\"show_info.php?drop_menu=";
			$output .= urlencode($drop_nav['id']);		
			$output .= "\">";
			$output .= htmlentities($drop_nav['menu_name']);
			$output .= "</a></li>";
		}
		$output .= "</ul>";
		mysqli_free_result($drop_query);
		$output .= "</li>";
	}
	$output .= "</ul>";
	mysqli_free_result($query);

	return $output;
}

function employee_all_info()
{
	global $connect;
	$query = mysqli_query($connect,"SELECT * FROM emp_info");
	confirm_query($query);
	while ($info=mysqli_fetch_assoc($query)) {
		$output = $info;
	}

	return $output;
}

function get_product_code($dept)//used in add_new_item.php
{	global $connect;
	$query = mysqli_query($connect,"SELECT * FROM `$dept`");
	confirm_query($query);
	$output = array();
	$inc = 0;
	while ($dept_info=mysqli_fetch_assoc($query)) {
		$output[$inc] = $dept_info['product_code'];
		$inc++;
	}

	return $output;
}

function all_resource_name()
{
	global $connect;
	$query = mysqli_query($connect, "SELECT * FROM resource_item");
	confirm_query($query);
	$output = "<ul>";
	while ($row=mysqli_fetch_assoc($query)) {
		$output .= "<li><a href=\"resource.php?item_id=".$row['id']."\">".$row['resource_name']."</a></li>";
	}
	$output .= "</ul>";

	return $output;
}

function get_resource_details($resource_id)
{
	global $connect;
	$query = mysqli_query($connect, "SELECT * FROM resource_item WHERE id='$resource_id'");
	confirm_query($query);
	while ($row=mysqli_fetch_assoc($query)) {
		$output = $row;
	}
	
	return $output;
}


?>