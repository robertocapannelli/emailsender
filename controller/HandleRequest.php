<?php

namespace Controller;

use Dao\DaoFactoryCSV;
use Model\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Dotenv;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;


class HandleRequest {
	const CSV = 1;
	private $request;


	/**
	 * @param $values
	 * @param $array
	 *
	 * @return bool
	 */
	public function isRequestValid( $values, &$array ) {
		$error = [];

		foreach ( $values as $key => $value ) {
			try {
				switch ( $key ) {
					case 'name':
						v::alpha()->assert( $value );
						break;
					case 'email':
						v::email()->assert( $value );
						break;
					case 'phone':
						v::phone()->assert( $value );
						break;
				}

			} catch ( NestedValidationException $e ) {
				$array[ $key ] = $e->getFullMessage();
				$error[ $key ] = false;
			}
		}

		return ! in_array( false, $error );
	}


	/**
	 * Create a request from user data
	 *
	 * @param $name
	 * @param $email
	 * @param $phone
	 *
	 * @return Request
	 */
	public function createRequest( $name, $email, $phone ) {

		$this->request = new Request( $name, $email, $phone );

		return $this->request;
	}

	/**
	 * Send the request created
	 *
	 * @param Request $request
	 */
	public function sendRequest( Request $request ) {

		$dotenv = Dotenv\Dotenv::create( __DIR__ . "/../" );
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

	/**
	 * Save a request in storage
	 *
	 * @param $dao_factory
	 * @param $request
	 *
	 * @return mixed
	 */
	public function saveRequest( $dao_factory, $request ) {
		switch ( $dao_factory ) {
			case self::CSV:
				$dao_factory = new DaoFactoryCSV();
				break;
			default:
				break;
		}

		return $dao_factory->getDaoFactory( $request );
	}
}