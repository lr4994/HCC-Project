<?php
/* AJAX check  */
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

$jsonString = file_get_contents('participants.json');
$data = json_decode($jsonString, true);

// $myObj = new stdClass();
$email = trim($_POST['email']);
$password = trim($_POST['pass']);
echo $password."-----".$email;
$valid_user = 0;

$responseJson = new stdClass();

foreach ($data as $key => $entry) {
    if ($entry['email'] == $email && $entry['attempt'] < 2) {
        $valid_user = 1;
        $userJsonFile = $entry['id'].'.json';
        echo $userJsonFile;
        $userJsonString = file_get_contents($userJsonFile);
        $userData = json_decode($userJsonString, true);

        //check password
        if($password==$userData[1]['value']){
          $responseJson->login = true;
        }else {
          $responseJson->login = false;
          $responseJson->secret = $userData[1]['value'];
        }
        $responseJson->turn = $entry['second'];
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
    echo $error;
  }
}else{
  http_response_code(403);
  die('Aceess is Forbidden!!!');
}

?>
