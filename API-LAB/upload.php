<?php
// VULNERABLE - للتجربة فقط
if(isset($_FILES['file'])){
    $name = $_FILES['file']['name'];
    $tmp  = $_FILES['file']['tmp_name'];
    
    move_uploaded_file($tmp, "uploads/" . $name);
    echo json_encode(['status'=>'uploaded','file'=>$name]);
}
?>