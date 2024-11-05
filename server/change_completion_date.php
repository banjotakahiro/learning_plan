<?php

require_once __DIR__ . '/functions.php';

$completion_date = date('Y-m-d');
$id = filter_input(INPUT_GET, 'id');

// idを用いてデータベースに接続
$bt = find_bt_by_id($id);

if ($bt['completion_date']) {
    complete_check_bt($id, null);
}
else{
    complete_check_bt($id, $completion_date);
}

?>
