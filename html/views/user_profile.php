<?php

use Classes\Image\UsingUpdateInsert;
use Classes\Image\UsingGetImage;
use Classes\User\GetUserInfo;
use Classes\Follow\CheckFollow;
use Classes\Follow\GetNumFollow;

$profile_user_id = (string)$_GET['id'];

$get_user_info = new GetUserInfo($profile_user_id);
$user_post = $get_user_info->getUserPost();
$user_profile = $get_user_info->getUserProfile();
$current_user_id = $_SESSION['userID'];
$_SESSION['messageAlert'] ='';

$get_image = new UsingGetImage('user_id', $profile_user_id);
$image = $get_image->usingGetImage();
$is_exit_image = false;
if (!empty($image)) {
    $is_exit_image = true;
    $image_type = $image['image_type'];
    $image_content = $image['image_content'];
}

//このページに送信されたユーザIDが自分だった場合設定ページが表示される。
$is_yourself = $profile_user_id == $current_user_id;
if ($is_yourself) {
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
}
if (!$is_yourself) {
    $CheckFollow=new CheckFollow($current_user_id, $profile_user_id);
    $is_follow = $CheckFollow->isCheckFollow();
    if ($is_follow) {
        $follow_button_text="フォロー中";
    }
    if (!$is_follow) {
        $follow_button_text="フォロー";
    }
}
$GetNumFollow = new GetNumFollow($profile_user_id);
$follow_num = $GetNumFollow->numFollow();
$follower_num= $GetNumFollow->numFollower();
?>

<script>
$(document).on('click','#js-follow-btn',(e)=>{
    e.stopPropagation();
    let current_user_id = $('#js-current-user-id').val();
    let profile_user_id = $('#js-profile-user-id').val();
    let formData = new FormData();
    formData.append('current_user_id', current_user_id);
    formData.append('profile_user_id', profile_user_id);
    $.ajax({
        type: 'POST',
        url: 'views/ajax_follow_process.php',
        dataType: 'json',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function(data){
        if(data.success) {
            $('.display-follow-button').text('フォロー');
        } else {
            $(".display-follow-button").text('フォロー中');
        }
        $('#js-follow').text(data.follow);
        $("#js-follower").text(data.follower);
        console.log(data);
    }).fail(function(data){
        console.log(data.responseText);
        console.log('fail');
    });
});
</script>

<div class="user-profile-all-contents">
    <div class="user-profile">
        <div class="profile-image">
            <?php if ($is_exit_image) :?>
                <img src="data:<?php echo $image_type ?>;base64,<?php echo $image_content; ?>" width="100px" height="auto">
            <?php else :?>
                <p>プロフィールの画像を登録してください。</p>
            <?php endif;?>
        </div>
        <p><?php echo $user_profile['user_name']?></p>
        <p>フォロー</p>
        <p id="js-follow"><?php echo $follow_num?></p>
        <p>フォロワー</p>
        <p id="js-follower"><?php echo $follower_num?></p>
        <?php if (!$is_yourself) :?>
            <form action="#" method="post">
                <input
                    type="hidden"
                    id="js-current-user-id"
                    value="<?= $current_user_id ?>">
                <input
                    type="hidden"
                    id="js-profile-user-id"
                    value="<?= $profile_user_id ?>">
                    <button
                        id="js-follow-btn"
                        class="display-follow-button"
                        type="button"
                        name="follow">
                        <?php echo $follow_button_text ?>
                    </button>
            </form>
        <?php endif;?>
    </div>

    <div class=user-tweets-contents>
        <?php if (empty($user_post)) :
            echo "あなたはまだ投稿していません。";?>
        <?php else :?>
            <?php foreach ($user_post as $post) :?>
                <div class="post">
                    <p class="post-user-detail">
                    <img src="data:<?php echo $post['image_type'] ?>;base64,<?php echo $image_content; ?>" width="40px" height="auto">
                    <span class="tweet-username">
                        <?php print(fun_h($post['user_name']))?>
                    </span>
                    </p>
                    <p class="tweet-content">
                        <?php print(fun_h($post['tweet_content']))?>
                    </p>
                    <p class="appendix">
                        <span><?php print(fun_h($post['date_time']))?></span>
                        <form action=?page=delete method="POST">
                            <input type="hidden" name="post_id" value="<?php print(fun_h($post['post_id']));?>">
                            <button>削除</button>
                        </form>
                    </p>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>

    <?php if ($is_yourself) :?>
        <div class="setting-profile-contents">
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
    <?php endif;?>
</div>