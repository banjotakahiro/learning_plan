<?php
require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connect_db()
{
    try {
        return new PDO(
        DSN,
        USER,
        PASSWORD,
        [PDO::ATTR_ERRMODE =>
        PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function h($str)
{
    //ENT_QUOTES: シングルクオートとダブルクオートをともに変換する
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function find_bt_all(){
    $dbh = connect_db();
    // SQLの作成
    $sql = <<<EOM
    SELECT
        *
    FROM
        plans
    ORDER BY
        created_at
    EOM;

    // 準備
    $stmt = $dbh->prepare($sql);

    // 実行
    $stmt->execute();

    // 取得したデータを変数に代入
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function find_bt_by_id($id)
{
    // データベースに接続
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT
        *
    FROM
        plans
    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insert_bt_sql($title,$due_date){
    $dbh = connect_db();
    $sql = <<<EOM
    INSERT INTO
        plans
    (
        title,
        due_date
    )
    VALUES
    (
        :title,
        :due_date
    )
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':due_date', $due_date, PDO::PARAM_STR);
    $stmt->execute();
    header('Location: index.php');
    exit;
}

function edit_bt_sql($title,$due_date,$id){
    $dbh = connect_db();
    $sql = <<<EOM
    UPDATE
        plans
    SET
        title = :title,
        due_date = :due_date
    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':due_date', $due_date, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: index.php');
    exit;
}

function complete_check_bt($id,){
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
    $stmt->bindValue(':completion_date', , PDO::PARAM_STR);
    $stmt->execute();
    
    header('Location: index.php');
    exit;
}
function validate_required($title,$due_date){
    $errors = [];
    // バリデーション
    if ($title == '') {
        $errors[] = '学習内容が入力されていません';
    }
    if ($due_date == '') {
        $errors[] = '期限日が入力されていません';
    }
    return $errors;
}

?>
