 


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
    // Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Send using SMTP
    $mail->Host = 'badsalziger-kebab.de';       // Set the SMTP server to send through
    $mail->SMTPAuth = false;                              // Disable SMTP authentication
    $mail->SMTPSecure = false;                            // Disable SSL/TLS
    $mail->Port = 25;                                     // Set the TCP port to connect to

    // Attempt to connect to the SMTP server
    if (!$mail->smtpConnect()) {
        echo "Failed to connect to SMTP server";
    } else {
        echo "Successfully connected to SMTP server";
        $mail->smtpClose(); // Close the SMTP connection
    }
} catch (Exception $e) {
    echo "SMTP Error: " . $e->getMessage();
}
			

 

	 ?>

 