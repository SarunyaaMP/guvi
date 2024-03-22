<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

// connecting to mysql database
$conn = new mysqli($servername, $username, $password, $dbname);

// checking if the connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// getting data from register form and storing them into variables
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$dob = $_POST['dob'];
$age = $_POST['age'];
$contact = $_POST['contact'];

// checking if the data is empty or not else it will ask the user to fill all the fields
if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['dob']) || empty($_POST['age']) || empty($_POST['contact']) ){
    echo json_encode( array('message' => 'fill all the fields') );
  exit();
}

// inserting data into mysql using prepared statements to avoid sql injection
$sql = "insert into register (username, email, password, dob, age, contact) values (?,?,?,?,?,?)";
$stmt = $conn -> prepare($sql);
$stmt -> bind_param("ssssis",$username, $email, $password, $dob, $age, $contact);

// checking if the stmt has executed or not
if(!$stmt -> execute()) {
    echo json_encode(array('error' => 'Error: ' . $conn->error));
    exit();
}

// including the PHP Library from composer which is a tool for dependency management in PHP
require '../vendor/autoload.php';

// creating a MongoDB client
$client = new MongoDB\Client("mongodb://localhost:27017");

// selecting the MongoDB database "website" and the collection "register" to insert the data
$db = $client->selectDatabase('website');
$collection = $db->register;

// creating a json to insert the data
$document = [
    'username' => $username,
    'email' => $email,
    'password' => $password,
    'dob' => $dob,
    'age' => $age,
    'contact' => $contact
];

// inserting the data into the collection
$result = $collection->insertOne($document);


// checking if the data is inserted into the database
if($result){
    echo json_encode( array('success' => true));
}
else{
    echo json_encode( array('message' => 'error'));
    exit();
}
 
// The user is directed to login page if inserting data into mysql and mongodb is successful 
header("Location: ../login.html");

$stmt->close();
$conn->close();

exit();

?>