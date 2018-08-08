<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_header.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/db_connect.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

<?php 
$msg = '';
//add resource to stock and insert into resource_inventory
    if (isset($_POST['add'])) {
      if ($_POST['amount'] != "") {
        $quantity = $_POST['amount'];
        if(isset($_SESSION['resource'])){
          $resources = $_SESSION['resource'];
          $id = $resources['id'];
          $name = $resources['resource_name'];
          $stock = $resources['amount'];
          $unit = $resources['unit'];
          $updated_stock = $stock + $quantity;
          $current_date = date('d-M-Y');
          //add quantity to amount column
        $quantity_query = mysqli_query($connect, "UPDATE `resource_item` SET amount='$updated_stock' WHERE id='$id'"); 
        confirm_query($quantity_query); 
        //update purchase details in add_resource table
        $add_query = mysqli_query($connect, "INSERT INTO `resource_inventory` (`resource_id`, `resource_name`, `quantity`, `unit`, `purchase_date`) VALUES ('{$id}','{$name}','{$quantity}', '{$unit}', '{$current_date}')");
        confirm_query($add_query);
        header("Location:resource.php?item_id=".$id);
       }else{ echo "session is not set."; }
      }else{
       $msg = '<h4 style="color:red;">Give some amount.</h4>';
      }  
    }

