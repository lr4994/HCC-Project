<?php
/* AJAX check  */
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

$jsonString = file_get_contents('participants.json');
$data = json_decode($jsonString, true);

// $myObj = new stdClass();
$email = strtolower($_POST['email']);
//echo $email;
$valid_user = 0;

$responseJson = new stdClass();

foreach ($data as $key => $entry) {
    if ($entry['email'] == $email && $entry['attempt'] < 2) {
        $valid_user = 1;
        $responseJson->valid = true;
        $responseJson->userId = $entry['id'];
        $responseJson->turn = $entry['attempt'] == 0? $entry['first'] : $entry['second'];
        // update no. of attempts taken so far
        $data[$key]['attempt'] = $entry['attempt'] + 1;
        //update json file
        $newJsonString = json_encode($data);
        file_put_contents('participants.json', $newJsonString);
        // send user data
        echo json_encode($responseJson);
        exit;
    }elseif ($entry['email'] == $email && $entry['attempt'] == 2) {
      // user already finished two attempts
      $responseJson->valid = false;
      echo json_encode($responseJson);
      exit;
    }
}

  if($valid_user==0){
    $err = new stdClass();
    $err->valid = false;
    $err->userId = 0;
    $error = json_encode($err);
    echo $error;
  }
}else{
  http_response_code(403);
  die('Aceess is Forbidden!!!');
}

?>
