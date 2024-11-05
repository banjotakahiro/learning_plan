<?php

require_once __DIR__ . '/functions.php';

$completion_date = date('Y-m-d');
$id = filter_input(INPUT_GET, 'id');

// idを用いてデータベースに接続
$bt = find_bt_by_id($id);

if ($bt['completion_date']) {

}
else{
    $dbh = connect_db();
    $sql = <<<EOM
    UPDATE
        plans
    SET
        completion_date = :completion_date
    WHERE
        id = :id
    EOM;
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':completion_date', $completion_date, PDO::PARAM_STR);
    $stmt->execute();
    
    header('Location: index.php');
    exit;
}

?>
