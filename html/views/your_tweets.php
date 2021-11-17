<?php
use Classes\GetYourPosts;

    $get_your_posts = new GetYourPosts($_SESSION['userID']);
    $your_posts = $get_your_posts->getYourPosts();
?>
<div class=your-tweets-all-contents>
    <h2>あなたのツイート</h2>
    <?php if (empty($your_posts)) :
        echo "あなたはまだ投稿していません。";?>
    <?php else :?>
        <?php foreach ($your_posts as $post) :?>
            <div class="post">
                <p class="post-user-detail">
                <img src="" alt="" class ="user-post-img"width="24" height="24">
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