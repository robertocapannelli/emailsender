<?php

namespace App\Controller;

use App\Dao\DaoFactoryCSV;
use App\Helper;
use App\Model\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;


class HandleRequest {
	const CSV = 1;
	private $request;

	/**
	 * @param $post
	 * @param $error_messages
	 *
	 * @return bool
	 */
	public function isValid( $post, &$error_messages ) {
		$error = [];

		//TODO should check also the file uploaded?

		//TODO how can we avoid this hardcoded loop?
		foreach ( $post as $key => $value ) {
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
				$error_messages[ $key ] = $e->getFullMessage();
				$error[ $key ]          = false;
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
	public function create( $post, $file ) {

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
	private function send( Request $request ) {

		$helper = Helper::getInstance();

		$helper->setDotenv();
		$helper->getDotenv()->load();

		$SENDER        = $_ENV['SENDER'];
		$SENDER_NAME   = $_ENV['SENDER_NAME'];
		$RECEIVER      = $_ENV['RECEIVER'];
		$RECEIVER_NAME = $_ENV['RECEIVER_NAME'];

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer( true );

		try {
			//Recipients
			$mail->setFrom( $SENDER, $SENDER_NAME );
			$mail->addAddress( $RECEIVER, $RECEIVER_NAME );     // Add a recipient

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
	 *
	 * @param $dao_factory
	 * @param Request $request
	 *
	 * @return mixed
	 */
	private function save( $dao_factory, Request $request ) {

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
	public function process( Request $request ) {
		//Save the request to persistence
		if ( $this->save( 1, $request ) ) {
			//Send request via email
			$this->send( $request );
		}
	}
}

