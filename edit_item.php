<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>
<?php 
$msg='';
$message = '';
$validation_msg='';
$edit_validation_msg = '';
$id = $_GET['id'];//from 'show_info.php' page
$dept = $_SESSION['category'];//from show_info.php' page
$drop_id = $_SESSION['drop_id'];//from show_info.php' page

//edit product details
if(isset($_POST['edit'])){
	$second_time_id = $_GET['id'];//2nd time initialization to use again
	$color = $_POST['color'];
	$price = $_POST['price'];
	$stock = $_POST['stock'];
	if(empty($color) || empty($price) || empty($stock)){
		$edit_validation_msg = '<h4 style="color:red;">Field can not be empty</h4>';
		$msg = "<h3>Edit Information</h3>";
	}else{
		//update informtaion in product table
		$edit_query = mysqli_query($connect, "UPDATE `$dept` SET color='$color', price='$price', stock='$stock' WHERE id='$second_time_id'");
		confirm_query($edit_query);
		$msg = "<h3 style=\"color:green;margin-left:20px;\">Successfully Edited.</h3>";	
	}
}else{
	$msg = "<h3>Edit Information</h3>";
}
?>

<?php 
	//details according to id
	$query = mysqli_query($connect,"SELECT * FROM `$dept` WHERE id='$id'");
	confirm_query($query);
	$item_info = mysqli_fetch_assoc($query);
?>

<?php 
//product sell & update stock
if(isset($_POST['sell'])){// && isset($_POST['sell_amount'])
	$total_sell = $_POST['sell_amount'];
	if(empty($total_sell)){
		$validation_msg = '<h4 style="color:red;">Field can not be empty</h4>';
		$message = "<h3>Manage stock</h3>";
	}else if ($total_sell > $item_info['stock']) {
		$message = "<p style='color:red;'>Stock unavailable.</p>";
	}else if($total_sell < 15){
		$message = "<p style='color:red;'>Minimum order is 15.</p>";
	}else{
		$product_code = $item_info['product_code'];
		$product_name = $item_info['dress_name'];
		$current_date = date('d-M-Y');
		$stock_after_sell = $item_info['stock'] - $total_sell;
		$sell_query = mysqli_query($connect, "UPDATE `$dept` SET stock='$stock_after_sell' WHERE id='$id'");
		confirm_query($sell_query);
		$sql = "INSERT INTO `product_inventory` (`product_code`, `product_name`, `quantity`, `sell_date`) VALUES ('{$product_code}', '{$product_name}', '{$total_sell}', '{$current_date}')";
		$query = mysqli_query($connect, $sql);
		confirm_query($query);
		header("Location:edit_item.php?id=".$_GET['id']);
	}
}else{
	$message = "<h3>Manage stock</h3>";
}
?>

<?php 
//add new amount of product to stock
if(isset($_POST['add_product'])){// && isset($_POST['new_amount'])
	$new_amount = $_POST['new_amount'];
	if (empty($new_amount)) {
		$validation_msg = '<h4 style="color:red;">Field can not be empty</h4>';
		$message = "<h3>Manage stock</h3>";
	}else{
		$product_code = $item_info['product_code'];
		$product_name = $item_info['dress_name'];
		$current_date = date('d-M-Y');
		$stock_after_add = $item_info['stock'] + $new_amount;

		$add_query = mysqli_query($connect, "UPDATE `$dept` SET stock='$stock_after_add' WHERE id='$id'");
		confirm_query($add_query);

		$sql = "INSERT INTO `product_inventory` (`product_code`, `product_name`, `quantity`, `production_date`) VALUES ('{$product_code}', '{$product_name}', '{$new_amount}', '{$current_date}')";
		$query = mysqli_query($connect, $sql);
		confirm_query($query);
		header("Location:edit_item.php?id=".$_GET['id']);
	}
}
?>
<?php 
	//details according to id
	$query = mysqli_query($connect,"SELECT * FROM `$dept` WHERE id='$id'");
	confirm_query($query);
	$item_info = mysqli_fetch_assoc($query);
