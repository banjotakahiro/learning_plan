<?php
require_once __DIR__ . '/functions.php';

$title = '';
$due_date = '';
// エラーチェック用の配列
$errors = [];

$id = filter_input(INPUT_GET, 'id');

// idを用いてデータベースに接続
$bt = find_bt_by_id($id);

// リクエストメソッドの判定
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームに入力されたデータの受け取り
    $title = filter_input(INPUT_POST, 'title');
    $due_date = filter_input(INPUT_POST, 'due_date');
    // バリデーション
    $errors = validate_required($title,$due_date);

    if (empty($errors)) {
        edit_bt_sql($title,$due_date,$id);
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<!-- _head.phpの読み込み -->

<body>
    <div class="wrapper">
        <h1 class="web_title">学習管理アプリ</h1>

    <div class="form-area">
        <h3 class="sub_title">編集</h1>
        <!-- エラー表示 -->
            <?php if ($errors) : ?>
                <ul class="errors">
                    <?php foreach ($errors as $error) : ?>
                        <li><?=h($error)?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form action="" method="post">
                <label for="title">学習内容</label>
                <input type="text" name="title" value="<?=h($bt['title'])?>">
                <label for="due_date">期限日</label>
                <input type="date" name="due_date" value="<?=h($bt['due_date'])?>">
                <input type="submit" class="btn submit-btn" value="更新">
                <a href="index.php" class="btn return-btn">RETURN</a>
            </form>
        </div>
    </div>
</body>
