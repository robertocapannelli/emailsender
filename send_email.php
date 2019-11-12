<?php

use Controller\HandleRequest;

// Load Composer's autoloader
require 'vendor/autoload.php';

$name  = isset( $_POST['name'] ) ? $_POST['name'] : '';
$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
$phone = isset( $_POST['phone'] ) ? $_POST['phone'] : '';

echo 'hey';

//Instantiate the form controller
$request     = new HandleRequest();
//Get data from form
$get_request = $request->createRequest( $name, $email, $phone );

//Send the request
$request->sendRequest($get_request);