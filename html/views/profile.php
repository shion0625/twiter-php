<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得
} else {
    // 画像を保存
    if (!empty($_FILES['image']['name'])) {
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $ext = explode("/", (string)$type)[1];
        if ($ext != 'jpeg' && $ext != 'png' && $ext != 'gif' && $ext != 'jpg') {
            $error['image'] = 'type';
        } else {
            $content = file_get_contents($_FILES['image']['tmp_name']);
            $size = $_FILES['image']['size'];
            $flag = db_insert_image($name, $type, $content, $size, $_SESSION['userID']);
        }
    }
    header('Location: ?page=profiles');
    exit();
}
?>

<div class="profile_all_contents">
<form method="post" enctype="multipart/form-data">
  <div class="form-group">
    <?php if ($error['image'] === 'type'):?>
      <p>*写真は「.gif」、「.jpg」、「.png」の画像を指定してください</p>
      <?php endif; ?>
    <label>画像を選択:</label>
    <input type="file" name="image" required>
  </div>
  <button type="submit" class="btn">保存</button>
</form>
</div>