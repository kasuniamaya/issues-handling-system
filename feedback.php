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

if(isset($data['feedback']) && isset($data['user']) && isset($data['email']) && isset($data['status'])) {
    $feedback = $data['feedback'];
    
    $user = $data['user'];
    $email = $data['email'];
    $userType = $data['status'];

$sql = "INSERT INTO feedback (feedback , user , email , userType) VALUES ('$feedback','$user', '$email','$userType')";

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
