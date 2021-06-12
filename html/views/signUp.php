<div id="contents_signUp">
  <h2>会員登録</h2>
  <p id="errMsgUser"></p>
  <label for="input_username">ユーザ名: </label>
  <input type="text" id="input_username" placeholder="ユーザー名を入力してください">
  <p id="errMsgEmail"></p>
  <label for="input_email">メールアドレス:</label>
  <input type="email" id="input_email" placeholder="メールアドレスを入力してください">
  <p id="errMsgPw"></p>
  <label for="input_password">パスワード</label>
  <input type="password" id="input_password" placeholder="パスワードを入力してください">
  <button id="signUpBtn">会員登録</button>
</div>

<script>
$(()=> {
  $('#signUpBtn').on('click',() => {
    let is_status = true;
    $('#errMsgUser').text('');
    $('#errMsgEmail').text('');
    $('#errMsgPw').text('');
    //メールアドレスの正規表現
    const regexp = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
    const input_username = $('#input_username').val();
    const input_email = $('#input_email').val();
    const input_password = $('#input_password').val();
    if(input_username == "") {
      $('#errMsgUser').text('ユーザー名が入力されていません');
      is_status = false;
    }
    if(input_email == "") {
      $('#errMsgEmail').text('メールアドレスが入力されていません');
      is_status = false;
    } else {
      if(!regexp.test(input_email)) {
      $('#errMsgEmail').text('間違ったメールアドレスです。');
      is_status = false;
      }
    }
    if(input_password == "") {
      $('#errMsgPw').text('パスワードが入力されていません');
      is_status = false;
    }
    if(is_status) {
      $.ajax({
      type: 'POST',
      url: 'action.php?action=signUp',
      data: 'username=' + $('#input_username').val() + '&email=' + $('#input_email').val() + '&password=' + $('#input_password').val(),
    }).done((response) => {
      alert("success");
    }).fail((xhr) =>  {
      console.log('fail');
      alert('fail');
    }).always((xhr, msg) => {
      console.log(xhr);
      console.log(msg);
    });
    }
  });
});
</script>