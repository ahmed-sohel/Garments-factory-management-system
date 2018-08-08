 <?php  
define("DB_SERVER","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","sa");

	$connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if(!$connect){
		die('Database connection failed.'.mysqli_connect_error($connect)."(".mysqli_connect_errno($connect).")");
	}
?>