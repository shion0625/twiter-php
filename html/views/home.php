<?php
use Classes\Post\InsertPost;
use Classes\Post\GetHomePosts;

//データベースに投稿内容を保存
if (!empty($_POST) && isset($_POST['send'])) {
    $user_id = (string)fun_h($_SESSION['userID']);
    $post_text = (string)fun_h($_POST['tweet-input']);
    $insert_post_db = new InsertPost($user_id, $post_text);
    $insert_post_db->checkInsertTweet();
}
//投稿内容をデータベースから取得
$get_post_db = new GetHomePosts();
$db_posts = $get_post_db->getHomePosts();
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
    const username = <?php echo json_encode($_SESSION['username']); ?>;
    const localDate = [fullYear, month, date].join("-");
    const localTime =[hours, minute, seconds].join(":");
    let postContent = $("#js-post-content").val();
    console.log(postContent);
    postContent = htmlentities(postContent);
    conn.send(username +
    ">"+postContent+
    ">"+localDate +" "+ localTime);
    console.log('send');
}
function close(){
    conn.close();
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
    <?php if (!empty($_SESSION["userID"])) :?>
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
    <?php else :?>
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
    <?php foreach ($db_posts as $post) :?>
    <div class="post">
        <p class="post-user-detail">
        <?php if (isset($post['image_type']) && isset($post['image_content'])) :
            $image_content = base64_encode($post['image_content']);?>
            <img src="data:<?php echo $post['image_type'] ?>;base64,<?php echo $image_content; ?>" width="40px" height="auto">
        <?php endif;?>
        <span class="tweet-username">
            <?php print(fun_h($post['user_name']))?>
        </span>
        </p>
        <p class="tweet-content">
        <?php print(fun_h($post['post_text']))?>
        </p>
        <p class="appendix">
        <span><?php print(fun_h($post['date_time']))?></span>
        <?php if ($post['user_name'] == $_SESSION['username']) :?>
            <form action=?page=delete method="POST">
                <input type="hidden" name="post_id" value="
                <?php print(fun_h($post['post_id']));?>">
                <button>削除</button>
            </form>
        <?php endif;?>
        </p>
    </div>
    <?php endforeach;?>

</div>