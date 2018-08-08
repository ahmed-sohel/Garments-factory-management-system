<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

<div id="main">
	<?php //find_selected_page(); ?>
	<div class="row">
		<div class="col-md-2" id="resource_nav">
            <!--get all resource name from this function -->
        	<?php echo all_resource_name(); ?>
            <a href="add_resource.php">+ Add a new Item</a>
        </div>
        <div class="col-md-10" id="page">
        	<?php //echo '<h3 style="color:red;">'.$msg.'</h3>'; ?>
        	<h2 style="margin-left: 10%;">Delete Resource</h2><hr></br>
			<?php
			$query = mysqli_query($connect,"SELECT * FROM resource_item");
			$total_rows = mysqli_num_rows($query);
			echo "<table id=\"table\">";
			echo "<tr>";
			echo "<th>Resource</th>";
			echo "<th>Delete</th>";
			echo "</tr>";
				while ($row=mysqli_fetch_assoc($query)) {
					echo "<tr>";
					echo "<td>".$row['resource_name']."</td>";
					echo "<td><a href='resource_delete_page.php?id=".$row['id']."' class='btn btn-danger' onclick=\"return confirm('Are you sure to delete?');\">Delete</a></td>";
					echo "</tr>";
				}
			echo "</table>";
			 ?>          
        </div>
	</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>