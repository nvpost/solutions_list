<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');
//print_r($_FILES); 
$method = $_SERVER['REQUEST_METHOD'];
$input_data=file_get_contents("php://input");
$res='';
//echo  json_encode(['res' => $_FILES["file"]["tmp_name"]]);

    $local = "/solution_v02/solutions/server/img_tmp/";
    $uploaddir = $_SERVER['DOCUMENT_ROOT'].$local;
    
    $uploadfile = $uploaddir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        //echo "all Ok";
    } else {
        //echo $_FILES['file']['error']." - something wrong";
    }
    echo  'http://localhost/'.$local. basename($_FILES['file']['name']);

?>