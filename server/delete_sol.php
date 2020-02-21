<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');


$input_data=json_decode(file_get_contents("php://input"), true);
$db = new SQLite3("sol.db");

$sql = "DELETE FROM solutions WHERE `id`='".$input_data[n]."' ";
$sql_add = $db->exec($sql);

$db->close();

echo json_encode(['data' => $input_data]);

?>