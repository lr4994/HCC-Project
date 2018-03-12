<?php
$user_ids=array("Peter"=>"7d9ac729",
"Ben"=>"6981b333","Joe"=>"68290bdc",
"Mac"=>"e7e62733","Dick"=>"74fbdd77",
"Ben10"=>"b31d56cc","Harry"=>"d22ce255",
"Benton"=>"67b24eae","Joann"=>"0faccc12",
"Bob"=>"903b88e7","Jack"=>"71dcae74",
);

$myObj = new stdClass();
$email = $_POST['email'];

$valid_user = 0;

foreach($user_ids as $x=>$x_value)
  {
    if($x === trim($email)){
      $valid_user = 1;
      $myObj->valid = true;
      $myObj->userId = $x_value;
      $myJSON = json_encode($myObj);
      echo $myJSON;
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

  
  //  echo "User not found!!";

//echo "I like " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . ".";
?>
