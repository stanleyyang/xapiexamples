<?php

//Define needed constants
define('ENDPOINT', 'http://localhost:8888/ll/learninglocker_test/public/data/xAPI/statements');   //To use statement api, you must add /statements to the end
define('USERNAME', 'a5c960f66ebb0013e1152504801b70770e342580');
define('PASSWORD', '41100a94622766b876e918d87c316d34ebbf3f7b');
define('XAPIVERSIONHEADER', 'X-Experience-API-Version: 1.0.1');


// xAPI specification: https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md


// generate a simple statement
$username = 'Test User';
$useremail = 'test.user@email.jee';
$verbid = 'http://activitystrea.ms/schema/1.0/create'; // example place to look for verb definitions: https://registry.tincanapi.com/#home/verbs
$verbname = 'created';

$statement = array(
  'actor' => array(
    'name' => $username,
    'mbox' => 'mailto:'.$useremail,
    'objectType' => 'Agent',
  ),
  'verb' => array(
    'id' => $verbid,
    'display' => array(
      'en-GB' => $verbname, //Language map: https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#misclangmap
    ),
  ),
  'object' => array(
    'id' => 'http://www.kursused.jee/courses/testcourse', //https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#acturi
    'objectType' => 'Activity',
    'definition' => array(
      'type' => 'http://adlnet.gov/expapi/activities/course',   // example place to look for activity types: https://registry.tincanapi.com/#home/activityTypes
      'name' => array(
        'en-GB' => 'Test Course',
      ),
    ),
  ),
);

// We need the statement to be JSON
$statement = json_encode($statement);


// Example post request to learning locker
$headers = array(
  XAPIVERSIONHEADER,
  'Content-Type: application/json',
);


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, ENDPOINT);
curl_setopt($curl, CURLOPT_USERPWD, USERNAME.':'.PASSWORD);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, $statement);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

$data = curl_exec($curl);
error_log(print_r($data, true));    // Returns the UUID of the inserted statement
curl_close($curl);

?>
