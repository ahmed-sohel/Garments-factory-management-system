<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

	<!-- add new item here -->
<?php 
$msg = '';
	if(isset($_POST['submit'])){
		$dress_name = $_POST['dress_name'];
		$color = $_POST['color'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];
		$code = $_POST['code'];
		$dept_name = $_SESSION['category'];//from 'show_info.php' page
		$dress_category = array();
		$product_code = array();
		$inc = 0;
		$category_query = mysqli_query($connect, "SELECT * FROM category");
		confirm_query($category_query);
		while ($row = mysqli_fetch_assoc($category_query)) {
			$dress_category[$inc] = $row['dress_name'];
			$inc++;
		}

		$product_code = get_product_code($dept_name);
		//select dir to upload image
		if ($dept_name == 'jents_image') {
			$target_dir = "../public/images/jents/". basename($_FILES["image"]["name"]);
			$image = 'images/jents/'.$_FILES['image']['name'];
			$age = 'men';
		}else if ($dept_name == 'ladies_image') {
			$target_dir = "../public/images/ladies/". basename($_FILES["image"]["name"]);
			$image = 'images/ladies/'.$_FILES['image']['name'];
			$age = 'ladies';
		}else{
			$target_dir = "../public/images/kids/". basename($_FILES["image"]["name"]);
			$image = 'images/kids/'.$_FILES['image']['name'];
			$age = 'kids';
		}

		if(empty($image) || empty($age) || empty($dress_name) || empty($color) || empty($price) || empty($stock) || empty($code)){
			$msg = '<h4 style="color:red;">Field can not be empty</h4>';
		}else if(in_array($code, $product_code)){//check product_code if already exists
			$msg = 	'<h4 style="color:red;">Code already used</h4>';
		}else{
			$query = mysqli_query($connect, "INSERT INTO `$dept_name`(image_path,age_variation,dress_name,color,price,stock,product_code) VALUES ('$image','$age','$dress_name','$color','$price','$stock','$code')");
			confirm_query($query);//insert item into specifiq category
			//check dress_name if already exists
			if (in_array($dress_name, $dress_category)) {
				//do nothing
			}else{
				$sql = mysqli_query($connect, "INSERT INTO `category`(dress_name) VALUES ('{$dress_name}')");
				confirm_query($sql);
			}
			if(move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)){
				echo "<h4 style='color:green;'>New Item Added</h4>";
			}else{
				echo "something wrong.";
			}
		}
	}

?>
	<div class="row new">
		<div class="col-md-6">
		<?php echo $msg; ?>
			<h3>Item information</h3>
			<span><hr></span>
			<div class="all_inputs">
				<form action="add_new_item.php" method="post" enctype="multipart/form-data">
					<input type="file" name="image"></br>
					<label>Dress name :</label>
					<input type="text" name="dress_name"></br></br>
					<label>Color :</label>
					<input type="text" name="color"></br></br>
					<label>Price :</label>
					<input type="number" name="price"></br></br>
					<label>Stock :</label>
					<input type="text" name="stock"></br></br>
					<label>Dress Code :</label>
					<input type="text" name="code"></br></br>
					<button type="submit" name="submit">Add</button></br></br>
				</form>
			</div>
			
		</div>
	</div>
	
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>