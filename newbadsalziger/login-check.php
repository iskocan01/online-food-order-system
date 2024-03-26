<?php 
include("config/constants.php");
	
	if (!isset($_SESSION['user'])) {
		
		$_SESSION['no-login-massage'] = "<div class='error text-center'>Lütfen Giriş Yapınız</div>";

		//yönlendir 
		header('location:'.SITEURL.'login-customer.php');

		 
	}
	else
	{

	}


 ?>