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

// SQL to count rows
$sql = "SELECT COUNT(*) AS number FROM problem";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    
    // Get the counted value into a variable
    $count = $row['number'];  // 'number' is the alias we used in the query

    // Create the response
    $response = [
        'message' => 'Count retrieved successfully',
        'status' => 'success',
        'count' => $count
    ];

    // Send JSON response
    echo json_encode($response);
} else {
    echo json_encode([
        'message' => 'Error retrieving count',
        'status' => 'error'
    ]);
}

$conn->close();
?>

