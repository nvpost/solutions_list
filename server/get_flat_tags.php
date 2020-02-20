<?php

header('Access-Control-Allow-Origin: *');


$db = new SQLite3("sol.db");

$sql = "SELECT * FROM tags WHERE 1";
$res = $db->query($sql);

$tags=[];
while($row = $res->fetchArray(SQLITE3_ASSOC)){
    array_push($tags, $row);
}

echo json_encode(['tags' => $tags]);

?>