<?php include("../config/constants.php"); ?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login-Food Order System</title> 
	<style type="text/css">
		body {
    background-color: #f4f4f4;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.login {
    width: 80%;
    max-width: 400px;
    margin: 10% auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.login h1 {
    text-align: center;
    color: #333;
}

.login form {
    text-align: center;
}

.login input[type="text"],
.login input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    box-sizing: border-box;
}

.login input[type="submit"] {
    width: 100%;
    background-color: #4caf50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.login input[type="submit"]:hover {
    background-color: #45a049;
}

.sifre-yanlis {
    color: red;
    margin-top: 10px;
}

p {
    text-align: center;
    margin-top: 20px;
}

a {
    color: #4caf50;
    text-decoration: none;
    display: block;
    margin-top: 10px;
}

a:hover {
    text-decoration: underline;
}

		
	</style>
</head>
<body>

	<div class="login">
		<h1 class="text-center" >Login</h1>
		<br><br>
	

		<!-- Login form starts here-->
		<form action="" method="POST" class="text-center">
			Username:<br>
			<input type="text" name="username" placeholder="Enter Username"><br><br>
			Password:<br>
			<input type="password" name="password" placeholder="Şifrenizi Girin"><br>

			<input type="submit" name="submit" value="Giriş" class="btn-primary">
			<div class="sifre-yanlis">
		<?php 
			if (isset($_SESSION['login'])) 
			{
				echo $_SESSION['login']; //Display  the Session message if Set
				unset($_SESSION['login']);// Remove Session message
			}

			if (isset($_SESSION['no-login-massage'])) {
				echo $_SESSION['no-login-massage'];
				unset($_SESSION['no-login-massage']);
			}
		 ?>
			</div>
			<br><br>
		</form>
		<!-- Login form ends here-->

		<p>Created by <a href="#">İsmet Tepecik</a></p>
	</div>
</body>
</html>


<?php 
	
	if (isset($_POST['submit'])) {
		
	//	$username = $_POST['username'];

		$username = mysqli_real_escape_string($conn, $_POST['username']);


		$password= mysqli_real_escape_string($conn, md5($_POST['password']));

		$sql ="SELECT * FROM tbl_admin WHERE user_name='$username' AND password='$password'";

		$res= mysqli_query($conn, $sql);

		$count = mysqli_num_rows($res);

		if ($count == 1) {
			
			$_SESSION['login'] = "<div class='success' >Login Successful </div>";

			header('location:'.SITEURL.'admin/');

			$_SESSION['admin-user'] = $username;

		}
		else
		{
			$_SESSION['login'] = "<div>Şifre veya Kullanıcı Adı Yanlış</div>";

			header('location:'.SITEURL.'admin/login-admin.php');


			echo "koşul saglanmadı";
		}
	


	/*
		$if ($count == 1) {

			//user avaible and Login success

			$_SESSION['login'] = "<div class='success'> Login Successfuly </div>";
								//"<div class='success'>Admin deleted Successfully</div>";

			 // anasayfaya Yönlendir

			header('location:'.SITEURL.'admin');

		}
		else{
		
			//user avaible and Login success

			$_SESSION['login']="<div class="error">Login Failed. </div>";

			 // anasayfaya Yönlendir

			header('location:'.SITEURL.'admin/login-admin.php');
		}



		*/

		// if ($res == true) { echo "Bağlantı tamam"; 	}
	}
	
 ?>