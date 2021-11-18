<?php

use Classes\Image\UsingUpdateInsert;
use Classes\Image\UsingGetImage;

$get_image = new UsingGetImage('user_id', $_SESSION['userID']);
$image = $get_image->usingGetImage();
$is_exit_image = false;
if (!empty($image)) {
    $is_exit_image = true;
    $image_type = $image['image_type'];
    $image_content = $image['image_content'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['image']['name'])) {
    // 画像を保存 すでに画像がデータベース内にあればupdate,なければinsertされる。
    $using_insert_update = new UsingUpdateInsert($is_exit_image);
    $result = $using_insert_update->actionImage();
    if ($result['update'] || $result['insert']) {
        $_SESSION['messageAlert'] = "画像の保存に成功しました。";
        header('Location: ?page=profiles');
        exit();
    }
}
?>

<div class="profile_all_contents">
    <div>
        <?php if ($is_exit_image) :?>
        <p>現在のプロフィール画像です。</p>
        <img src="data:<?php echo $image_type ?>;base64,<?php echo $image_content; ?>" width="100px" height="auto">
        <?php else :?>
            <p>プロフィールの画像を登録してください。</p>
        <?php endif;?>
    </div>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <?php if ($result['image'] === 'type') :?>
            <p>*写真は「.gif」、「.jpg」、「.png」の画像を指定してください</p>
        <?php endif; ?>
        <label>画像を選択:</label>
        <input type="file" name="image" required>
    </div>
    <button type="submit" class="btn">保存</button>
</form>
</div>