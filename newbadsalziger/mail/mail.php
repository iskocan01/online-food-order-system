<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	 
	<?php 
		 
			include("../config/constants.php");

			use PHPMailer\PHPMailer\PHPMailer;
			use PHPMailer\PHPMailer\Exception;

			require 'PHPMailer/src/Exception.php';
			require 'PHPMailer/src/PHPMailer.php';
			require 'PHPMailer/src/SMTP.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$customer = $db->query("SELECT customer_email FROM tbl_customer WHERE id= '$id'", PDO::FETCH_OBJ)->fetchAll();
	$email = $customer[0]->customer_email;
}
else{
	$email ="i.tefeci91@gmail.com";
}


			$sql = "SELECT * FROM tbl_customer WHERE id='$id'";

			$res = mysqli_query($conn, $sql);

			if ($res == true) {
				$count = mysqli_num_rows($res);

				if ($count == 1) {
					$row = mysqli_fetch_assoc($res);
					$verification_code = $row['verification_code'];
					$customer_name = $row['customer_full_name'];
				}
				else{
					$verification_code = "code : ????????";
				}				
			} 
			 
			$subject = 'E-Mail-Verifizierung';
			
			$logo = SITEURL."images/newlogo.png";
			ob_start();

 			 
	$content ='<html lang="de">
	<head>
	<meta charset="utf-8">
	 <title>E-Mail-Verifizierung</title>
	 <style>
	// İçerik alanı 
	.content {
	  padding: 20px;
	}
	// Başlık alanı 
	.header {
	  background-color: #f7f7f7;
	  padding: 10px;
	}
	// Başlık metni 
	.title {
	  font-size: 24px;
	  margin: 0;
	}
	// Onaylama kodu 
	.code {
	  font-size: 32px;
	  color: #4CAF50;
	  margin: 20px 0;
	}
	// Alt bilgi alanı 
	.footer {
	  background-color: #f7f7f7;
	  padding: 10px;
	}
	// Alt bilgi metni 
	.text {
	  font-size: 12px;
	  color: #888;
	  margin: 0;
	}
	// Logo 
	.logo {
	  display: block;
	  margin: 0 auto;
	  max-width: 100%;
	  height: auto;
	}
	 </style>
	</head>
	<body>
	 <div class="content">
	<div class="header">
	<img class="logo" src="'.$logo.'" alt="Bad salziger kebab pizza hous">
	  <h1 class="title">E-Mail-Verifizierung</h1>
	</div>
	<p>Hallo '.$customer_name.',</p>
	<p>Verwenden Sie den folgenden Bestätigungscode, um Ihre E-Mail-Adresse zu bestätigen:</p>
	<div class="code">['.$verification_code.']</div>
	<p>Sie können Ihr Konto verifizieren, indem Sie diesen Code in das entsprechende Feld auf der Verifizierungsseite eingeben</p>
	<div class="footer">
	  <p class="text">Diese E-Mail wurde automatisch generiert. Bitte nicht antworten.</p>
	</div>
	 </div>
	</body>
  </html>';


			if (!$email) {
				echo "Mailinizi girin";
			}
			elseif (!$content) {
				echo "İceriğinizi giriniz";
			}
			else
			{
				//Create an instance; passing `true` enables exceptions
				$mail = new PHPMailer(true);

				try {
				    //Server settings
				    $mail->SMTPDebug = 2;                      //Enable verbose debug output
				    $mail->isSMTP();                                            //Send using SMTP
				    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
				    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				    $mail->Username   = 'for.food.registery@gmail.com';                 //SMTP username
				    $mail->Password   = 'fkapfrbludkkiwuv';                               //SMTP password
				    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				    $mail->CharSet = "utf-8";
				    $mail->setlanguage('de');

				    //Recipients
				    $mail->setFrom('for.food.registery@gmail.com', 'Bad Salzing Verification');
				    $mail->addAddress($email);   						  //Add a recipient
				  
				    $mail->addReplyTo('ismet.tepecik.63@gmail.com', 'Information');
				    
				    $mail->isHTML(true);                                  //Set email format to HTML
				    $mail->Subject = $subject;
				    $mail->Body    = $content;
				    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				    $mail->send();
				  
    
				} catch (Exception $e) {
				    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			}


			header("location:".SITEURL."mail/verification-mail.php?email=".$email);

 			 
	 			 




		
		 



	 ?>

</body>
</html>