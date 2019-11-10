<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer( true );

try {
	//Server settings
	/*$mail->SMTPDebug = SMTP::DEBUG_LOWLEVEL;                      // Enable verbose debug output
	$mail->isSMTP();                                            // Send using SMTP
	$mail->Host       = 'smtps.aruba.it';                    // Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	$mail->Username   = 'info@conte2007';                     // SMTP username
	$mail->Password   = '3G6!shU2C';                               // SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	$mail->Port       = 465;        */                            // TCP port to connect to

	//Recipients
	$mail->setFrom( 'info@conte2007.it', 'Conte Orologi' );
	$mail->addAddress( 'roberto.capannelli@gmail.com', 'Roberto Capannelli' );     // Add a recipient
	//$mail->addAddress( 'ellen@example.com' );               // Name is optional
	//$mail->addReplyTo( 'info@conteorologi.it', 'Information' );
	//$mail->addCC( 'roberto@nwdesigns.it' );
	//$mail->addBCC( 'bcc@example.com' );

	// Attachments
	//$mail->addAttachment( '/var/tmp/file.tar.gz' );         // Add attachments
	//$mail->addAttachment( '/tmp/image.jpg', 'new.jpg' );    // Optional name

	// Content
	$mail->isHTML( true );                                  // Set email format to HTML
	$mail->Subject = 'Here is the subject';
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	$mail->send();
	echo 'Message has been sent';
} catch ( Exception $e ) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}