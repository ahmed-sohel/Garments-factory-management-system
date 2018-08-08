<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>SA </title>
	<!-- <meta charset="UTF-8"> -->
	<meta name=viewport content="width=device-width, initial-scale=1">
	<link href="main.css" rel="stylesheet" type="text/css">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css"><!-- self coded -->
	<!--for elastislide carousal-->
	<link rel="stylesheet" type="text/css" href="css/elastislide.css" />
	<!--elastislide carousal ends-->
	<!-- Add fancyBox -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<link rel="stylesheet" href="source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".fancybox").fancybox();
		});
	</script>
	<!-- fancyBox ends-->
	<script src="js/slider.js"></script><!-- self coded -->
	<script type="text/javascript">//this is for search suggestion
		$(document).ready(function(){
           $('#search_suggestion').hide();
			$('#search_suggestion').css({"width": "210px", "background-color": "#fff", "margin-top":"3%", "padding":"5px", "border-radius":"5px", "position":"absolute"});
		    $("#search_box").keyup(function(){
		        var txt = $("#search_box").val();
		        if(txt != ''){
		        	$('#search_suggestion').show();
		        	$('#search_suggestion').css("z-index", "999");
		        	$.post("suggestion.php", {suggest: txt}, function(result){
		            $("#search_suggestion").html(result);
		        });	
		        }else{
           			$('#search_suggestion').hide();
		        }
		    });
		});
	</script><!-- search suggestion ends here -->
<style>
	body{
    background-image: url("images/factory1.jpg");
    background-attachment: fixed; 
    background-size: 100%;
	}
</style>
</head>
<body>
<section>
	<div class="container">
		<div class="row"><!--First row-->
			<div class="col-md-8">
				<img src="images/SA Logo.png" width="30%" height="110px" alt="SA Logo">
			</div>
			<div class="col-md-4" >
				<span id="search">
					<form action="search_result.php" role="search" method="post" >
	                    <input type="text" name="search" placeholder="Search" id="search_box" />
	                    <button class="btn btn-info btn-sm" type="submit" name="submit">
	                        <i class="glyphicon glyphicon-search"></i>
	                    </button>
					</form>	
				</span>
									
				<div id="search_suggestion"></div>
			</div><!--'col-md-4' ends-->
		</div><hr><!--First 'row' ends-->

		<div class="row"><!--2nd row-->
			<div class="col-md-12 naviga">			
				<nav class="navbar ">
				  <div class="container-fluid">
				  	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					    
					      <div class=" collapse navbar-collapse" id="myNavbar">
					    		<ul class="nav navbar-nav">
								  <li class=""><a href="index.php">Home</a></li>
								  <li class=""><a href="about.php">About us</a></li>
								  <li class="dropdown">
								    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Product
								    <span class="caret"></span></a>
								    <ul class="dropdown-menu">
								      <li><a href="jents.php">Jents</a></li>
								      <li><a href="ladies.php">Ladies</a></li>
								      <li><a href="kids.php">Kids</a></li>
								    </ul>
								  </li>
								  <li class="dropdown">
								    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="#">Departments
								    <span class="caret"></span></a>
								    <ul class="dropdown-menu">
								      <li><a href="cutting.php">Cutting</a></li>
								      <li><a href="sewing.php">Sewing</a></li>
								      <li><a href="finishing.php">Finishing</a></li>
								    </ul>
								  </li>
								  <li><a href="contact.php">Contact Us</a></li>
								  <div class="nav navbar-nav navbar-right ">
									  <li><a href="login.php" ><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
								  </div>
								</ul><!--"navbar-nav" ends-->
					      </div><!--'collapse' ends-->
				  </div>
				</nav>
			</div>
		</div><!--2nd 'row' ends-->



