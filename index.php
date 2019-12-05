<?php

use Controller\HandleRequest;
use Controller\HandleTrafficTracking;

// Load Composer's autoloader
require 'vendor/autoload.php';

//Check if a post action has been made
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

    //Instantiate the form controller
	$handle_req = new HandleRequest();

	//Check if form fields are valid
	$isValid = $handle_req->isRequestValid( $_POST, $messages );

	if ( $isValid ) {
		//create aa request object
		$request = $handle_req->createRequest( $_POST['name'], $_POST['email'], $_POST['phone'] );

		//Save data to persistence
		$insert_request = $handle_req->saveRequest( 1, $request );

		//Send the request
		$handle_req->sendRequest( $request );
	}
}

?>
<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Your title here</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	$traffic = new HandleTrafficTracking();
	$traffic->googleAnalitycs();
	$traffic->facebookPixel();
	?>
</head>
<body>
<form enctype="multipart/form-data" role="form" method="post" action="<?= htmlentities( $_SERVER['PHP_SELF'] ); ?>">
    <input type="text" name="name" placeholder="Type your name">
    <span class="error"><?= ! empty( $messages['name'] ) ? $messages['name'] : ''; ?></span>
    <br>
    <input type="email" name="email" placeholder="Type your email">
    <span class="error"><?= ! empty( $messages['email'] ) ? $messages['email'] : ''; ?></span>
    <br>
    <input type="tel" name="phone" placeholder="Type your phone number">
    <span class="error"><?= ! empty( $messages['phone'] ) ? $messages['phone'] : ''; ?></span>
    <br>
    <input type="submit" value="Send">
</form>
</body>
</html>


