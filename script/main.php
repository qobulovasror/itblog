<?php 

	// Connecttion server
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="blog";
	$link=mysqli_connect($servername,$username,$password,$dbname);

	if($connect -> conncet_error){
		die("Bo'glanishda xatolik: ".conncet_error);
	}

?>