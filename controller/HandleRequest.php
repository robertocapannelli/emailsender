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

	private static $instance = null;

	/**
	 * HandleRequest constructor.
	 */
	private function __construct() {
	}


	/**
	 * Singleton
	 *
	 * @return HandleRequest|null
	 */
	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new HandleRequest();
		}

		return self::$instance;
	}

	/**
	 * @param $values
	 * @param $array
	 *
	 * @return bool
	 */
	public function isRequestValid( $values, &$array ) {
		$error = [];

		//TODO should check also the file uploaded?

		//TODO how can we avoid this hardcoded loop?
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
					default:
						v::stringType()->assert( $value );
				}

			} catch ( NestedValidationException $e ) {
				$array[ $key ] = $e->getFullMessage();
				$error[ $key ] = false;
			}
		}

		return ! in_array( false, $error );
	}

	/**
	 * @param $post
	 *
	 * @param $file
	 *
	 * @return Request
	 */
	public function createRequest( $post, $file ) {

		//Check all values and sanitize
		foreach ( $post as $key => $value ) {
			switch ( $key ) {
				case 'name':
					$post[ $key ] = filter_var( ucwords( strip_tags( trim( $value ) ) ), FILTER_SANITIZE_STRING );
					break;
				case 'email':
					$post[ $key ] = filter_var( strip_tags( trim( $value ) ), FILTER_SANITIZE_EMAIL );
					break;
				case 'phone':
					$post[ $key ] = filter_var( strip_tags( trim( $value ) ), FILTER_SANITIZE_STRING );
					break;
			}
		}

		$this->request = new Request( $post['name'], $post['email'], $post['phone'] );

		//Check if a file was uploaded if so set the file in a request object
		if ( isset( $file['file']['name'] ) ) {
			$this->request->setFile( $file['file']['name'] );
		}

		return $this->request;
	}

	/**
	 * Send the request created
	 *
	 * @param Request $request
	 */
	private function sendRequest( Request $request ) {

		//TODO these information should be positioned in a dedicated class public visible or define as constants?
		//TODO like this we are repeating ourselves
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
	 * Save the request to the persistence
	 * @param $dao_factory
	 * @param $request
	 *
	 * @return mixed
	 */
	private function saveRequest( $dao_factory, $request ) {

		//Check the kind of persistence has to be used
		switch ( $dao_factory ) {
			case self::CSV:
				$dao_factory = new DaoFactoryCSV();
				break;
			default:
				break;
		}

		//return the class that will handle the persistence
		return $dao_factory->getDaoFactory( $request );
	}

	/**
	 * Get values from the form passing an array
	 *
	 * @param Request $request
	 */
	public function processRequest( Request $request ) {
		//Save the request to persistence
		if ( $this->saveRequest( 1, $request ) ) {
			//Send request via email
			$this->sendRequest( $request );
		}
	}
}

