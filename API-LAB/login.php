<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost","root","","secure_lab");

$data = json_decode(file_get_contents("php://input"),true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$response = ['status'=>'failed','message'=>'Invalid credentials'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
$stmt->bind_param("ss",$username,$password);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
    // Fake Token (Base64 JSON)
    $token = base64_encode(json_encode([
        'user_id'=>$row['id'],
        'role'=>$row['role']
    ]));
    $response = [
        'status'=>'success',
        'message'=>'Login successful',
        'token'=>$token
    ];
}

echo json_encode($response);