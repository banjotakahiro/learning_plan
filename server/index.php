<?php
require_once __DIR__ . '/functions.php';
$title = '';
$due_date = '';

// エラーチェック用の配列
$errors = [];

// データベースに接続
// リクエストメソッドの判定
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームに入力されたデータの受け取り
    $title = filter_input(INPUT_POST, 'title');
    $due_date = filter_input(INPUT_POST, 'due_date');
    // バリデーション
    $errors = validate_required($title,$due_date);

    if (empty($errors)) {
        insert_bt_sql($title,$due_date);
    }
}

$bts = find_bt_all();

?>
<!DOCTYPE html>
<html lang="ja">

<!-- _head.phpの読み込み -->

<body>
    <div class="wrapper">
        <h1 class="title">学習管理アプリ</h1>

    <div class="form-area">
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
                <input type="text" name="title" value="<?=h($title)?>">
                <label for="due_date">期限日</label>
                <input type="date" name="due_date" value="<?=h($due_date)?>">
                <input type="submit" class="btn submit-btn" value="追加">
            </form>
        </div>
        <div class="incomplete-area">
            <h2 class="sub-title">未達成</h2>
            <table class="plan-list">
                <thead>
                    <tr>
                        <th class="plan-title">学習内容</th>
                        <th class="plan-due-date">完了期限</th>
                        <th class="done-link-area"></th>
                        <th class="edit-link-area"></th>
                        <th class="delete-link-area"></th>
                    </tr>
                </thead>
                <!-- 未完了のデータを表示 -->
                <tbody>
                    <?php foreach ($bts as $bt) : ?>
                        <?php if (empty($bt['completion_date'])):?>
                            <tr>
                                <td><?=h($bt['title'])?></td>
                                <td><?=h($bt['due_date'])?></td>
                                <td class="btn-area">
                                    <a href="change_completion_date.php?id=<?=h($bt['id'])?>" class="btn return-btn">完了</a>
                                    <a href="edit.php?id=<?=h($bt['id'])?>" class="btn edit-btn">EDIT</a>
                                    <a href="delete.php?id=<?=h($bt['id'])?>" class="btn delete-btn">DELETE</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
        <div class="complete-area">
            <h2 class="sub-title">完了</h2>
            <table class="plan-list">
                <thead>
                    <tr>
                        <th class="plan-title">学習内容</th>
                        <th class="plan-completion-date">完了日</th>
                        <th class="done-link-area"></th>
                        <th class="edit-link-area"></th>
                        <th class="delete-link-area"></th>
                    </tr>
                </thead>
                    <!-- 完了済のデータを表示 -->
                <tbody>
                    <?php foreach ($bts as $bt) : ?>
                        <?php if (!empty($bt['completion_date'])): ?>
                            <tr>
                                <td><?=h($bt['title'])?></td>
                                <td><?=h($bt['completion_date'])?></td>
                                <td class="btn-area">
                                    <a href="change_completion_date.php?id=<?=h($bt['id'])?>" class="btn return-btn">未完了</a>
                                    <a href="edit.php?id=<?=h($bt['id'])?>" class="btn edit-btn">EDIT</a>
                                    <a href="delete.php?id=<?=h($bt['id'])?>" class="btn delete-btn">DELETE</a>
                                </td>
                            </tr>
                        <?php endif?>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</body>
