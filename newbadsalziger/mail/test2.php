 


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
				    $mail->isSMTP();

				    
				     
				    $mail->Host = 'badsalziger-kebab.de';                 		  //Set the SMTP server to send through
				    $mail->SMTPAuth   = false;                                   //Enable SMTP authentication 

				   $mail->Username = 'info@badsalziger-kebab.de';                //SMTP username
				   $mail->Password = 'Ismet63+++'; 
				                              									  //SMTP password
				   
				    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;;
				    $mail->Port = 25;
				  

				    $mail->CharSet = "utf-8";
				    $mail->setlanguage('de');

				    //Recipients
				    $mail->setFrom('info@badsalziger-kebab.de', 'Siparis Geldi');
				    $mail->addAddress('i.tefeci91@gmail.com');   						  //Add a recipient
				  
				    $mail->addReplyTo('ismet.tepecik.63@gmail.com', 'Information');
				    
				   // $mail->isHTML(true);                                  //Set email format to HTML
				    $mail->Subject = "İşbirliği Teklifi - [Şirketinizin İsmi]";
				    $mail->Body    = "Sevgili [Alıcının İsmi veya Unvanı],

[Şirketinizin ismi] olarak, sektördeki yenilikçi çözümlerimizle tanınmaktayız. Sizinle işbirliği yapma fırsatını değerlendirmekten memnuniyet duyarız. [Alıcının şirketi] ile potansiyel bir işbirliğinin, her iki taraf için de büyük faydalar sağlayacağına inanıyoruz.

Teklifimiz, [kısa bir teklif açıklaması] üzerine kuruludur. Detayları paylaşmak ve nasıl bir sinerji yaratabileceğimizi keşfetmek için bir toplantı ayarlayabilir miyiz?

Size uygun bir zaman dilimi belirlemenizi rica ederim. Görüşmemizde, işbirliğimizin detaylarını daha ayrıntılı bir şekilde ele alabiliriz.

Cevabınızı sabırsızlıkla bekliyorum.

Saygılarımla,

[Adınız ve Soyadınız]
[Unvanınız]
[Şirketinizin İsmi]
[İletişim Bilgileriniz]
";
				    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				    $mail->send();

				    echo "<h1>Mesaj başarılı</h1>";
				  
    
				} catch (Exception $e) {
				    echo "Message could not be sent  Mailer Error: {$mail->ErrorInfo}";
				}
			

 

	 ?>

 