<?php

use Controller\HandleRequest;
use Controller\HandleTrafficTracking;

// Load Composer's autoloader
require 'vendor/autoload.php';

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	//Instantiate the form controller
	$handle_request = new HandleRequest();
	//Get data from form
	$request = $handle_request->createRequest( $_POST['name'], $_POST['email'], $_POST['phone']  );

	if ( $request ) {
		//Save data to persistence
		$insert_request = $handle_request->saveRequest( 1, $request );

		//Send the request
		$handle_request->sendRequest( $request );
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
    <input type="text" name="name" placeholder="Type your name" required>
    <br>
    <input type="email" name="email" placeholder="Type your email" required>
    <br>
    <input type="tel" name="phone" placeholder="Type your phone number" required>
    <br>
    <input type="submit" value="Send">
</form>
</body>
</html>


