<?php

// including the PHP Library from composer which is a tool for dependency management in PHP
require "../vendor/autoload.php";

// creating a redis client
$redis = new Predis\Client();

// connecting to mysql database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";
$conn = new mysqli($servername, $username, $password, $dbname);

//checking if the connection is established with mysql server
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

//checking if all fields are filled
if(empty($_POST['email']) || empty($_POST['password'])){
    echo json_encode( array('message' => 'fill all the fields') );
    exit();
}

// getting information from login form
$email = $_POST['email'];
$password = $_POST['password'];

// storing the email and password in redis to track session information
$redis->set('email',$email);
$redis->set('password',$password);

// select email and password from the database using prepared statements
$stmt = $conn->prepare("select * from register where email = ? and password = ?");
$stmt->bind_param("ss",$email, $password);
$stmt->execute();
$result = $stmt -> get_result();

// checking if the email and password exist in register table
if($result->num_rows > 0) {
    // if true then user gets redirected to profile page
    header("Location: ../profile.html");
    exit();
}

else{
    // else the user is invalid
    echo json_encode( array('message' => 'invalid email or password') );
    exit();
}

$stmt->close();
$conn->close();
?>





