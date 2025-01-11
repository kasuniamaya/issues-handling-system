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

if(isset($data['loginusername']) && isset($data['loginpassword']) && isset($data['loginType']) ) {
    $type = $data['loginType'];
    $user = $data['loginusername'];
    $pass = $data['loginpassword'];

    
    // SQL to insert data
    $sql = "SELECT * FROM $type WHERE username='$user' AND password='$pass'";
     $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        // Assign the retrieved email to a variable
        $email = $row['email'];

        $response = [
            'message' => 'Insertion successful',
            'status' => $type,
            'user' => $user,
            'email' => $email,
            'password' => $pass,
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