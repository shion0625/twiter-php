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
      <button class="tweet-submit-btn">ツイートする</button>
      <a href="#">
        <img src="../assets/img/wood-591631_1920.jpg" alt="ポップアップ画像">
        </a>
        <form method=POST>
        </form>
    </div>
    <div class="black-background" id="js-black-bg"></div>
  </div>
</div>

