<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; 
$password = "kasuni1234"; 
$dbname = "resourcemaintain";   

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['resource']) && isset($data['qty']) && isset($data['date']) && isset($data['user']) && isset($data['email']) && isset($data['status'])) {
    $resource = $data['resource'];
    $qty = $data['qty'];
    $date = $data['date'];
    $user = $data['user'];
    $email = $data['email'];
    $userType = $data['status'];

$sql = "INSERT INTO borrow (resource, quantity, date , borrower , email , userType) VALUES ('$resource', '$qty','$date','$user', '$email','$userType')";

if ($conn->query($sql) === TRUE) {
    $response = [
        'message' => 'report successful',
        'status' => 'success'
    ];
    
    echo json_encode($response);
} else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
}
} else {
echo json_encode(["message" => "Invalid input"]);

}

$conn->close();
?>
