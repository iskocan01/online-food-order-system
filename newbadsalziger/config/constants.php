<?php 
	


	//Start Session
	 
		session_start();
		

		// Create a session
		define('SITEURL', 'http://localhost/newbadsalziger/');
		define('CONTROL', 'controler/');
		define('INDEX', 'index/');
		define('DATE', '2023-12-01 00:00:00');
		
		

	// 3. Execute query and Save data in Database

		define('LOCALHOST', 'localhost');
		define('Db_username', 'root');
		define('Db_password', '');
		define('Db_name', 'food_or');

		
	
		try {
				$db = new PDO("mysql:host=".LOCALHOST.";dbname=".Db_name.";charset=utf8",Db_username,Db_password);

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		 

	 	$conn= mysqli_connect(LOCALHOST, Db_username, Db_password, Db_name);//database connection //Database bağlatısı
		mysqli_set_charset($conn, "utf8"); // UTF-8 karakter setini ayarla
		$db_select = mysqli_select_db($conn, Db_name) or die(mysqli_error());//selecting Database //Veritabanını seciyotuz
 
 ?>