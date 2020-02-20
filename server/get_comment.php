<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');


$db = new SQLite3("sol.db");

$input_data=json_decode(file_get_contents("php://input"), true);

$sql = "SELECT * FROM comments WHERE `id_s`='".$input_data['n']."'";
$res = $db->query($sql);


$comments=[];
while($row = $res->fetchArray(SQLITE3_ASSOC)){
   array_push($comments, $row); 
}

$db->close();
echo json_encode(['data' => $comments]);