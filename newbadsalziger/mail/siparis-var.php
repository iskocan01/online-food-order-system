<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	 
	<?php 
		 
			

			use PHPMailer\PHPMailer\PHPMailer;
			use PHPMailer\PHPMailer\Exception;

			require 'PHPMailer/src/Exception.php';
			require 'PHPMailer/src/PHPMailer.php';
			require 'PHPMailer/src/SMTP.php';
 
 
		 
			ob_start(); 
			 
				//Create an instance; passing `true` enables exceptions
				$mail = new PHPMailer(true);

				try {
				    //Server settings
				    $mail->SMTPDebug = 2;                      //Enable verbose debug output
				    $mail->isSMTP();                                            //Send using SMTP
				    $mail->Host       = 'badsalziger-kebab.de';                     //Set the SMTP server to send through
				    $mail->SMTPAuth   = false;                                   //Enable SMTP authentication
				    $mail->Username   = 'info@badsalziger-kebab.de';                 //SMTP username
				    $mail->Password   = 'Ismet63+++';                               //SMTP password
				    $mail->SMTPSecure = false;            //Enable implicit TLS encryption
				    $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				    $mail->CharSet = "utf-8";
				    $mail->setlanguage('de');

				    //Recipients
				    $mail->setFrom('for.food.registery@gmail.com', 'Siparis Geldi');
				    $mail->addAddress('i.tefeci91@gmail.com');   						  //Add a recipient
				  
				    $mail->addReplyTo('ismet.tepecik.63@gmail.com', 'Information');
				    
				    $mail->isHTML(true);                                  //Set email format to HTML
				    $mail->Subject = "sipariş geldi";
				    $mail->Body    = "sipariş geldi";
				    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				    $mail->send();
				  
    
				} catch (Exception $e) {
				    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				    	echo "burada durdu mesaj gitmedi";
				    die();

				}
			

 

	 ?>

</body>
</html>