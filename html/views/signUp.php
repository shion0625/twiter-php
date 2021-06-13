<div id="signUp_all_contents">
  <div id="sns_contents">
    <h2>SNSアカウントでログイン</h2>
  </div>
  <div id="signUp_contents">
    <h2>会員登録</h2>
    <div id="signUp_main">
      <div id="username_box" class="box_setting">
        <p id="errMsgUser" class="errMsg"></p>
        <p class="require_pos"><label for="input_username">ユーザ名:</label><span class="require">必須</span></p>
        <input type="text" id="input_username" placeholder="ユーザー名を入力してください" size="30" spellcheck="true">
      </div>
      <div id="email_box" class="box_setting">
        <p id="errMsgEmail" class="errMsg"></p>
        <p class="require_pos"><label for="input_email">メールアドレス:</label><span class="require">必須</span></p>
        <input type="email" id="input_email" placeholder="メールアドレスを入力してください" size="30">
      </div>
      <div id="password_box" class="box_setting">
        <p id="errMsgPw" class="errMsg"></p>
        <p class="require_pos"><label for="input_password">パスワード</label><span class="require">必須</span></p>
        <input type="password" id="input_password" size="30">
        <i id="eye-icon"class="fas fa-eye"></i>
        <p>条件:大文字、小文字、数字、記号のすべてを最低一文字は使用して下さい</p>
        <p><small>パスワードは8文字以上24文字以下で入力してください。使用可能な記号は(. / ? -)です。</small></p>
      </div>
      <button id="signUpBtn">会員登録</button>
    </div>
  </div>
</div>

<script>
$(()=> {
  $('#eye-icon').on('click',() => {
    const input = $('#input_password');
    if (input.attr('type') == 'password') {
      input.attr('type','text');
    } else {
      input.attr('type','password');
    }
    $('#eye-icon').toggleClass('fa-eye');
    $('#eye-icon').toggleClass('fa-eye-slash');
  });
});

$(()=> {
  $('#signUpBtn').on('click',() => {
    let is_status = true;
    $('#errMsgUser').text('');
    $('#errMsgEmail').text('');
    $('#errMsgPw').text('');
    //メールアドレスの正規表現
    const regexpEm = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
    const regexpPw =/ ^(?=.*[A-Z])(?=.*[.?/-])[a-zA-Z0-9.?/-]{8,24}$ /
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
      if(!regexpEm.test(input_email)) {
      $('#errMsgEmail').text('間違ったメールアドレスです。');
      is_status = false;
      }
    }
    if(input_password == "") {
      $('#errMsgPw').text('パスワードが入力されていません');
      is_status = false;
    } else if(!regexpPw.test(input_password)) {
      let msg = 'パスワードの条件を満たしていません';
      $('#errMsgPw').html(msg.replace(/\n/g, '<br>'));
      is_status = false;
    }

    if(is_status) {
      $.ajax({
      type: 'POST',
      url: 'action.php?action=signUp',
      data: 'username=' + $('#input_username').val() + '&email=' + $('#input_email').val() + '&password=' + $('#input_password').val(),
    }).done((response) => {
      alert("signUp success");
    }).fail((xhr) =>  {
      console.log('signUp fail');
      alert('signUp fail');
    }).always((xhr, msg) => {
      console.log(xhr);
      console.log(msg);
    });
    }
  });
});
</script>