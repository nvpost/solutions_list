<?php

$input_data=json_decode(file_get_contents("php://input"), true);
$db = new SQLite3("sol.db");
//Проверка на существование
// $sql_check = $db->query("SELECT * FROM  tags WHERE tag='".$input_data['tag']."'")->fetchArray(SQLITE3_ASSOC);
// if($sql_check&&strlen($input_data['tag'])>1){
//     $sql = "INSERT INTO tags (tag, group_id) VALUES ('".$input_data['tag']."', '".$input_data['n']."')";
//     $sql_add = $db->exec($sql);
// }

$db->close();

echo json_encode(['data' => $input_data, 'check' =>$sql_check, 'sql_add' => $sql_add ]);


?>   