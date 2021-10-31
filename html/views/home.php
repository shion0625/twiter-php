<?php
require_once __DIR__ . '/../function.php';
require  __DIR__ . '/../db_function.php';

if(isset($_SESSION['userID']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $result = db_user_details($dbh);
  setcookie('username', fun_h($result['user_name']),time()+60*60*24*14);
} else {
  // header("Location: ?page=login");
  // exit();
}

// if($_SERVER['REQUEST_METHOD'] != 'POST') {
//   $message="無効なメソッドでの送信です。";
// }
if(!empty($_POST) && isset($_POST['send'])) {
  $user_id = $_SESSION['userID'];
  $date_time = date("Y-m-d H:i:s");
  $tweet_content = fun_h($_POST['tweet-content']);
  $flag = db_insert_tweet($dbh, $user_id, $date_time, $tweet_content);
  if($flag) {
    $message_alert = "ツイートに成功しました。";
    $_SESSION['messageAlert'] = fun_h($message_alert);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
  } else {
    $message_alert = "ツイートに失敗しました。";
    $_SESSION['messageAlert'] = fun_h($message_alert);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
  }
}

$posts = db_get_tweets($dbh);
?>

<script>
  $(()=> {
    const popup = $('#js-popup');
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

const conn = "";
function open() {
  const conn = new WebSocket('wss://localhost:8081');
  console.log('connect');
  conn.onopen = function(e) {
    console.log("Connection established!");
  };
  conn.onerror = function(e) {
    alert("エラーが発生しました。");
  }
}

//   conn.onmessage = function(e) {
//     const data = JSON.parse(e.data);
//     const divObj = document.createElement("DIV");
//     if (data["position"] == "left") {
//       divObj.className = 'receive-msg-left';
//     } else {
//       divObj.className = 'receive-msg-right';
//     }
//     const msgSplit = data["msg"].split('\n');
//     for (let i in msgSplit) {
//       const msg = document.createTextNode(msgSplit[i]);
//       const rowObj = document.createElement("DIV");
//       rowObj.appendChild(msg);
//       divObj.appendChild(rowObj);
//     }
//     var msgLog = document.getElementById("msg_log");
//     msgLog.appendChild(divObj);
//     var br = document.createElement("BR");
//     br.className = 'br';
//     msgLog.appendChild(br);
//     msgLog.scrollTop = msgLog.scrollHeight;
//       };
//     conn.onclose = function() {
//       alert("切断しました");
//       setTimeout(open, 5000);
//     };
//   }
// function send(){
//   conn.send(document.getElementById("msg").value);
// }
// function close(){
//   conn.close();
// }
// open();


// conn.send('hello world');
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
      <button class="tweet-submit-btn" name="send" form="tweet">ツイートする</button>
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
  <?php foreach($posts as $post):?>
    <div class="post">
        <p>
          <img src="" alt="" width="24" height="24">          <span class="tweet-username">
            <?php print(fun_h($post['user_name']))?>
          </span></p>
          <p><?php print(fun_h($post['tweet_content']))?></p>
          <p>
            <a href=""><?php print(fun_h($post['date_time']))?></a>
            <a href="delete.php" style="color:F33;">削除</a>
          </p>

    </div>
  <?php endforeach;?>

</div>