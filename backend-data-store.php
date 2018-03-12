<?php
/* AJAX check  */
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  # Get JSON as a string
  $json_str = file_get_contents('php://input');

  # Get as an object
  $json_obj = json_decode($json_str);
  $filename = $json_obj[0]->id.'.json';
  //write json to file
  if (file_put_contents($filename, $json_str, FILE_APPEND | LOCK_EX))
    echo "JSON file created successfully...";
  else
    echo "Oops! Error creating json file...";
}else{
  http_response_code(403);
  die('Aceess is Forbidden!!!');
}




?>
