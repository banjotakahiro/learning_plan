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
    $errors = validate_required($title, $due_date);

    if (empty($errors)) {
        edit_bt_sql($title, $due_date, $id);
    }
}

?>


<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_head.html' ?>

<!-- _head.phpの読み込み -->

<body>
    <h1 class="web_title">学習管理アプリ</h1>

    <div class="form-area">
        <h2 class="sub-title">編集</h2>
        <!-- エラー表示 -->
        <ul class="errors">
            <?php if ($errors) : ?>
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>


        <form action="" method="post">
            <span class=form_item>
                <label for="title">学習内容</label>
                <input type="text" name="title" value="<?= h($bt['title']) ?>">
            </span>
            <span class=form_item>
                <label for="due_date">期限日</label>
                <input type="date" name="due_date" value="<?= h($bt['due_date']) ?>">
            </span>
            <input type="submit" class="edit-update-btn submit-btn" value="更新">
            <a href="index.php" class="edit-return-btn ">戻る</a>
        </form>
    </div>
</body>
