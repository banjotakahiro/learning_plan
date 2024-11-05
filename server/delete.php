<?php

require_once __DIR__ . '/functions.php';

$id = filter_input(INPUT_GET, 'id');

// データベースに接続
$dbh = connect_db();

$sql = <<<EOM
DELETE
FROM
    plans
WHERE
    id = :id
EOM;

$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$bt = $stmt->fetch(PDO::FETCH_ASSOC);

header('Location: index.php');
exit;
?>
