<?php

use Symfony\Component\HttpFoundation\Cookie;

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
//
//データベースに投稿ないようを保存
if(!empty($_POST) && isset($_POST['send'])) {
  $user_id = $_SESSION['userID'];
  $date_time = date("Y-m-d H:i:s");
  $tweet_content = fun_h($_POST['tweet-input']);
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

$db_posts = db_get_tweets($dbh);
?>

<script>
  'use strict';
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
//ウェブソケットを使用して送信されたデータをサーバサイドに送信
let conn = "";
$(() =>{
  conn = new WebSocket('ws://localhost:8081');
  // if(conn && conn.readyState === 1) return false;
  conn.onopen = (event) => {
    console.log("Connection established!");
  };

  conn.onerror = (event) => {
    alert("エラーが発生しました");
  };

  conn.onmessage = (event) => {
    const dataArray = event.data.split(">");
    let divObj = createElem("div", 'post');
    let postObj=$("#js-posts").prepend(divObj);
    for(let i in dataArray) {
      let data = document.createTextNode(dataArray[i].trim());
      let pObj;
      if(i == 0) {
        pObj = createElem("p", 'post-user-detail');
        let imgObj = createElem("img", 'user-post-img');
        let spanObj = createElem("span", 'tweet-username');
        spanObj.append(data);
        pObj.append(imgObj);
        pObj.append(spanObj);
      }
      else if(i == 1){
        pObj = createElem("p", 'tweet-content');
        pObj.append(data);
      }else if(i == 2) {
        pObj = createElem("p", 'appendix');
        let spanObj= createElem("span");
        spanObj.append(data);
        pObj.append(spanObj);
      }
      divObj.append(pObj);
    }

  };
  conn.onclose = function(event) {
          alert("切断しました");
          setTimeout(open, 5000);
      };
});

function socketSend() {
  let dateObj = new Date();
  const fullYear = dateObj.getFullYear();
  const month = dateObj.getMonth();
  const date = dateObj.getDate();
  const hours = dateObj.getHours();
  const minute = dateObj.getMinutes();
  const seconds = dateObj.getSeconds();
  const username = getCookieUsername();
  const localDate = [fullYear, month, date].join("-");
  const localTime =[hours, minute, seconds].join(":");
  let postContent = $("#js-post-content").value;
  postContent = htmlentities(postContent);
  conn.send(username +
  ">"+postContent+
  ">"+localDate +" "+ localTime);
  console.log('send');
}
function close(){
  conn.close();
}

function getCookieUsername(){
    let arr = new Array();
    if(document.cookie != ''){
        let tmp = document.cookie.split('; ');
        for(let i=0;i<tmp.length;i++){
            let data = tmp[i].split('=');
            arr[data[0]] = decodeURIComponent(data[1]);
        }
    }
    return arr['username'];
}

function htmlentities(str){
  return String(str).replace(/&/g,"&amp;")
    .replace(/</g,"&lt;")
    .replace(/>/g,"&gt;")
    .replace(/"/g,"&quot;")
}

function createElem(element, className) {
  const newElement = $("<"+element + " class=" + className +">")[0];
  console.log(newElement);
  return newElement;
}
</script>

<div class='home-all-contents'>
  <div class=tweet-btn>
    <button id="js-show-popup">ツイートする</button>
  </div>
  <?php if(!empty($_SESSION["userID"])):?>
  <div class="popup" id="js-popup">
    <div class="popup-inner">
      <div class="close-btn" id="js-close-btn">
        <i class="fas fa-times"></i>
      </div>
      <button class="tweet-submit-btn" name="send" form="tweet" onclick="socketSend();" type="submit">ツイートする</button>
        <form id="tweet" class="tweet-form" method=POST>
          <textarea id="js-post-content"
          class="tweet-textarea"name="tweet-input" cols="" rows="10" wrap= "soft"required ></textarea>
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
  <?php else:?>
    <div class="popup" id="js-popup">
    <div class="popup-inner">
      <div class="close-btn" id="js-close-btn">
        <i class="fas fa-times"></i>
      </div>
      <p class="tweet-not-login">
          ログインしてください。
        </p>
    </div>
    <div class="black-background" id="js-black-bg"></div>
  </div>
  <?php endif;?>
  <div id="js-posts" class="post"></div>
  <?php foreach($db_posts as $post):?>
    <div class="post">
        <p class="post-user-detail">
          <img src="" alt="" class ="user-post-img"width="24" height="24">
          <span class="tweet-username">
            <?php print(fun_h($post['user_name']))?>
          </span>
        </p>
        <p class="tweet-content">
          <?php print(fun_h($post['tweet_content']))?></p>
        <p class="appendix">
          <span><?php print(fun_h($post['date_time']))?></span>
          <form action=?page=delete method="POST">
            <input type="hidden" name="post_id" value="
              <?php print(fun_h($post['post_id']));?>">
              <button>削除</button>
          </form>
        </p>

    </div>
  <?php endforeach;?>

</div>