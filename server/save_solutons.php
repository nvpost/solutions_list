<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');


$input_data=json_decode(file_get_contents("php://input"), true);

$db = new SQLite3("sol.db");

$values="";
foreach($input_data as $key => $val){
    $values.="'".$val."', ";
}
$values = substr($values, 0, strlen($values)-2);

if(strlen($input_data['label'])>0){
    $sql = "INSERT INTO solutions (label, desc_html, imgs_src, tags, author_id) VALUES (".$values.")";
    $sql_add = $db->exec($sql);
}


$db->close();

echo  json_encode(['values' =>$values, 'data' => $input_data]);

?>