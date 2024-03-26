	<?php 
		

			include("../config/constants.php");

			use PHPMailer\PHPMailer\PHPMailer;
			use PHPMailer\PHPMailer\Exception;

			require 'PHPMailer/src/Exception.php';
			require 'PHPMailer/src/PHPMailer.php';
			require 'PHPMailer/src/SMTP.php';

			require_once '../admin/partials/getData/getData.php';

			ob_start();

			$getCart = new cartData();
			$foodData = new foodData();
			$customerData = new customerData();

if (isset($_GET['email'])&&isset($_GET['cart_id'])&&isset($_GET['time'])) {

	$email = $_GET['email'];
	$cart_id= $_GET['cart_id'];
	$time = $_GET["time"];

	$order = $getCart->getAllCart($cart_id, $db);
 
	$foods = $foodData->getFoodName($order[0]->food_id, $db);
	$customer = $customerData->getCustomerAllInformation($order[0]->customer_id, $db);

 

	
 

	$email_subject = "Bestellinformationen";

	$customer_full_name = $customer->customer_full_name;
	
	
	$message = '
	<html lang="de">
	<head>
		<style>
			.container {
				background-color: lightblue;
				padding: 20px;
				margin: 10px auto;
				width: 80%;
				border: 1px solid black;
				border-radius: 10px;
				box-shadow: 10px 10px 5px grey;
			}
			.row{ 
				float: left; width: 100%;

			}
			.logo{
				width: 20%;   border-radius: 10px; margin-top: -150px; margin-left:-50px; 
			}

			h1, h3{
				text-align: center;
			}
			 
		
		 
		</style>
	</head>
	<body> 
		<div class="container">

		<h1>Bestellung bestätigt</h1>
		<div class="">

			<div  class="row"> 
				<div class="logo ">
					<img src="'.SITEURL.'/images/newlogo1.png" width="100%">
				</div>


			</div>
			 

		

		</div>
			<div> 
				<h3>Sie wissen sehr genau, was Sie essen möchten.</h3>
				<br>	<p>  Sehr geehrte <strong> '. $customer_full_name .',</strong>  
					<br> Die Bestellung wurde bestätigt. Ihre Bestellung erreicht Sie in ca. <strong> '.  $time.' ,</strong> Minuten.
					Danke, daß Sie uns gewählt haben.
					Guten Appetit</p>
			</div> 
 

		</div>
	</body>
	</html>
	';



	


}
else{
	$email ="böyle bir mail bulunamadı";
	 
}


			



			 
			$subject = $email_subject;
			$content = $message;

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
				    $mail->charset = "UTF-8";
					$mail->ContentType = 'text/html; charset=UTF-8';
				    $mail->setlanguage('de');

				    //Recipients
				    $mail->setFrom('for.food.registery@gmail.com', 'Bad Salzing Bestellbestatigung');
				    $mail->addAddress($email);   						  //Add a recipient
				  
				    $mail->addReplyTo('ismet.tepecik.63@gmail.com', 'Information');
				    
				    $mail->isHTML(true);                                  //Set email format to HTML
				    $mail->Subject = $subject;
				    $mail->Body    = $content;
				    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				    $mail->send();

				  $_SESSION["process"] .= "<br><div class='success'> Kullanıcıya Mail gönderildi </div><br>";
    
				} catch (Exception $e) {
				    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				    $_SESSION["process"] .= "<br><div class='error'> Mail gönderilemedi </div><br>";
				}
			

			
			//header("location:".SITEURL."admin/view-order.php?sepet_id=".$cart_id);
?>