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

if(isset($data['user'])) {
   
    $user = $data['user'];

    $sql = "SELECT * FROM problem WHERE (status = 'processing' OR status = 'Not solved') AND (responsiblePerson1 = '$user' OR responsiblePerson2 = '$user') ";
     $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $problems = [];
        while($row = $result->fetch_assoc()) {
            $problems[] = $row;
        }
        $response = [
            'message' => 'Problems retrieved successfully',
            'status' => 'success',
            'data' => $problems
        ];
        echo json_encode($response);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

    else {
        echo json_encode(["message" => "Invalid input"]);
    
    }

$conn->close();
?>