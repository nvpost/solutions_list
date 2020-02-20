<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');

$input_data=json_decode(file_get_contents("php://input"), true);
$db = new SQLite3("sol.db");
//Проверка на существование
$sql_check = $db->query("SELECT * FROM  group_tags WHERE `group` = '".$input_data['group_name']."' ")->fetchArray(SQLITE3_ASSOC);
if(!$sql_check&&strlen($input_data['group_name'])>1){
    $sql = "INSERT INTO group_tags (`group`) VALUES ('".$input_data['group_name']."')";
    $sql_add = $db->exec($sql);
}

$db->close();

echo json_encode(['data' => $input_data, 'sql_check' =>$sql_check, 'len' => strlen($input_data['group_name']) ]);


?>  