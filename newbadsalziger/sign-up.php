<?php include('partials-front/menu.php'); 
ob_start();
?>

	<div class="main-content">
		<div class="wrapper">

			
			<div id="kayitFormu">
	            <form action="" method="POST">
	                <h3>Registrieren</h3> 
	             
	                			 <?php 
	                	if (isset($_SESSION['add']))
	                		echo $_SESSION['add'];
	                		unset($_SESSION['add']);

	                	if (isset($_SESSION['uye-var'])) 
			            {
			                echo $_SESSION['uye-var'];
			                unset($_SESSION['uye-var']);


			            } 
	                 ?>
	                
 
	                <input type="text" name="full_name" placeholder="Vorname Familienname" required maxlength="25"  /> 
					<input type="password" name="password" placeholder="Passwort"  required />	                
	                <input type="password" name="confirm-password" placeholder="Passwort wiederholen" />
	                <input type="number" name="customer_contact" placeholder="Telefonnummer" required maxlength="6" min="8"  /> 
					<p class="text-danger" id="infor">Ein Bestätigungscode wird an Ihre E-Mail-Adresse gesendet.</p>
	                <input type="email" name="mail" placeholder="E-Mail" required maxlength=""  />
					     
	                <select name="neighborhood" class="selectt" style=" border-radius:5px;
					border:none;
					width:300px;
					height:50px;
					margin:20px 0px 20px 0px;
					background:rgba(240,240,240,.5);
					padding-left:15px;
					font-style:italic;"
					required >
	                	<option selected disabled value="">Choose...</option>
						<option value="bad-salzig" >Bad Salzig (€ 1.50)</option>
	                	<option value="weiler" >Weiler (€ 2.50)</option>
	                	<option value="hirzenach">Hirzenach (€ 2.50)</option>
	                	<option value="buchenau" >Buchenau (€ 2.50)</option>
	                	<option value="boppard" >Boppard (€ 2.50)</option>
	                	<option value="spay" >Spay (€ 3.00)</option>
	                	<option value="fleckertshöhe" >Fleckertshöhe (€ 2.50)</option>
	                	<option value="rheinbay" >Rheinbay (€ 2.50)</option>
	                	<option value="holzfeld" >Holzfeld (€ 2.50)</option>
	                	<option value="werlau" >Werlau (€ 2.50)</option>
	                	<option value="bibernheim" >Bibernheim (€ 2.50)</option>
	                	<option value="grundelbach" >Grundelbach (€ 2.50)</option>
	                	<option value="fellen">Fellen (€ 2.50)</option>
	                	<option value="st.goar" >St.Goar (€ 2.50)</option>
	                </select> 
	                <input type="number" name="postalCode" placeholder="Postleitzahl" required>
					
					<input type="text" name="address" placeholder="Adresse" required />

					<div class="form-check container">
						<input style=" margin-left:1px;  " name="checkbox" class="form-check-input " type="checkbox" require value="" id="flexCheckDefault">
						<label  style="margin-top:-28px;">
							Ich akzeptiere<a style="text-decoration:underline; color:blue;" target="_blank" href="<?php echo SITEURL; ?>lib/gizli.php"> die Datenschutzerklärung.</a>
						
						</label>
						
					</div>


	                <?php 

	                	if (isset($_POST['mail'])) {
	                		$emaail = $_POST['mail'];

	                	}
	                	else{
	                		$emaail ="Bitte schreiben Sie Ihre E-Mail-Adresse ";
	                	}
	                 ?>

	                <input class="btn-login" name="submit" type="submit" value="Registrieren" />
	            </form>	



	          
	           

	            <?php 


	         


	            //************************************************************ veri tabanı kayıt start
					if (isset($_POST['submit'])) 
					{	
						if(isset($_POST["checkbox"])){

						


							$full_name = $_POST['full_name'];
							$number = $_POST['customer_contact'];

							$password = $_POST['password'];
							$confirm_password = $_POST['confirm-password'];

							$customer_email = $_POST['mail'];
							$customer_mahalle = $_POST['neighborhood'];

							$customer_address = $_POST['address'];
							$customer_zip = $_POST['postalCode'];

							$verification_code = substr(number_format(time()*rand(),0,'',''), 0, 6);





	
							//burada bu bilgiler hakkında veri olup olmadığını kontrol et ve ondan sonra kayıt işlemini gerçekleştir
							$sql2 = "SELECT * FROM tbl_customer WHERE  customer_verification != '' AND (customer_number='$number' OR customer_email='$customer_email')";

							$res2 = mysqli_query($conn, $sql2);

							$count2 = mysqli_num_rows($res2);


							if ($password==$confirm_password) 
							{
								// code...
								$password = md5($password);
							
								if ($count2 >0) {
									
									$_SESSION['uye-var']="<div class='error' >
									E-Mail oder Telefonnummer wurde bereits registriert.<a href='contact.php'> Bitte kontaktieren Sie uns.</a> </div><br><div class='success'><a class='success' href='contact.php'>Bitte holen Sie sich Unterstützung vom Beamten</a></div>";
									
										header("location:".SITEURL."sign-up.php");
									


								}
								else{
										//header("location:".SITEURL."mail/verification-mail.php");
										
										$sql ="INSERT INTO tbl_customer SET
										customer_full_name ='$full_name',
										customer_password = '$password',
										customer_number = '$number',
										customer_email = '$customer_email',
										customer_mahalle ='$customer_mahalle',
										customer_address = '$customer_address',
										customer_zip = '$customer_zip',
										customer_verification = 'No',
										verification_code ='$verification_code',
										email_verified_at= NULL
										";



										$res = mysqli_query($conn, $sql);

										$customer_id = mysqli_insert_id($conn);

											//kayıt başarılı olduğunu mesaj ile gönder	
											if ($res==true) {
												//Data inserted
												//echo "Data inserted";
												//Create a session variable to display message
												$_SESSION['add'] ="<div class='success'>Registrierung erfolgreich</div>";

												//burada oturum acılacak bir daha giriş yapmayacak.
												$_SESSION['user'] = $customer_id;

												//Redirect Page to manage Admin
												header("location:".SITEURL."mail/mail.php?id=".$customer_id);

											}
											else//kayıt başarısız ise mesaj gönder
											{
												//Failed to insert Data
													//Create a session variable to display message
												$_SESSION['add'] ="<div class='error'>Registrierung fehlgeschlagen</div>";

												//Redirect Page to Add Admin
												header("location:".SITEURL.'login-customer.php');
											} 
								}
							}

							else
							{
									//Failed to insert Data
										//Create a session variable to display message
								$_SESSION['add'] ="<div class='error'>Passwörter sind nicht gleich</div>";
									//Redirect Page to Add Admin
								header("location:".SITEURL.'sign-up.php');
							}

						}else{
							//Failed to insert Data
							//Create a session variable to display message
							$_SESSION['add'] ="<div class='error'>Sie müssen die Datenschutzerklärung akzeptieren.</div>";
							//Redirect Page to Add Admin
							header("location:".SITEURL.'sign-up.php');
						}

	                }

	                //*************************************butuna bastığın veritabanı kayıt işlemi tamamlandı****
	                	
	                	
	             ?>	             
	        </div>
		</div>
	</div>

<?php include('partials-front/footer.php'); ?> 