//subtract resource from stock and insert into resource_inventory
    if (isset($_POST['sub'])) {
      if ($_POST['amount'] != "") {
        $quantity = $_POST['amount'];
        if(isset($_SESSION['resource'])){
          $resources = $_SESSION['resource'];
          $id = $resources['id'];
          $name = $resources['resource_name'];
          $stock = $resources['amount'];
          $unit = $resources['unit'];
          $updated_stock = $stock - $quantity;
          $current_date = date('d-M-Y');
          //add quantity to amount column
          if ($quantity <= $stock) {
            $quantity_query = mysqli_query($connect, "UPDATE `resource_item` SET amount='$updated_stock' WHERE id='$id'"); 
            confirm_query($quantity_query); 
            //update purchase details in resource_inventory table
            $add_query = mysqli_query($connect, "INSERT INTO `resource_inventory` (`resource_id`, `resource_name`, `quantity`, `unit`, `used_date`) VALUES ('{$id}','{$name}','{$quantity}', '{$unit}', '{$current_date}')");
            confirm_query($add_query);
            header("Location:resource.php?item_id=".$id);
          }else{ $msg = '<h4 style="color:red;">Stock Unavailable</h4>'; }
        }
      }else{
       $msg = '<h4 style="color:red;">Give some amounts.</h4>';
      }   
    }



 ?>
	<div id="main">
      <?php //find_selected_page(); ?>
      <!--sidebar of the inventory page --> 
      <div class="row">
        <div class="col-md-2" id="resource_nav">
            <?php echo all_resource_name(); ?>
            <a href="add_resource.php">+ Add a new Item</a><br>
            <a href="delete_resource.php">- Delete an Item</a>
        </div>
        <!-- manage resources div -->
        <?php if(isset($_GET['item_id'])){ ?>
            <div class="col-md-5" id="division1">
              <?php //echo $msg; ?>
              <h3>Stock details</h3><hr>
                <?php 
                //session after adding a new resource
                if(isset($_SESSION['resource_added'])){
                 echo '<h3>'.$_SESSION['resource_added'].'</h3>'; 
                }
                unset($_SESSION["resource_added"]); 

                $resource_id = $_GET['item_id'];
                $resource_details = get_resource_details($resource_id);
                $_SESSION['resource'] = $resource_details;//use in this page
                ?>
                <table id="table">
                    <tr>
                        <th>Resource</th>
                        <th>Stock</th>
                    </tr>
                    <tr>
                        <td><?php echo $resource_details['resource_name']; ?></td>
                        <td><?php echo $resource_details['amount'].' '.$resource_details['unit']; ?></td>
                    </tr>
                </table></br></br></br>

                <!-- purchase summary here -->
                <h3>Purchase summary(<?php echo $resource_details['resource_name']; ?>)</h3><hr>
                <form method="post">
                  Date : <input type="date" name="purchase_date">
                  <input type="submit" name="pur_date" value="Search date">
                </form>
                
                <?php   
                    //search data according to purchase date
                    if (isset($_POST['purchase_date'])) {
                      $originalDate = $_POST['purchase_date'];
                      $purchase_date = date("d-M-Y", strtotime($originalDate));
                      $purchase_query = mysqli_query($connect,"SELECT * FROM `resource_inventory` WHERE resource_name='{$resource_details['resource_name']}' AND purchase_date = '$purchase_date'");
                      confirm_query($purchase_query);
                    }
                ?>
                <table id="table">
                    
                    <?php 
                    if (isset($purchase_query)) {?>
                      <tr>
                        <th>Purchased quantity</th>
                        <th>Purchased Date</th>
                    </tr>
                    <?php
                      while ($row = mysqli_fetch_assoc($purchase_query)) {
                      echo "<tr>";
                      echo "<td>".$row['quantity']." ".$row['unit']."</td>";
                      echo "<td>".$row['purchase_date']."</td>";
                      echo "</tr>";
                      }
                    }
                    
                    ?>
                </table>  
            </div>
            <div class="col-md-5" id="division2"><!--  -->
            <?php echo $msg; ?>
                <h3>Manage Resource</h3><hr>
                <!-- resource adding form -->
                <form method="post">
                   Add <span style="color: blue;font-weight: bold;"><?php echo $resource_details['resource_name']; ?></span> to stock : <input type="number" name="amount" style="margin-left: 7%;">
                    <button type="submit" class="btn btn-primary" name="add">Add</button>
                </form></br></br>
                <!-- resource subtracting form -->
                <form method="post">
                   Use <span style="color: blue;font-weight: bold;"><?php echo $resource_details['resource_name']; ?></span> for production : <input type="number" name="amount">
                    <button type="submit" class="btn btn-primary" name="sub">Sub</button>
                </form></br></br></br>
                
                <!-- Usage summary here -->
                <h3 style="margin-top: 5%;">Usage summary(<?php echo $resource_details['resource_name']; ?>)</h3><hr>
               <form method="post">
                  Date : <input type="date" name="usage_date">
                  <input type="submit" name="use_date" value="Search date">
                </form>
                
                <?php   
                    //search data according to purchase date
                    if (isset($_POST['use_date'])) {
                      $originalDate = $_POST['usage_date'];
                      $used_date = date("d-M-Y", strtotime($originalDate));
                      $usage_query = mysqli_query($connect,"SELECT * FROM `resource_inventory` WHERE resource_name='{$resource_details['resource_name']}' AND used_date = '$used_date'");
                      confirm_query($usage_query);
                    }
                ?>
                <table id="table">
                    
                    <?php 
                    if (isset($usage_query)) {?>
                      <tr>
                        <th>Used quantity</th>
                        <th>Used Date</th>
                    </tr>
                    <?php
                      while ($row = mysqli_fetch_assoc($usage_query)) {
                      echo "<tr>";
                      echo "<td>".$row['quantity']." ".$row['unit']."</td>";
                      echo "<td>".$row['used_date']."</td>";
                      echo "</tr>";
                      }
                    }
                    
                    ?>
                <!-- <table id="table">
                    <tr>
                        <th>Used quantity</th>
                        <th>Used Date</th>
                    </tr>
                    <?php 
                    // while ($row = mysqli_fetch_assoc($inventory_query)) {
                    //   echo "<tr>";
                    //   echo "<td>".$row['quantity']." ".$row['unit']."</td>";
                    //   echo "<td>".$row['used_date']."</td>";
                    //   echo "</tr>";
                    }
                    ?>
                </table> -->      
            </div>
        <?php //} ?>
      </div>
    	
      
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/layout/system_footer.php");?>