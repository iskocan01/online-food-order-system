<?php 
	include("config/constants.php");

	unset($_SESSION['user']);

	header("location:".SITEURL."login-customer.php");
//burası nedir
?>