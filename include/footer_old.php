

<?php
  $ary_page['css']['shareBtnShow'] = strpos($_SERVER['REQUEST_URI'],'index.php') || !strpos($_SERVER['REQUEST_URI'],'.php') ? '
    <div class="floatingIcon">
      <div class="topBtn_list">
        <ul class="nav flex-column text-right">
          <li class="nav-item my-2">
            <a class="nav-link" href="https://www.facebook.com/babyin1688/" target="_blank" ><img src="./img/fb.png"></a>
          </li>
          <!--<li class="nav-item my-2">
           <a class="nav-link" href="https://line.me/ti/p/babyin1688" target="_blank" ><img src="./img/line.png"></a> 
          </li>-->
          <li class="nav-item my-2">
            <a class="nav-link" href="https://line.me/ti/p/@zfa7556c" target="_blank" ><img src="./img/line@.png"></a>
          </li>
        </ul>
      </div>
    </div>

  ' : '' ;
?>


  <script>
      <?php
          echo ($ary_get['status'] == 'succJoin') ? 'alert("您已成功加入會員，歡迎開始購物");' : '';
          echo ($ary_get['status'] == 'loginErr') ? 'alert("帳號密碼錯誤!");' : '';
          echo ($ary_get['status'] == 'logout') ? 'alert("成功登出!");' : '';
          echo ($ary_get['status'] == 'loginSucc') ? 'alert("成功登入!");' : '';
          echo ($ary_get['status'] == 'succPersonalEdit') ? 'alert("成功編輯!");' : '';
          echo ($ary_get['status'] == 'succForgetEmail') ? 'alert("您的密碼已經寄出 ，請至您的信箱收信!");' : '';
          echo ($ary_get['status'] == 'forgetNoEmail') ? 'alert("無此帳號!");' : '';
      ?>
  </script>


  <footer class="bg-footer d-flex align-items-center">
    <div class="container">
      <div class="row flex-row">
        <div class="col-auto my-3">
          <div class="row my-md-0 my-2">
            <div class="col-md-12 col-4">
              <img src="img/brand_logo_gray.png">
            </div>
            <div class="col-md-12 col-8">
              <div class="row">
                <div class="col-auto">
                  <p class="m-0 text-dark"><i class="fas fa-phone-volume"></i> (02)2302-5558</p>
                </div>
                <div class="col-auto pl-md-0">
                  <p class="m-0 text-dark"><img src="https://img.icons8.com/pastel-glyph/18/000000/place-marker.png"> 台北市萬華區莒光路302號</p>
                </div>
                <div class="col-auto pl-md-0">
                  <p class="m-0 text-dark"><i class="far fa-clock"></i> 營業時間 : <br class="d-md-none"><span class="pl-md-0 pl-3">上午09:00~下午06:00(全年無休)</span></p>
                </div>
              </div>
            </div>
          </div>
          <p class="m-0 text-dark">&copy; 2019 All Rights Reversed. babyin Co., Ltd. All rights reserved.</p>
        </div>
        <div class="col-auto social-link order-first order-md-0 ml-auto d-flex align-items-center">
          <a href="https://www.facebook.com/babyin1688/" target="_blank" class="px-3 hvr-bob"><img src="./img/fb.png"></a>
          <!-- <a href="https://line.me/ti/p/babyin1688" target="_blank" class="px-3 hvr-bob"><img src="./img/line.png"></a> -->
          <a href="https://line.me/ti/p/@zfa7556c" target="_blank" class="px-3 hvr-bob"><img src="./img/line@.png"></a>
        </div>
      </div>
    </div>


    <!-- Floating Icon Group -->
    <?php echo $ary_page['css']['shareBtnShow']?>
    <!-- /.container -->
  </footer>


  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174267163-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-174267163-1');
  </script>
