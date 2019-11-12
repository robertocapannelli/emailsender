<?php

namespace Controller;

use Model\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Dotenv;

class HandleRequest {
	private $request;

	/**
	 * Create a request from user data
	 *
	 * @TODO this should validate and sanitize data
	 *
	 * @param $name
	 * @param $email
	 * @param $phone
	 *
	 * @return Request
	 */
	public function createRequest( $name, $email, $phone ) {

		if ( ! empty( $name ) && ! empty( $email ) && ! empty( $phone ) ) {
			$name  = filter_var( ucwords( strip_tags( trim( $name ) ) ), FILTER_SANITIZE_STRING );
			$email = filter_var( strip_tags( trim( $email ) ), FILTER_SANITIZE_EMAIL );
			$phone = filter_var( strip_tags( trim( $phone ) ), FILTER_SANITIZE_NUMBER_INT );
		} else {
			return null;
		}

		$this->request = new Request( $name, $email, $phone );

		return $this->request;
	}

	/**
	 * Send the request created
	 * @param Request $request
	 */
	public function sendRequest( Request $request ) {

		$dotenv = Dotenv\Dotenv::create(__DIR__ . "/../" );
		$dotenv->load();

		$SENDER        = $_ENV['SENDER'];
		$SENDER_NAME   = $_ENV['SENDER_NAME'];
		$RECEIVER      = $_ENV['RECEIVER'];
		$RECEIVER_NAME = $_ENV['RECEIVER_NAME'];

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
			$mail->setFrom( $SENDER, $SENDER_NAME );
			$mail->addAddress( $RECEIVER, $RECEIVER_NAME );     // Add a recipient
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
			$mail->Body    = 'Hello ' . $request->getName() . ' your email is ' . $request->getEmail() . ' and your phone is ' . $request->getPhone();

			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			echo 'Message has been sent';
		} catch ( Exception $e ) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

}