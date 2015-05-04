<?php

// Assumes a local mongo install
$connection = new MongoClient();
$db = $connection->selectDB('learninglockerstable'); //Database name

$collection = $db->statements; // Choose the statements collection

$cursor = $collection->find();  // All statements in "learninglockerstable" database
// http://php.net/manual/en/mongocollection.find.php

header("Content-Type:text/plain");
foreach($cursor as $document){
  print_r($document);
}


$query = array(
  'lrs._id' => '5448b8d7416fef053fd63af1', // Might want to add this to every query, if you have multiple LRS's in one learninglocker installation.
  'statement.object.definition.type' => 'http://adlnet.gov/expapi/activities/course' // Retrieve all statements that have object->definition->type set as 'http://adlnet.gov/expapi/activities/course',
);


$cursor = $collection->find($query);
foreach($cursor as $document){
  print_r($document);
}
