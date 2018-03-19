<?php

include 'html-403.php';
include('logger.php');

// Logging class initialization
$log = new Logging();

// set path and name of log file (optional)
$log->lfile('log-file.txt');

/* AJAX check  */
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

$jsonString = file_get_contents('participants.json');
$data = json_decode($jsonString, true);

// $myObj = new stdClass();
$email = trim($_POST['email']);
$password = trim($_POST['pass']);
$log->lwrite('Login attempt from '. $_POST['email'] . ' with password ' . $_POST['pass'] . ', says the PHP file');
$valid_user = 0;

$responseJson = new stdClass();

foreach ($data as $key => $entry) {
    if ($entry['email'] == $email && $entry['attempt'] < 2) {
        $valid_user = 1;
        $userJsonFile = $entry['id'].'.json';
        $userJsonString = file_get_contents($userJsonFile);
        $userData = json_decode($userJsonString, true);

        $responseJson->userId = $entry['id'];
        //check password
        if($password==$userData[1]['value']){
          $responseJson->login = true;
          $log->lwrite('Logged in successfully.');
        }else {
          $responseJson->login = false;
          $responseJson->secret = $userData[1]['value'];
          $log->lwrite('Login failed, password not matched');
        }
        $responseJson->turn = $entry['second'];
        $log->lwrite(json_encode($responseJson));
        // close log file
        $log->lclose();
        echo json_encode($responseJson);
        exit;
    }
    // elseif ($entry['email'] == $email && $entry['attempt'] == 2) {
    //   // user already finished two attempts
    //   $responseJson->login = false;
    //   echo json_encode($responseJson);
    //   exit;
    // }
}

  if($valid_user==0){
    $err = new stdClass();
    $err->login = false;
    $error = json_encode($err);
    $log->lwrite('Login failed, email not matched or more attempts. '.$error);
    // close log file
    $log->lclose();
    echo $error;
  }
}else{
  http_response_code(403);
  die($errorMessage);
}

?>
