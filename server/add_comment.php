<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');

$input_data=json_decode(file_get_contents("php://input"), true);
if($input_data){
    $db = new SQLite3("sol.db");
    $sql_qwe = "INSERT INTO comments (`id_s`, `text_value`) VALUES ('".$input_data['n']."', '".$input_data['comment']."')";
    $res = $db->exec($sql_qwe);
    $db->close();
}


echo json_encode(['data' => $input_data, 'res' => $res, 'sd' => 'somedata']);