<?php

// including the PHP Library from composer
require "../vendor/autoload.php";

// creating a MongoDB client
$client = new MongoDB\Client("mongodb://localhost:27017");

// selecting the MongoDB database "website" and the collection "register" to insert the data
$db = $client->selectDatabase('website');
$collection = $db->register;

// fetch data from MongoDB
if($_SERVER['REQUEST_METHOD']==='GET'){
    $param = $_GET['email'];
    $filter = ['email' => $param];
    $options = [
    'projection' => ['_id' => 0,'email' => 1, 'username' => 1, 'age' => 1, 'dob' => 1, 'contact' => 1]];
    $cursor = $collection->findOne($filter,$options);
    if ($cursor) {
        echo json_encode($cursor);
    } 
    else{
        echo json_encode(['error' => 'No matching document found']);
    }
}

// update data in MongoDB
else if($_SERVER['REQUEST_METHOD']==='PUT'){
    $email = $_POST['email'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];

    $filter = ['email' => $email];
    $update = ['$set' => ['name'=>$name, 'dob'=>$dob, 'age'=>$age, 'contact'=>$contact]];

    $result = $collection->updateOne($filter,$update);
        
    if ($result->getModifiedCount() > 0) {
        echo "success";
    } 
    else{
        echo "failure";
    }
}
?>