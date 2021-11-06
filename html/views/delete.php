<?php

$post_id = trim(fun_h($_POST["post_id"]));
$tweet_data = db_get_tweet($post_id)[0];
?>
<div class="delete-all-contents">
  <form method="post">
    <div>
      <label for="view_name">表示名</label>
      <input id="view_name" type="text" name="view_name" value="
      <?php if(!empty($tweet_data['user_name'])){echo $tweet_data['user_name'];}
      elseif( !empty($tweet_data['user_name']) ){
        echo fun_h( $tweet_data['user_name']);
      } ?>" disabled>
    </div>
    <div>
      <label for="message">投稿内容</label>
      <textarea id="message" name="message" disabled>
        <?php if( !empty($tweet_data['tweet_content']) )
        { echo $tweet_data['tweet_content'];}
        elseif( !empty($tweet_data['tweet_content']) )
        { echo fun_h( $tweet_data['tweet_content']);}?>
      </textarea>
    </div>
    <a class="btn_cancel" href="/">キャンセル</a>
    <input type="submit" name="btn_submit" value="削除">
    <input type="hidden" name="message_id" value="
    <?php if( !empty($tweet_data['post_id']) )
      { echo $tweet_data['post_id']; }
    elseif( !empty($post_id) )
      { echo fun_h( $post_id);} ?>">
  </form>
</div>
