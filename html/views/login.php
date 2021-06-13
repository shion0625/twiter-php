<div id="login">
  <h2>login</h2>
  <p id="errMsgUser"></p>
  <label for="username">username: </label>
  <input id="input_username"type="text">
  <p id="errMsgPw"></p>
  <label for="password">password</label>
  <input id="input_password" type="password">
  <button id="loginBtn">ログイン</button>
</div>

<script>
$(() => {
  $('#loginBtn').on('click', () => {
    let is_status = true;
    $('errMsgUser').text('');
    $('errMsgPw').text('');
    const input_username = $('#input_username').val();
    const input_password = $('#input_password').val();
    if(input_username == "") {
      $('#errMsgUser').text('ユーザー名が入力されていません');
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
      data: 'username=' + $('#input_username').val() + '&password=' + $('#input_password').val(),
    }).done((response) => {
      alert("login success");
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





