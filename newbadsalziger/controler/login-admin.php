<?php include("../config/constants.php"); ?>

 


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sayfası</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .login-container {
      max-width: 400px;
      margin: auto;
      margin-top: 100px;
    }

    .login-form {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .login-form h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-form label {
      font-weight: bold;
    }

    .login-form button {
      width: 100%;
      margin-top: 20px;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo-container img {
      width: 80px; /* Özelleştirebilirsiniz */
      height: 80px; /* Özelleştirebilirsiniz */
      border-radius: 50%;
    }

    .website-info {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: #6c757d;
    }
  </style>
</head>
<body>

<div class="container login-container">
  <div class="logo-container">
    <img src="../images/newlogo.png" alt="Logo">
  </div>
  <div class="login-form">
    <h2>Login</h2>
    <form method="POST" action="" >
      <div class="form-group">
        <label for="username">Kullanıcı Adı:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı Adı">
      </div>
      <div class="form-group">
        <label for="password">Şifre:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Şifre">
      </div>
      		<?php 
			if (isset($_SESSION['login'])) 
			{
				echo $_SESSION['login']; //Display  the Session message if Set
				unset($_SESSION['login']);// Remove Session message
			}

			if (isset($_SESSION['no-login-message'])) {
				echo   $_SESSION['no-login-message'];
				unset($_SESSION['no-login-message']);
			}
		 ?>

      <button type="submit" name="submit" class="btn btn-primary">Giriş Yap</button>
    </form>
    <div class="website-info">
      Website Designed by Tepis sofware © 2023<br>
      System Developed by İsmet Tepecik
    </div>
  </div>
</div>

<?php 

    if (isset($_POST['submit'])) {
		
	//	$username = $_POST['username'];

		$username = mysqli_real_escape_string($conn, $_POST['username']);


		$password= mysqli_real_escape_string($conn, md5($_POST['password']));

		$sql ="SELECT * FROM tbl_admin WHERE user_name='$username' AND password='$password'";

		$res= mysqli_query($conn, $sql);

		$count = mysqli_num_rows($res);

		if ($count == 1) {
			
			$_SESSION['info-success'] = "<div class='text-success text-center' >Login Successful </div>";
 
			$_SESSION['user_id'] = $username;
            header('location:'.SITEURL.CONTROL);
        //  echo "giriş yapıldı";

		}
		else
		{
			$_SESSION['login'] = "<div class='text-danger text-center'>Şifre veya Kullanıcı Adı Yanlış</div>";

			
            header('location:'.SITEURL.CONTROL.'login-admin.php');

        //  echo "giriş olmadı";

			 
		}
        

    }


?>


<!-- Bootstrap JS ve jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
