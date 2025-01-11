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

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['problem']) && isset($data['location'])) {
   
    $problem = $data['problem'];
    $location = $data['location'];
    
    // SQL to insert data
    $sql = "UPDATE problem SET volenteer = 'Finished' WHERE problem = '$problem' && location = '$location' ";

    if ($conn->query($sql) == TRUE) {
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