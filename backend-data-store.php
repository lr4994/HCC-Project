<?php
//echo 'Thank you '. $_POST['firstname'] . ' ' . $_POST['lastname'] . ', says the PHP file';
// $dir = 'myDir';

 // create new directory with 744 permissions if it does not exist yet
 // owner will be the user/group the PHP script is run under
 // if ( !file_exists($dir) ) {
 //     $oldmask = umask(0);  // helpful when used in linux server
 //     mkdir ($dir, 0744);
 // }

// $array = Array (
//   "0" => Array (
//       "id" => "MMZ301",
//       "name" => "Michael Bruce",
//       "designation" => "System Architect"
//   ),
//   "1" => Array (
//       "id" => "MMZ385",
//       "name" => "Jennifer Winters",
//       "designation" => "Senior Programmer"
//   ),
//   "2" => Array (
//       "id" => "MMZ593",
//       "name" => "Donna Fox",
//       "designation" => "Office Manager"
//   )
// );
//
// // encode array to json
// $json = json_encode(array('data' => $array));
// file_put_contents($dir.'/test.json', $json);

# Get JSON as a string
$json_str = file_get_contents('php://input');

# Get as an object
$json_obj = json_decode($json_str);
$filename = $json_obj[0]->id.'.json';
//write json to file
if (file_put_contents($filename, $json_str))
  echo "JSON file created successfully...";
else
  echo "Oops! Error creating json file...";


?>
