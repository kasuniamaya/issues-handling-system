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

if (isset($data['problem']) && isset($data['location'])) {
    $problem = $data['problem'];
    $location = $data['location'];
    
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM problem WHERE problem = ? AND location = ?");
    $stmt->bind_param("ss", $problem, $location); // "ss" means two string parameters
    
    $stmt->execute(); // Execute the DELETE query

    // Check how many rows were affected
    if ($stmt->affected_rows > 0) {
        $response = [
            'message' => 'Deletion successful',
            'status' => 'success'
        ];
        echo json_encode($response);
    } else {
        $response = [
            'message' => 'No record found to delete',
            'status' => 'error'
        ];
        echo json_encode($response);
    }

    $stmt->close(); // Close the prepared statement
} else {
    echo json_encode(["message" => "Invalid input"]);
}

$conn->close();
?>