?>
<div class="row new">	
	<div class="col-md-6">
	<?php echo $edit_validation_msg; ?>
	<?php echo $msg; ?>
		<span><hr></span>
		<!-- edit form -->
		<div class="inputs">
			<form action="edit_item.php?id=<?php echo $id; ?>" method="post" id="edit_form">
				<img src="../public/<?php echo $item_info['image_path'];?>" width="200" height="200" style="float:right;border: 10px solid #ddd;border-radius: 14px;margin: 1%;padding: 2px;">
				Dress Name : <input type="text" name="dress_name" value="<?php 	echo $item_info['dress_name'];?>" style="margin-left: 1% ;" readonly><br><br>
				Dress code : <input type="text" name="dress_code" value="<?php 	echo $item_info['product_code'];?>" style="margin-left: 2%;" readonly><br><br>
				Color : <input type="text" name="color" value="<?php echo $item_info['color'];?>" style="margin-left: 9%;"><br><br>
				Price : <input type="number" name="price" value="<?php echo $item_info['price']; ?>" style="margin-left: 9%;"><br><br>
				Stock : <input type="number" name="stock" value="<?php echo $item_info['stock']; ?>" style="margin-left: 9%;"><br><br>
				<span class="cancel"><a href="show_info.php?drop_menu=<?php echo $drop_id; ?>">Cancel</a></span>
				<button type="submit" name="edit" class="btn btn-succesful" style="margin-left: 10%">Done</button><br><br>
		</form>
		</div>
		
	</div>

	<div class="col-md-6">
		<?php echo $validation_msg; ?>

	<?php	echo $message; ?>
		<span><hr></span>
		<!-- sell form -->
		<form action="edit_item.php?id=<?php echo $id; ?>" method="post" id="edit_form">
			Sell this product :<input type="number" name="sell_amount" placeholder="min 15" style="margin-left: 3%;">
 			<button type="submit" name="sell" class="btn btn-succesful" style="margin-left: 10%">Sell</button><br><br>
		</form></br></br>
		<!-- add form -->
		<form action="edit_item.php?id=<?php echo $id; ?>" method="post" id="edit_form">
			Add to stock :<input type="number" name="new_amount" placeholder="New product" style="margin-left: 8%;">
 			<button type="submit" name="add_product" class="btn btn-succesful" style="margin-left: 10%">Add</button><br><br>
		</form>
	</div>
</div></br></br>
<!-- product inventory review -->
<h3>Product Inventory</h3>
<div class="row new">
	<div class="col-md-6">
		
		<!-- production summary -->
		<h3>Production summary</h3><hr>
		<?php  
			$inventory_query = mysqli_query($connect, "SELECT * FROM `product_inventory` WHERE product_code='{$item_info['product_code']}' AND production_date != 'NULL'");
			confirm_query($inventory_query);
		?>
			<table id="table">
                <tr>
                    <th>Production number</th>
                    <th>Production Date</th>
                </tr>
                <?php 
                while ($row = mysqli_fetch_assoc($inventory_query)) {
                  echo "<tr>";
                  echo "<td>".$row['quantity']." pieces"."</td>";
                  echo "<td>".$row['production_date']."</td>";
                  echo "</tr>";
                }
                ?>
            </table> 
	</div>
	<div class="col-md-6">
		 
		<!-- sell summary -->
		<h3>Sell summary</h3><hr>
		<?php 
			$inventory_query = mysqli_query($connect, "SELECT * FROM `product_inventory` WHERE product_code='{$item_info['product_code']}' AND sell_date != 'NULL'");
			confirm_query($inventory_query);
		?>
			<table id="table">
                <tr>
                    <th>Sell number</th>
                    <th>Sell Date</th>
                </tr>
                <?php 
                while ($row = mysqli_fetch_assoc($inventory_query)) {
                  echo "<tr>";
                  echo "<td>".$row['quantity']." pieces"."</td>";
                  echo "<td>".$row['sell_date']."</td>";
                  echo "</tr>";
                }
                ?>
            </table> 
	</div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>