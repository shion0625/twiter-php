<?php
require_once __DIR__ . '/../function.php';

if($_SERVER['REQUEST_METHOD'] != 'POST') {
  $message="無効なメソッドでの送信です。";
} else {
  $user_id = $_SESSION['userID'];
  $date_time = date("Y-m-d H:i:s");
  $tweet_content = fun_h($_POST['tweet-content']);
  try{
    $query = "INSERT INTO tweet (user_id, date_time, tweet_content) VALUES (:user_id, :date_time, :tweet_content)";
    $stmt = $dbh->prepare($query);
    $stmt->bindValue(":user_id", $user_id);
    $stmt->bindValue(":date_time", $date_time);
    $stmt->bindValue(":tweet_content", $tweet_content);
    $flag = $stmt->execute();
  }catch (PDOException $e) {
    echo "\n";
    echo $e;
    exit('データベースエラー');
  }
  if($flag) {
    echo "登録に成功しました。";
  } else {
    echo "失敗しました。";
  }
}
?>

<script>
  $(()=> {
    const popup = $('#js-popup');
    console.log(popup);
    if(!popup) return;
    $('#js-black-bg').on('click', () => {
      popup.toggleClass('is-show');
    })
    $('#js-close-btn').on('click', () => {
      popup.toggleClass('is-show');
    })
    $('#js-show-popup').on('click', ()=> {
      popup.toggleClass('is-show');
    });
  });
</script>

<div class='main-all-contents'>
  <div class=tweet-btn>
    <button id="js-show-popup">ツイートする</button>
  </div>
  <div class="popup" id="js-popup">
    <div class="popup-inner">
      <div class="close-btn" id="js-close-btn">
        <i class="fas fa-times"></i>
      </div>
      <button class="tweet-submit-btn" form="tweet">ツイートする</button>
        <form id="tweet" class="tweet-form" method=POST>
          <textarea class="tweet-textarea"name="tweet-content" cols="" rows="10" wrap= "soft"required ></textarea>
          <p class="tweet-items">
            <span class="tweet-item"><i class="fas fa-bold"></i></span>
            <span class="tweet-item"><i class="fas fa-italic"></i></span>
            <span class="tweet-item"><i class="fas fa-underline"></i></span>
            <span class="tweet-item"><i class="fas fa-link"></i></span>
            <span class="tweet-item"><i class="fas fa-paperclip"></i></span>
            <span class="tweet-item"><i class="far fa-image"></i></span>
        </p>
        </form>
    </div>
    <div class="black-background" id="js-black-bg"></div>
  </div>
</div>

