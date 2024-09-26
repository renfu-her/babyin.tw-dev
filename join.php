<?php
  require_once 'config.php';
  include "uploads/captcha/simple-php-captcha.php";
  $_SESSION['captcha'] = simple_php_captcha();



?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php include icld.'head.php'; ?>

</head>

<body>

  <!-- Navigation -->
  <?php include icld.'nav.php'; ?>
  <header>
    <div class="container">
      <div class="row">
        <div class="col-12 px-md-0">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent justify-content-md-end">
              <li class="breadcrumb-item"><a href="./">首頁</a></li>
              <li class="breadcrumb-item active" aria-current="page">加入會員</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </header>


  <!-- Page Content Start -->
  <article class="page-wrapper my-3">
    <div class="container">
      <div class="page-title">
        <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">加入會員</h2>
        <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Join Member</h4>
        <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
      </div>

      <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="750" data-aos-offset="0">
        <div class="row justify-content-center py-3">
          <div class="col-md-7 col-sm-12 my-3">
            <form method="post" action="proc.php?proc=join" enctype="multipart/form-data" onsubmit="return checkform();">
              <div class="form-group row mb-3">
                <label for="inputEmail" class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span class="text-danger">*</span>電子郵件 </label>
                <div class="col-sm-7 align-self-center">
                  <input type="text" class="form-control" id="inputEmail" placeholder="此為日後登入帳號" required name="email" value="<?=$_SESSION['join']['email']?>">
                </div>
              </div>
              
              <div class="form-group row mb-3">
                <label for="inputPassword" class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span class="text-danger">*</span>密碼</label>
                <div class="col-sm-7 align-self-center">
                  <input type="password" class="form-control" id="inputPassword" placeholder="6~15字元，至少搭配 1 個英文字母" required name="pwd">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="inputPasswordAgain" class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span class="text-danger">*</span>再次輸入密碼 </label>
                <div class="col-sm-7 align-self-center">
                  <input type="password" class="form-control" id="inputPasswordAgain" placeholder="請再輸入一次密碼" required name="repwd">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="inputUsername" class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span class="text-danger">*</span>姓名</label>
                <div class="col-sm-7 align-self-center">
                  <input type="text" class="form-control" id="inputUsername" placeholder="請填真實姓名" required name="uname" value="<?=$_SESSION['join']['uname']?>">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">性別</label>
                <div class="col-sm-7 align-self-center">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="1" <?=$_SESSION['join']['gender']=='1' || !$_SESSION['join']['gender'] ?'checked':'';?>>
                    <label class="form-check-label" for="male">男</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="2" <?=$_SESSION['join']['gender']=='2'?'checked':'';?>>
                    <label class="form-check-label" for="female">女</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">生日</label>
                <div class="col-sm-7 align-self-center">
                  <div class="row">
                    <div class="col-md-4 col-sm-12 py-2">
                      <select name="year" class="form-control">
                        <option value="0" selected="" disabled="">年</option>
                        <?php                           for($i=(date('Y')-2) ; $i>=1900 ; $i-- ){
                            $dateSelected = $_SESSION['join']['year']==$i ? 'selected="selected"' : '';
                            echo '<option value="'.$i.'" '.$dateSelected.' >'.$i.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4 col-sm-12 py-2">
                      <select name="month" class="form-control">
                        <option value="0" selected="" disabled="">月</option>
                        <?php                           for($i=1 ; $i<=12 ; $i++ ){
                            $dateSelected = $_SESSION['join']['month']==$i ? 'selected="selected"' : '';
                            echo '<option value="'.$i.'" '.$dateSelected.' >'.$i.'月</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4 col-sm-12 py-2">
                      <select name="day" class="form-control">
                        <option value="0" selected="" disabled="">日</option>
                        <?php                           for($i=1 ; $i<=31 ; $i++ ){
                            $dateSelected = $_SESSION['join']['day']==$i ? 'selected="selected"' : '';
                            echo '<option value="'.$i.'" '.$dateSelected.' >'.$i.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center" for="inputPhone"><span class="text-danger">*</span>手機</label>
                <div class="col-sm-7 align-self-center">
                  <input type="phone" class="form-control" id="inputPhone" placeholder="請輸入電話" required name="tel" value="<?=$_SESSION['join']['tel']?>">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right text-sm-left"><span class="text-danger">*</span>地址</label>
                <div class="col-sm-7">
                  <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                      <select id="city" class="form-control" name="city" data-width="fit">
                        <option value="" selected="" disabled="">縣市</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                      <select id="city" class="form-control" name="district" data-width="fit">
                      <option value="0" >鄉鎮市區</option>
                      </select>
                    </div>
                    <div class="col-md-12 col-sm-12">
                      <input type="text" class="form-control" id="address" placeholder="" required name="addr" value="<?=$_SESSION['join']['addr']?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right pr-0 align-self-center"><span class="text-danger">*</span>輸入右方驗證碼</label>
                <div class="col-sm-7  align-self-center">
                  <div class="input-group">
                    <input type="text" class="form-control align-self-center" id="verify" placeholder="" required name="captcha">
                    <div class="d-flex pl-2 align-self-center">
                      <img src="uploads/captcha/<?=$_SESSION['captcha']['image_src']?>" width="68px" height="24px" class="img-fluid captchaImg"/>
                    </div>
                    <div class="input-group-append">
                      <label class="refresh mn-0">
                        <a class="btn btn-refresh hvr-icon-spin" >更換 <i class="fas fa-sync-alt hvr-icon px-1"></i>
                        </a>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-sm-7 offset-sm-3">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="" required> 
                        我已閱讀<a href="terms.php" class="text-danger px-1" target="_blank">會員條款</a>並同意接受條款內容
                      </label>
                    </div>
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-sm-7 offset-sm-3 py-2">
                  <input type="hidden" name="fb_id" value="<?=$_SESSION['join']['fb_id']?>">
                  <button class="btn btn-lg btn-danger btn-purchase btn-block rounded-pill mb-3 hvr-grow" type="submit" >確認送出</button>
                  <button class="btn btn-lg bg-secondary text-white btn-block rounded-pill mb-3 hvr-grow" type="reset">取消重填</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </section>

    </div>
  </article>
  <!-- Page Content End -->


  <!-- Footer -->
  <?php include icld.'footer.php'; ?>

  <!-- Go top Button -->
  <a id="back-to-top" href="#" class="btn btn-lg back-to-top" role="button" title="" data-toggle="tooltip" data-placement="left">
    <p>TOP</p>
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- AOS JavaScript -->
  <script src="js/aos.js"></script>

  <!-- Custom JavaScript -->
  <script src="js/babyin.js"></script>


  <script src="js/address.js"></script>
  <script>
    
    var citySelected = '';
    var districtSelected = '';
    var selectedHtml = '';
    <?php       echo ($ary_get['err'] == 'captcha') ? 'alert("驗證碼錯誤");' : '';
      echo ($ary_get['err'] == 'email') ? 'alert("此email已經註冊過");' : '';
      echo $_SESSION['join']['city'] ? 'citySelected="'.$_SESSION['join']['city'].'";districtSelected="'.$_SESSION['join']['district'].'";' : '';
    ?>


    var cityContent = '<option value="0" >縣市</option>';

    Object.keys(address).forEach(function (key) {
      selectedHtml = citySelected==key ? 'selected="selected"' : '';
      cityContent += '<option value="'+key+'" '+selectedHtml+' >'+key+'</option>';
    });

    $('select[name="city"]')
      .html(cityContent)
      .change(function(){
        if($('select[name="city"] option:SELECTED').val() == 0){
          $('select[name="district"]').html('<option value="0" >請選擇縣市</option>');
        }else{
          var distContent = '';
          console.log(address[$('select[name="city"] option:SELECTED').val()]);
          address[$('select[name="city"] option:SELECTED').val()].forEach(function (key, value) {
            selectedHtml = districtSelected==key ? 'selected="selected"' : '';
            distContent += '<option value="'+key+'" '+selectedHtml+' >'+key+'</option>';
          });
          $('select[name="district"]').html('').html(distContent);
        }
      });
      

    <?php       echo $_SESSION['join']['city'] ? '$(\'select[name="city"]\').change();citySelected="";districtSelected="";' : '';
    ?>


    function checkform(){
      // var rem = /^[09]{2}[0-9]{8}$/;
      var ree = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      var rep = /^[A-Za-z0-9]{6,15}$/;

      if(!ree.test($('input[name="email"]').val() )){
        alert('email格式不正確');
        return false;
      }else if(!rep.test($('input[name="pwd"]').val() ) ){
        alert('密碼輸入錯誤,必須是6個英文字 or 數字');
        return false;
      }else if($('input[name="pwd"]').val() != $('input[name="repwd"]').val() ){
        alert('兩次密碼輸入不正確');
        return false;
      }else if($('select[name="year"] option:SELECTED').val()=='0' || $('select[name="month"] option:SELECTED').val()=='0' || $('select[name="day"] option:SELECTED').val()=='0' ){
        alert('請輸入生日');
        return false;
      }else if( $('select[name="city"] option:SELECTED').val()=='0' || $('select[name="district"] option:SELECTED').val()=='0' ){
        alert('請選擇正確地址');
        return false;
      }else{
        return true;
      }



    }


    $(function(){
      $('.refresh').click(function(){
        $('#loading').fadeIn(300,function(){
            $.ajax({
                type: "POST",
                url: 'proc.php?proc=captcha',
                data: '',
                error: function(xhr) {
                  $('#loading').fadeOut();
                  alert('網路錯誤');
                },
                success: function (data, status, xhr) {
                  $('#loading').fadeOut();
                  $('.captchaImg').attr('src','uploads/captcha/'+data);

                }
            });
        });
      });
    });





  </script>

  <div style="display: none;" id="loading" >
      <div class="image">
          <img src="img/loading.svg">
      </div>
  </div>
  <style>
  #loading {
      background-color: #000000;
      display: none;
      height: 100%;
      left: 0;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 10000;
      opacity: 0.8;
  }
  #loading .image {
      left: 50%;
      margin: -60px 0 0 -60px;
      position: absolute;
      top: 50%;
  }



  </style>
<?php   unset($_SESSION['join']);
?>


</body>

</html>
