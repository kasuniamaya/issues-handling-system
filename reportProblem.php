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

if(isset($data['problem']) && isset($data['resource']) && isset($data['location']) && isset($data['qty']) && isset($data['incharge']) && isset($data['category']) && isset($data['user']) && isset($data['email']) && isset($data['status']) ) {
    $problem = $data['problem'];
    $resource = $data['resource'];
    $location = $data['location'];
    $qty = $data['qty'];
    $incharge = $data['incharge'];
    $category = $data['category'];
    $reporter = $data['user'];
    $email = $data['email'];
    $userType = $data['status'];
    
    // SQL to insert data
    $sql = "INSERT INTO problem (problem, resource, location, qty, incharge, category,status, reportedBy , reporterEmail,reporterType,time) VALUES ('$problem','$resource', '$location', '$qty','$incharge', '$category','not solved','$reporter','$email','$userType',NOW())";

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