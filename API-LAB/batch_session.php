<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost","root","","secure_lab");

$headers = getallheaders();
$auth = $headers['Authorization'] ?? '';
if(!$auth || !preg_match('/Bearer\s(\S+)/',$auth,$matches)){
    echo json_encode(['status'=>'failed','message'=>'No token']); exit;
}

$token = $matches[1];
$user = json_decode(base64_decode($token),true);
$current_user = $user['user_id'];

$data = json_decode(file_get_contents("php://input"),true);
$responses = [];

foreach($data as $prod){
    $id = $prod['id'] ?? 0;

    // Prepared Statement → SQL Injection Protection
    $stmt = $conn->prepare("SELECT * FROM products WHERE id=? AND owner_id=?");
    $stmt->bind_param("ii",$id,$current_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        // Validation
        if($row['price']>=0 && $row['price']<=10000 && stripos($row['product_name'],"<script>")===false){
            $responses[]=['id'=>$id,'status'=>'success','message'=>'Product saved'];
        } else {
            $responses[]=['id'=>$id,'status'=>'blocked','message'=>'Invalid product data'];
        }
    } else {
        $responses[]=['id'=>$id,'status'=>'blocked','message'=>'Unauthorized access'];
    }
}

echo json_encode($responses);