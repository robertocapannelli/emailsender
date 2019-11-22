<?php

use Controller\HandleRequest;

use Dao\DaoFactoryCSV;

// Load Composer's autoloader
require 'vendor/autoload.php';

$name  = isset( $_POST['name'] ) ? $_POST['name'] : '';
$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
$phone = isset( $_POST['phone'] ) ? $_POST['phone'] : '';

//Instantiate the form controller
$request = new HandleRequest();
//Get data from form
$get_request = $request->createRequest( $name, $email, $phone );

$insert_request = $request->saveRequest( new DaoFactoryCSV(), $get_request );

//Send the request
$request->sendRequest( $get_request );