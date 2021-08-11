<div id="login">
  <h2>login</h2>
  <p id="errMsgUser"></p>
  <label for="username">email: </label>
  <input id="input_email"type="text">
  <p id="errMsgPw"></p>
  <label for="password">password:</label>
  <input id="input_password" type="password">
  <button id="loginBtn">ログイン</button>
</div>

<script>
//Jsonのデコード
function decodeJson(res) {
  const resString = res.toString();
  const resObj = JSON.parse(resString);
  return resObj;
}

$(() => {
  $('#loginBtn').on('click', () => {
    let is_status = true;
    $('errMsgUser').text('');
    $('errMsgPw').text('');
    const input_email = $('#input_email').val();
    const input_password = $('#input_password').val();
    if(input_email == "") {
      $('#errMsgUser').text('メールアドレスが入力されていません。');
      is_status = false;
    }
    if(input_password == "") {
      $('#errMsgPw').text('パスワードが入力されていません');
      is_status = false;
    }
    if(is_status) {
      $.ajax({
      type: 'POST',
      url: 'action.php?action=login',
      data: 'email=' + $('#input_email').val() + '&password=' + $('#input_password').val(),
    }).done((response) => {
      if(!response) {
        alert('ユーザが見つかりませんでした。');
      } else {
        const responseObj = decodeJson(response);
        alert("ユーザが見つかりました。");
        console.log(responseObj);
      }
    }).fail((xhr) =>  {
      console.log('login fail');
      alert('login fail');
    }).always((xhr, msg) => {
      console.log(xhr);
      console.log(msg);
    });
    }
  });
});
</script>





