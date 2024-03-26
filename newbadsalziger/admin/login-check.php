<?php 
	
	if (!isset($_SESSION['admin-user'])) {
		
		$_SESSION['no-login-massage'] = "<div class='error text-center'>Lütfen Admin paneline Giriş Yapınız</div>";

		//yönlendir

		header('location:'.SITEURL.'admin/login-admin.php');



	}


 ?>