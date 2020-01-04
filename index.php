<?php

use App\Controller\HandleRequest;
use App\Controller\HandleTrafficTracking;

// Load Composer's autoloader
require 'vendor/autoload.php';

//Check if a post action has been made
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

	//Instantiate the form controller
	$handle_request = new HandleRequest();

	//Check if form fields are valid
	//TODO should also check the file is valid? How so?
	if ( $handle_request->isRequestValid( $_POST, $error_messages ) ) {
		//Create a request instantiating the request model
		$request = $handle_request->createRequest( $_POST, $_FILES );
		//Process the current request passing the model this method
		$handle_request->processRequest( $request );
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
    <link href="dist/styles/app.css" rel="stylesheet">

	<?php
	$traffic = new HandleTrafficTracking();
	$traffic->googleAnalitycs();
	$traffic->facebookPixel();
	?>
</head>
<body>
<form enctype="multipart/form-data" role="form" method="post" action="<?= htmlentities( $_SERVER['PHP_SELF'] ); ?>">
    <input type="text" name="name" placeholder="Type your name">
    <span class="error"><?= ! empty( $error_messages['name'] ) ? $error_messages['name'] : ''; ?></span>
    <br>
    <input type="email" name="email" placeholder="Type your email">
    <span class="error"><?= ! empty( $error_messages['email'] ) ? $error_messages['email'] : ''; ?></span>
    <br>
    <input type="tel" name="phone" placeholder="Type your phone number">
    <span class="error"><?= ! empty( $error_messages['phone'] ) ? $error_messages['phone'] : ''; ?></span>
    <br>
    <input type="file" name="file" placeholder="Select a file">
    <span class="error"></span>
    <input type="submit" value="Send">
</form>

<script type="text/javascript" src="dist/scripts/app.js"></script>
</body>
</html>


