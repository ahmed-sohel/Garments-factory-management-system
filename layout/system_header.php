<!--path starts from root folder-->
<?php require_once($_SERVER['DOCUMENT_ROOT']."/company/admin/function.php");?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>SA</title>
	<meta charset="UTF-8">
	<link href="./css/style.css" rel="stylesheet" type="text/css">
	<link href="./../public/bootstrap/css/bootstrap.css" rel="stylesheet">
<style>
	button{
		background-color: green;
		color: #fff;
		font-size: 1.2em;
		text-decoration: none;
		border: none ;
		padding: 10px 20px;
		text-align: center;
		border-radius: 8px;
	}
	button:hover{box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
	}

</style>
</head>
<body>
<section class="container-fluid">
	<div class="row img"><!--first 'row' starts-->
		<div class="col-md-4">
			<img src="../public/images/SA Logo.png" width="25%"" height="15%">
		</div>
		<div class="col-md-4">
		<?php echo '<span style="font-size1.5em;color:#blue;margin-top:40px;border-radius:4px;background-color:#fff;padding:5px;">'.date('d-M-Y').' : '.date('l').'</span>'; ?>
		</div>
		<div class="col-md-4 logout">
			<ul>
				<li><a href="../public/logout.php">Logout</a></li>
			</ul>			
		</div>
	</div><!--first 'row' ends-->
	<div class="row"><!--second 'row' starts-->
		<div class="col-md-12" id="navigation">
			<?php echo navigation();?>
		</div>
	</div><!--second 'row' ends-->