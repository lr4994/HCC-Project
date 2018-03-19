<?php
include 'html-403.php';
/* AJAX check  */
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  # Get JSON as a string
  $json_str = file_get_contents('php://input');

  # Get as an object
  $json_obj = json_decode($json_str);
  $userid = $json_obj[0]->id;
  $filename = $userid.'.json';

  $jsonString = file_get_contents('participants.json');
  $data = json_decode($jsonString, true);

  $responseJson = new stdClass();
  $responseJson->survey = false;

  foreach ($data as $key => $entry) {
      if ($entry['id'] == $userid && $entry['attempt'] < 2) {

          // update no. of attempts taken so far
          $data[$key]['attempt'] = $entry['attempt'] + 1;
          $responseJson->survey = true;
          $newJsonString = json_encode($data);
          file_put_contents('participants.json', $newJsonString);
          //write/append json data to file for each user
          if (file_put_contents($filename, $json_str, FILE_APPEND | LOCK_EX)){
            $responseJson->msg = "JSON file created successfully...";
          }else{
            $responseJson->msg = "Oops! Error creating json file...";
          }

          echo json_encode($responseJson);
          exit;
      }
  }

  echo json_encode($responseJson);

}else{
  http_response_code(403);
  die($errorMessage);
}




?>
