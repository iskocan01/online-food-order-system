<?php include('partials-front/menu.php'); ?>



<?php if(!isset($_SESSION['user'])) { ?>




	<div class="main-content">
		<div class="wrapper">

			<?php 

			// todo: giriş yapıldığında kontrol üye doğrulama tamam ise sıkıntı yok üyelik doğrulanmadığında ise üyeliğini doğrula diye mesaj gönderççç....

				if (isset($_SESSION['add']))
					{
						echo $_SESSION['add'];
						unset($_SESSION['add']);
					}
				

			 ?>
				
			
			
			<div id="kayitFormu">
	            <form action="" method="POST" >
	                <h3>anmelden</h3><br>
	                <?php 
	                	if (isset($_SESSION['no-login-massage']))
						{
							echo $_SESSION['no-login-massage'];
							unset($_SESSION['no-login-massage']);
						}

						if (isset($_SESSION['login']))
						{
							echo $_SESSION['login'];
							unset($_SESSION['login']);
						}
	                 ?>
	                 
	                <input type="email" name="mail" placeholder="E-Mail">
	                <input type="password" name="password" placeholder="Passwort">
	                <input class="btn-login" type="submit" name="submit" value="Giriş Yap">
	                <br>
					<p>Sie haben kein Konto??</p>
	                <a href="<?php echo SITEURL; ?>sign-up.php" style="font-size:25px">Ein neues Konto erstellen</a><br><br> 
	                <div class="sifre-yanlis">
	                	<?php 
	                	 

	                	 ?>
	                		
	                	
	                </div> 
	            </form>	

	                       
	        </div>
		</div>
	</div>
<?php }else{
	 
	header("location:".SITEURL);
} ?>
 

<?php 
	if (isset($_POST['submit'])) 
	{
		
	// 
		$email = mysqli_real_escape_string($conn, $_POST['mail']);


		$password= mysqli_real_escape_string($conn, md5($_POST['password']));



		$sql ="SELECT * FROM tbl_customer WHERE customer_email='$email' AND customer_password='$password'";

		$res= mysqli_query($conn, $sql);



		$count = mysqli_num_rows($res);

		if ($count == 1) {

			$row = mysqli_fetch_assoc($res);
			
			$_SESSION['login'] = "<div class='success text-center' ><h4>Login Successful </h4></div>";

			$_SESSION['user'] = $row['id'];

			header("location:".SITEURL."sepet.php");

		//	die();

		}
		else
		{
			$_SESSION['login'] = "<h5 class='error'>Passwort oder Benutzername falsch</h5>";

			header('location:'.SITEURL.'login-customer.php');


			//echo "koşul saglanmadı";
		}

	}

 ?>


 <?php include("partials-front/footer.php"); ?>


