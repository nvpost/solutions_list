<?php

$input_data=json_decode(file_get_contents("php://input"), true);
$db = new SQLite3("sol.db");
//Проверка на существование
$sql_check = $db->query("SELECT * FROM  group_tags WHERE `group` = '".$input_data['group']."' ")->fetchArray(SQLITE3_ASSOC);
if(!$sql_check&&strlen($input_data['group'])>1){
    $sql = "INSERT INTO group_tags (`group`) VALUES ('".$input_data['group']."')";
    $sql_add = $db->exec($sql);
}

$db->close();

echo json_encode(['data' => $input_data, 'check' =>$sql_check, 'sql_add' => $sql_add]);


?>  